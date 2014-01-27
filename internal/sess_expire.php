<?php
if($_REQUEST['pass'] != 'ollooolo') exit;

require_once('../lib/config.php');

$expireCount = 0;

$sessions = $Session->find_inactive_sessions(10);
if(is_array($sessions) && count($sessions) > 0){
    foreach ($sessions as $sess_data){
        $sessValues = $Session->get_sess_values($sess_data['sess_id']);
        $combined = array_merge($sessValues,$sess_data);
        add_to_log("[sess_id {$sess_data['sess_id']}][data ".serialize($combined)."]",'sess_expire');
        $Session->remove_session($sess_data['sess_id']);
        $expireCount++;
    }
    
}


add_to_log("[count $expireCount]","sess_expire_cnt");
?>