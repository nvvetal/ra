<?php

/**
 * @param $s
 * @param $Session Session
 */
function sess_auth(&$s, &$Session)
{

    $remote_addr = $_SERVER['REMOTE_ADDR'];
    $user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
    $type = 'web';
    $User = Registry::get('User');
    $user_id = 0;
    $c_user_id = isset($_COOKIE['rakscom_user_id']) ? intval($_COOKIE['rakscom_user_id']) : 0;

    if ($c_user_id > 0 /*&&
        $User->get_value($c_user_id, 'is_autologin') == 1*/
    ) {
        $sess_id = $User->get_value($c_user_id, 'cookie_session');
        $sess_key = $User->get_value($c_user_id, 'cookie_session_key');
        if ($sess_id == $_COOKIE['rakscom_s'] && $sess_key == $_COOKIE['rakscom_s_key']) {
            $s = $sess_id;
            $user_id = $c_user_id;
        }
    }
    if (empty($s)) {
        $s = $Session->session_create($user_id, $remote_addr, $user_agent, $type);
    } else {
        if ($Session->is_session_active($s, $remote_addr, $user_agent, $type)) {
            $Session->session_touch($s);
        } else {
            $s = $Session->session_create($user_id, $remote_addr, $user_agent, $type);
        }
    }

    if($c_user_id > 0 ){
        $cookie_end_time = time() + 3600 * 24 * 30;
        $User->set_cookie_autologin($user_id, $s, $cookie_end_time);
    }
}

function user_auth(&$s, &$User, &$Session)
{
    $remote_addr = $_SERVER['REMOTE_ADDR'];
    $user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
    $type = 'web';

    if ($Session->get_value($s, 'user_id') == 0) {
        //TODO: check cookies for autologin and login if set = 1
        //var_dump($_COOKIE);
        $c_user_id = isset($_COOKIE['rakscom_user_id']) ? intval($_COOKIE['rakscom_user_id']) : 0;
        if ($c_user_id > 0 &&
            $User->get_value($c_user_id, 'is_autologin') == 1
        ) {
            $sess_id = $User->get_value($c_user_id, 'cookie_session');
            $sess_key = $User->get_value($c_user_id, 'cookie_session_key');
            if ($sess_id == $_COOKIE['rakscom_s'] && $sess_key == $_COOKIE['rakscom_s_key']) {
                //TODO: check security
                $newSessId = $Session->find_active_user_session($c_user_id, $remote_addr, $user_agent, $type);
                if ($newSessId !== false) {
                    $Session->close_session($s, 'deleted');
                    $s = $newSessId;
                    $smarty = Registry::get('templator');
                    $smarty->assign_by_ref('user_id', $c_user_id);

                }
                $Session->set_value($s, 'user_id', $c_user_id);
                $Session->set_value($s, 'is_logged', 1);
                $User->set_value($c_user_id, 'lastEnterTime', time());
                add_to_log("[user_id $c_user_id][login_type autologin][s $s][type " . $User->get_value($c_user_id, 'type') . "]", 'login');
            } else {
                add_to_log("[error session or key is wrong!!!][user_id $c_user_id][s $s][c_sess {$_COOKIE['rakscom_s']}][sess $sess_id][c_sess_key {$_COOKIE['rakscom_s_key']}][sess_key $sess_key][ua " . @$_SERVER['HTTP_USER_AGENT'] . "][ip " . $_SERVER['REMOTE_ADDR'] . "]", 'security');
            }
        }


    }
}

/**
 * @param $user
 * @param $params
 * @param $u_params
 * @return string
 */
function check_login($user, $params, $u_params)
{
    if ($user !== false) {
        if ($user['state'] != 'active') {
            switch ($user['state']) {
                case "not_active":
                    $params['smarty']->assign('errors', array('Login' => array('message' => 'Sorry, your account not active!')));
                    break;
                case "banned":
                    $params['smarty']->assign('errors', array('Login' => array('message' => 'Your account was banned!')));
                    break;
            }
            add_to_log("[s {$params['s']}][params ".var_export($u_params, true)."][state ".$user['state']."][ip {$_SERVER['REMOTE_ADDR']}][ua " . @$_SERVER['HTTP_USER_AGENT'] . "]", "error_login");
            return 'login';
        }
        $params['Session']->set_value($params['s'], 'user_id', $user['user_id']);
        $params['Session']->set_value($params['s'], 'is_logged', 1);
        if (isset($_REQUEST['is_autologin']) && $_REQUEST['is_autologin'] == 1) {
            //setting cookie to autologin
            $cookie_end_time = time() + 3600 * 24 * 30;
            $params['User']->set_cookie_autologin($user['user_id'], $params['s'], $cookie_end_time);
            $params['User']->set_value($user['user_id'], 'is_autologin', 1);
        }
        $params['User']->set_value($user['user_id'], 'lastEnterTime', time());
        add_to_log("[user_id {$user['user_id']}][login_type login_form][s {$params['s']}][type " . $params['User']->get_value($user['user_id'], 'type') . "]", 'login');
        return 'index';
    }

    $login_bad_attempts = $params['Session']->get_value($params['s'], 'login_bad_attempts');
    if (is_null($login_bad_attempts)) {
        $login_bad_attempts = 1;
    } else {
        $login_bad_attempts++;
    }
    $params['Session']->set_value($params['s'], 'login_bad_attempts', $login_bad_attempts);
    $params['smarty']->assign('errors', array('Login' => array('message' => 'Your account not found!')));
    add_to_log("[s {$params['s']}][params ".var_export($u_params, true)."][try $login_bad_attempts][ip {$_SERVER['REMOTE_ADDR']}][ua " . @$_SERVER['HTTP_USER_AGENT'] . "]", "error_login");
    return 'login';
}