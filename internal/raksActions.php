<?php
if($_REQUEST['pass'] != 'rakssubm134') exit;

require_once('../lib/config.php');

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';
$userId = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : '';
$forumId = isset($_REQUEST['forum_id']) ? $_REQUEST['forum_id'] : '';

switch ($action){
    case "forum_pi":
        
    break;
    
    case "forum_medal":
        
    break;
}

add_to_log("[action $action][userId $userId][forumId $forumId]","raksMoneyActions");
?>