<?php
function userViewUserStatus(View $View){
    $returnParams   = array();
    $DBFactory      = Registry::get('DBFactory');
    $User = Registry::get('User');
    $userId = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : '';
    $userForumId = isset($_REQUEST['user_forum_id']) ? $_REQUEST['user_forum_id'] : '';
    if(empty($userForumId) && empty($userId)) exit;
    if(empty($userId)) $userId = $User->findUserIdByForumId($userForumId);
    if($userId === false) exit;
    $dbh                        = $DBFactory->get_db_handle('rakscom');
    $userStatusObj = new UserStatus($dbh);
    $userStatus = $userStatusObj->getLastActiveStatus($userId);
    $returnParams['status'] = $userStatus;
    return $returnParams;
}
