<?php
if($_REQUEST['pass'] != 'ollooolo') exit;

require_once('../lib/config.php');

$expireCount = 0;

$users = $User->find_inactive_users();
if(is_array($users) && count($users) > 0){
    foreach ($users as $user){
        add_to_log("[user_id {$user['user_id']}][data ".serialize($user)."]",'acc_expire');
        $User->delete_user($user['user_id']);
        $expireCount++;
    }
    
}


add_to_log("[count $expireCount]","acc_expire_cnt");
?>