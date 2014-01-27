<?php

function admin_actions($go,$action,$params){

    switch ($action){
        case "login":
        require_once($GLOBALS['CLASSES_DIR']."User_container.class.php");
        $user_container_class = new User_container($params['Validator'],$params['User']);
        $u_params = array(
        'login'=>@$_REQUEST['login'],
        'password'=>@$_REQUEST['password'],
        );
        $user = $user_container_class->call_method("login",$u_params);
        if($user_container_class->is_valid($user)){
            if($user !== false){
                $params['Session']->set_value($params['s'],'user_id',$user['user_id']);
                $params['Session']->set_value($params['s'],'is_logged',1);
                if (isset($_REQUEST['is_autologin']) && $_REQUEST['is_autologin'] == 1){
                    //setting cookie to autologin
                    $cookie_end_time = time()+3600*24*30;
                    $params['User']->set_cookie_autologin( $user['user_id'], $params['s'], $cookie_end_time );
                    $params['User']->set_value( $user['user_id'], 'is_autologin', 1);
                    add_to_log("[user_id {$user['user_id']}][login_type login_form][s {$params['s']}][type ".$params['User']->get_value($user['user_id'],'type')."]",'login'
                    );
                }else{
                    $login_bad_attempts = $params['Session']->get_value($params['s'],'login_bad_attempts');
                    if(is_null($login_bad_attempts)){
                        $login_bad_attempts = 1;
                    }else{
                        $login_bad_attempts++;
                    }
                    $params['Session']->set_value($params['s'],'login_bad_attempts',$login_bad_attempts);
                    add_to_log("[s {$params['s']}][login {$u_params['login']}][password {$u_params['password']}][try $login_bad_attempts][ip {$_SERVER['REMOTE_ADDR']}][ua ".@$_SERVER['HTTP_USER_AGENT']."]","error_login");
                }
            }
        }else{
            $params['smarty']->assign('errors',$user_container_class->get_errors($user));
        }
        break;
    }
    return $go;
}


function get_admin_logs($year,$month,$day){
    $begin_date = sprintf("%04d-%02d-%02d 00:00:00",$year,$month,$day);
    $end_date = sprintf("%04d-%02d-%02d 23:59:59",$year,$month,$day);
    $query = "
        SELECT *
        FROM admin_logs
        WHERE FROM_UNIXTIME(time_created) BETWEEN '$begin_date' AND '$end_date'
        ORDER BY time_created DESC
    ";
    $dbh = Registry::get('DBFactory')->get_db_handle("rakscom");
    return SQLGetRows($query,$dbh);
}
?>