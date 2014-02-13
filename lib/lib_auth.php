<?php

function sess_auth(&$s, &$Session){

    $remote_addr = $_SERVER['REMOTE_ADDR'];
    $user_agent = @$_SERVER['HTTP_USER_AGENT'];
    $type = 'web';

    $user_id = 0;
    if(empty($s)){
        $s = $Session->session_create($user_id,$remote_addr,$user_agent,$type);
    }else{
        if($Session->is_session_active($s,$remote_addr,$user_agent,$type)){
            $Session->session_touch($s);
        }else{
            $s = $Session->session_create($user_id,$remote_addr,$user_agent,$type);
        }
    }
}

function user_auth(&$s, &$User, &$Session){
    $remote_addr = $_SERVER['REMOTE_ADDR'];
    $user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
    $type = 'web';

    if($Session->get_value($s,'user_id') == 0){
        //TODO: check cookies for autologin and login if set = 1
        //var_dump($_COOKIE);
        $c_user_id = isset($_COOKIE['rakscom_user_id']) ? intval($_COOKIE['rakscom_user_id']) : 0;
        if($c_user_id > 0 &&
            $User->get_value($c_user_id,'is_autologin') == 1){
            $sess_id = $User->get_value($c_user_id,'cookie_session');
            $sess_key = $User->get_value($c_user_id,'cookie_session_key');
            if($sess_id == $_COOKIE['rakscom_s'] && $sess_key == $_COOKIE['rakscom_s_key']){
                //TODO: check security
                $newSessId = $Session->find_active_user_session($c_user_id,$remote_addr,$user_agent,$type);
                if($newSessId !== false){
                    $Session->close_session($s,'deleted');
                    $s = $newSessId;
                    $smarty = Registry::get('templator');
                    $smarty->assign_by_ref('user_id', $c_user_id);

                }
                $Session->set_value($s, 'user_id', $c_user_id);
                $Session->set_value($s, 'is_logged', 1);
                $User->set_value($c_user_id, 'lastEnterTime', time());
                add_to_log("[user_id $c_user_id][login_type autologin][s $s][type ".$User->get_value($c_user_id,'type')."]",'login');
            }else{
                add_to_log("[error session or key is wrong!!!][user_id $c_user_id][s $s][c_sess {$_COOKIE['rakscom_s']}][sess $sess_id][c_sess_key {$_COOKIE['rakscom_s_key']}][sess_key $sess_key][ua ".@$_SERVER['HTTP_USER_AGENT']."][ip ".$_SERVER['REMOTE_ADDR']."]",'security');
            }
        }


    }
}

?>