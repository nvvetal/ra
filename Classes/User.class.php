<?php

class User
{
    var $dbh;

    var $user_values = array();

    function User($dbh){
        $this->dbh = $dbh;
    }

    function authorize_user_by_login_pass($login, $password){
        $phpBB = new PHPBB();
        $query = "
            SELECT *
            FROM users
            WHERE login=".SQLQuote($login)."
            LIMIT 1
        ";
        $user = SQLGet($query,$this->dbh);
        if(!isset($user['user_id'])) return false;
        if($user['password'] == md5($password)) return true;
        if($phpBB->checkHash($password, $user['password'])) return true;
        return false;
    }

    function login($params){
        return $this->authorize_user_by_login_pass($params['login'],$params['password']);
    }

    function password_back($params){
        $is_exists = $this->is_user_exists($params);
        //var_dump($params);
        if($is_exists == false) return false;
        $mailParams = array(
            'from'      => 'admin@'.$_SERVER['HTTP_HOST'],
            'fromName'  => 'Администрация RAKS.com.ua',
            'subject'   =>  $params['email_subject'],
            'body'      =>  $params['email_content'],
            'to'        => array(array('email' => $params['email'])),
        );
        /** @var $mailer Mail */
        $mailer = Registry::get('mailer');
        $mailer->sendMail($mailParams);
        $user = $this->find_user_by_email($params['email']);
        $this->set_value($user['user_id'],'password',md5($params['email_password']));
        return true;
    }

    function send_register_key($params){
        $mailParams = array(
            'from'      => 'admin@'.$_SERVER['HTTP_HOST'],
            'fromName'  => 'Администрация RAKS.com.ua',
            'subject'   =>  $params['email_subject'],
            'body'      =>  $params['email_content'],
            'to'        => array(array('email' => $params['email'])),
        );
        /** @var $mailer Mail */
        $mailer = Registry::get('mailer');
        $mailer->sendMail($mailParams);
        return true;
    }

    function init_values($user_id, $u_data=array(),$is_need_data=1){
        $values = array();
        if(is_array($u_data) && count($u_data)>0){
            $values = $u_data;
        }else{
            $query="
                SELECT *
                FROM users
                WHERE user_id = ".SQLQuote($user_id)."
            ";
            $u_data = SQLGet($query,$this->dbh);
            if($u_data!==false){
                foreach ($u_data as $key=>$value){
                    $values[$key]=$value;
                }
            }
        }

        if($is_need_data == 0) {
            $this->user_values[$user_id]=$values;
            return true;
        }

        $query="
            SELECT *
            FROM users_data
            WHERE user_id = ".SQLQuote($user_id)."
        ";
        $rows = SQLGetRows($query,$this->dbh);
        foreach ($rows as $key=>$row){
            $values[$row['u_param']] = $row['u_value'];
        }
        $q = "
            SELECT user_reputation
            FROM phpbb_users
            WHERE user_id = ".SQLQuote($this->find_forum_by_user_id($user_id))."
            LIMIT 1
        ";
        //echo $q;
        $DBFactory = Registry::get('DBFactory');
        $data = SQLGet($q, $DBFactory->get_db_handle('forum'));
        if(isset($data['user_reputation'])) $values['user_reputation'] = $data['user_reputation'];

        $this->user_values[$user_id]=$values;
    }

    function get_value($user_id,$key){

        if(!isset($this->user_values[$user_id])){
            $this->init_values($user_id);
        }
        return isset($this->user_values[$user_id][$key]) ? $this->user_values[$user_id][$key] : null;
    }

    function set_value($user_id,$key,$value){
        if(!isset($this->user_values[$user_id])){
            $this->init_values($user_id);
        }
        switch ($key){
            case "password":
            case "email":
            case "type":
            case "state":
            case "is_autologin":
            case "lastEnterTime":
            case "act_key":
                $this->set_user_value($user_id,$key,$value);

                break;

            default:
                $this->set_user_data($user_id,$key,$value);
                break;
        }


        $this->user_values[$user_id][$key] = $value;
    }

    function set_values($user_id,$values){
        if( !is_array($values) || count($values) == 0 ) return ;

        foreach ($values as $key=>$value){

            $this->set_value($user_id,$key,$value);
        }
    }

    function set_user_data($user_id,$key,$value){
        $query = "
            REPLACE INTO users_data (user_id,u_param,u_value)
            VALUES (".SQLQuote($user_id).",".SQLQuote($key).",".SQLQuote($value).")
        ";
        SQLQuery($query,$this->dbh);
    }

    function set_user_value($user_id,$key,$value){
        //forum password set
        if($key == 'password'){
            $username = $this->get_value($user_id,'login');
            $dbh_forum = Registry::get('DBFactory')->get_db_handle("forum");
            $query = "
                UPDATE phpbb_users
                SET user_password = ".SQLQuote($value)."
                WHERE username = ".SQLQuote($username)."
            ";
            SQLQuery($query,$dbh_forum);
        }

        if($key == 'state' && in_array($value,array('not_active','active'))){
            $username = $this->get_value($user_id,'login');
            if($value=='not_active'){
                $new_key = md5(microtime(true).mt_rand(1000,1000000));
                $user_type = 1;
            }else{
                $new_key = '';
                $user_type = 0;
            }
            $dbh_forum = Registry::get('DBFactory')->get_db_handle("forum");
            $query = "
                UPDATE phpbb_users
                SET user_actkey = ".SQLQuote($new_key).", user_type = $user_type
                WHERE username = ".SQLQuote($username)."
            ";
            SQLQuery($query,$dbh_forum);
            $this->set_value($user_id,'act_key',$new_key);
        }

        $query = "
            UPDATE users
            SET $key = ".SQLQuote($value)."
            WHERE user_id = ".SQLQuote($user_id)."
        ";
        SQLQuery($query,$this->dbh);
    }

    function register_user($params, $encodePassword = true){

        $is_user_exists = $this->is_user_exists( $params );
        if( $is_user_exists == true ) return false;
        $state = $GLOBALS['NEED_ACTIVATION_TO_REGISTER'] == false ? 'active' : 'not_active';
        if(isset($params['state'])) $state = $params['state'];
        $fields = array(
            'login'         => $params['login'],
            'password'      => ($encodePassword) ? md5($params['password']) : $params['password'],
            'email'         => $params['email'],
            'type'          => 'user',
            'state'         => $state,
            'lastEnterTime' => time(),
            'createdTime'   => time(),
        );
        SQLInsert('users',$fields,$this->dbh);
        $user_id = SQLInsId($this->dbh);
        add_to_log("[user_id $user_id][login {$fields['login']}][email {$fields['email']}][type {$fields['type']}][state {$fields['state']}]",'register');
        return $user_id;
    }

    function set_cookie($key,$value,$time=''){
        $time = (!empty($time)) ? $time : time();
        setcookie($key, $value, $time);
    }

    function set_cookie_autologin( $user_id, $sess_id, $cookie_end_time, $prefix = 'rakscom' ){
        $s_time = time().mt_rand();
        $s_key =  md5($sess_id.$user_id.$s_time.'baba_nastya');

        setcookie($prefix.'_user_id', $user_id, $cookie_end_time);
        setcookie($prefix.'_s', $sess_id, $cookie_end_time);
        setcookie($prefix.'_s_key', $s_key, $cookie_end_time);

        $this->set_value( $user_id, 'cookie_session', $sess_id);
        $this->set_value( $user_id, 'cookie_session_key', $s_key);
        $this->set_value( $user_id, 'cookie_session_time', $s_time);


    }

    function is_user_exists( $params ){
        $check = array();
        if(isset($params['login'])){
            $check[] = 'login = '.SQLQuote($params['login']);
        }

        if(isset($params['email'])){
            $check[] = 'email = '.SQLQuote($params['email']);
        }
        $query="
            SELECT *
            FROM users
            WHERE ".implode(' OR ',$check)."
            LIMIT 1
        ";
        return (SQLGet($query,$this->dbh)!==false) ? true : false;
    }

    function is_user_id_exists( $user_id ){
        $query="
                SELECT *
                FROM users
                WHERE user_id = ".SQLQuote($user_id)."
                LIMIT 1
            ";
        return (SQLGet($query,$this->dbh)!==false) ? true : false;
    }

    function find_user_id_by_login( $login ){
        $query = "
            SELECT user_id
            FROM users
            WHERE login = ".SQLQuote($login)."
            LIMIT 1
        ";
        $user = SQLGet($query,$this->dbh);
        $user_id = ($user === false) ? 0 : $user['user_id'];
        return $user_id;
    }

    function find_user_by_email($email){
        $query = "
            SELECT *
            FROM users
            WHERE email = ".SQLQuote($email)."
        ";
        return SQLGet($query,$this->dbh);
    }

    function find_forum_by_user_id($user_id){
        $query = "
            SELECT u_value
            FROM users_data
            WHERE user_id = ".SQLQuote($user_id)." AND u_param = 'forum'
            LIMIT 1
        ";
        $data = SQLGet($query,$this->dbh);
        return (isset($data['u_value'])) ? $data['u_value'] : false;
    }

    function findUserIdByForumId($userForumId){
        $query = "
            SELECT user_id
            FROM users_data
            WHERE u_value = ".SQLQuote($userForumId)." AND u_param = 'forum'
            LIMIT 1
        ";
        $data = SQLGet($query,$this->dbh);
        return (isset($data['user_id'])) ? $data['user_id'] : false;
    }

    function get_users($search='*',$page=0,$per_page=30){
        if($per_page < 1) $per_page = 30;
        $per_page = intval($per_page);
        if(empty($search) || $search == '*'){
            $search = '%';
        }else{
            $search = str_replace('*','%',$search).'%';
        }

        $cur_page = $page * $per_page;

        $query = "
            SELECT *
            FROM users
            WHERE login LIKE ".SQLQuote($search)."
            ORDER BY login ASC
            LIMIT $cur_page, $per_page
        ";
        return SQLGetRows($query,$this->dbh);
    }

    function get_users_pages($search='*',$per_page=30){
        if($per_page < 1) $per_page = 30;
        $per_page = intval($per_page);
        if(empty($search) || $search == '*'){
            $search = '%';
        }else{
            $search = str_replace('*','%',$search).'%';
        }
        $query = "
          SELECT COUNT(*) AS cnt
          FROM users
            WHERE login LIKE ".SQLQuote($search)."
        ";
        $data = SQLGet($query,$this->dbh);
        $pages = ceil($data['cnt'] / $per_page);
        return $pages;
    }

    function delete_user($user_id){
        $forum_id = $this->get_value($user_id,'forum');
        $query = "DELETE FROM users WHERE user_id = ".SQLQuote($user_id);
        SQLQuery($query,$this->dbh);
        $this->delete_user_params($user_id);
        if(empty($forum_id)) return true;
        $dbh_forum = Registry::get('DBFactory')->get_db_handle("forum");
        $query = "
            DELETE FROM phpbb_users
            WHERE user_id = ".SQLQuote($forum_id)."
        ";
        SQLQuery($query,$dbh_forum);
    }

    function delete_user_params($user_id){
        $query = "DELETE FROM users_data WHERE user_id = ".SQLQuote($user_id);
        SQLQuery($query,$this->dbh);
    }

    function find_inactive_users(){
        $query = "
            SELECT *
            FROM users
            WHERE state = 'not_active' AND lastEnterTime < UNIX_TIMESTAMP(FROM_UNIXTIME(UNIX_TIMESTAMP()) - INTERVAL 1 DAY)
        ";
        return SQLGetRows($query,$this->dbh);
    }

    function get_raks_money($user_id){
        $raksMoney = $this->get_value($user_id,'raks_money');
        if(is_null($raksMoney)) $raksMoney = 0;
        return $raksMoney;
    }

    function set_raks_money($user_id,$money){
        $this->set_value($user_id,'raks_money',$money);
    }

    function can_pay_raks_money($user_id,$cost){
        $raksMoney = $this->get_raks_money($user_id);
        $canPay = ($raksMoney >= $cost) ? true : false;
        return array(
            'ok' => $canPay,
            'needMoney' => ($canPay == false) ? ($raksMoney-$cost)*-1: 0,
        );
    }

    function pay_raks_money($user_id,$amount){
        $raksMoney = $this->get_raks_money($user_id);
        $this->set_raks_money($user_id,$raksMoney-$amount);
    }

    function inc_raks_money($user_id,$amount){
        $raksMoney = $this->get_raks_money($user_id) + $amount;
        $this->set_raks_money($user_id,$raksMoney);
    }

    function set_session_data($key,$value){
        $_SESSION[$key] = $value;
    }

    function get_session_data($key){
        return isset($_SESSION[$key]) ? $_SESSION[$key] : false;
    }

    function findUsersBy($params)
    {
        $where = array();
        $join  = '';
        $cnt   = 0;
        switch ($params['type']){
            case "login":
                $where[] = 'u.login LIKE '.SQLQuote('%'.$params['search'].'%');
                break;
            case "first_name":
                $join = 'INNER JOIN users_data as ud ON (u.user_id = ud.user_id)';
                $where[] = 'ud.u_param = "p_first_name" AND u_value LIKE '.SQLQuote('%'.$params['search'].'%');
                break;
            case "city":
                $join = "
                    INNER JOIN users_data as ud ON (u.user_id = ud.user_id)
                    INNER JOIN cities as c ON (c.name LIKE ".SQLQuote('%'.$params['search'].'%').")
                ";
                $where[] = 'ud.u_param = "p_city_id" AND ud.u_value = c.id';
                break;

            case "user_letter":
                $where[] = 'u.login LIKE '.SQLQuote($params['search'].'%');
                break;

            case "all":

                break;
        }

        $qCnt = "
            SELECT COUNT(u.user_id) as cnt
            FROM  users as u
            $join
        ";

        $q = "
            SELECT u.*
            FROM users as u
            $join
        ";

        if(count($where) > 0) {
            $q = $q."WHERE ".implode(' AND ', $where);
            $qCnt = $qCnt."WHERE ".implode(' AND ', $where);
        }
        $q = $q.' ORDER BY u.login ASC';
        if(isset($params['page'])){
            $q = $q." LIMIT ".($params['page']*$params['perPage']).', '.$params['perPage'];
        }
        //echo $q;
        $data = SQLGetRows($q, $this->dbh);
        $dataCnt = SQLGet($qCnt, $this->dbh);
        if(isset($dataCnt['cnt']) && $dataCnt['cnt'] > 0){
            $cnt = $dataCnt['cnt'];
        }
        $res = array(
            'cnt'   => $cnt,
            'items' => $data,
        );
        if(isset($params['perPage'])) $res['pages'] = ceil($cnt / $params['perPage']);
        return $res;
    }

    function getUsersLetters()
    {
        $query = "
            SELECT LEFT(LOWER(login),1) as l
            FROM users
            GROUP BY LEFT(LOWER(login),1) ASC
        ";
        return SQLGetRows($query, $this->dbh);
    }

    function getUserForumFiendsList($userId)
    {
        $forumUserId = $this->get_value($userId, 'forum');
        $DBFactory = Registry::get('DBFactory');
        $dbh = $DBFactory->get_db_handle('forum');
        $q = '
            SELECT zebra_id as friendForumUserId
            FROM `phpbb_zebra`
            WHERE user_id = '.SQLQuote($forumUserId).'
                AND friend = 1
        ';
        $data = SQLGetRows($q, $dbh);
        foreach ($data as $key=>$value){
            $data[$key]['friendUserId'] = $this->findUserIdByForumId($value['friendForumUserId']);
        }
        return $data;
    }
}

?>