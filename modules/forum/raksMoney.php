<?php

$module_name = "forum";
require_once("../../lib/config.php");

$forumUserId    = isset($_REQUEST['forumUserId']) ? $_REQUEST['forumUserId'] : 0;
$rule           = isset($_REQUEST['rule']) ? $_REQUEST['rule'] :'';
$params         = isset($_REQUEST['p']) ? $_REQUEST['p'] : array();
if(empty($forumUserId) || empty($rule)) {
    add_to_log('[err empty request data][request '.var_export($_REQUEST,true).']','error_forum_raks_money');
    exit;
}

//anonym
if($forumUserId == 1) exit;

$user = new User($DBFactory->get_db_handle('rakscom'));

$userId = $user->findUserIdByForumId($forumUserId);
if($userId === false){
    add_to_log('[err unknown forum user][userId '.$forumUserId.']','error_forum_raks_money');
}

$Raks = new Raks($DBFactory->get_db_handle('rakscom'));
$Raks->addMoneyByRule($userId, $rule, $params);
?>