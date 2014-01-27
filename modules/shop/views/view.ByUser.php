<?php
function shopViewByUser(View $View){
    $returnParams   = array();
    $DBFactory      = Registry::get('DBFactory');
	$User      		= Registry::get('User');
	$userId			= isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : '';
	$userForumId	= isset($_REQUEST['user_forum_id']) ? $_REQUEST['user_forum_id'] : '';
	if(empty($userForumId) && empty($userId)) exit;
	if(empty($userId)) $userId = $User->findUserIdByForumId($userForumId);
	if($userId === false) exit;
	
	$page			= isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
	$perPage		= isset($_REQUEST['perPage']) ? $_REQUEST['perPage'] : 3;
	$shopUserItems  = new ShopUserItems($DBFactory->get_db_handle('rakscom'));
	
	$goods 			= $shopUserItems->getGoodsByUser($userId, 'action_time DESC', $page, $perPage);
	if($goods['cnt'] == 0) exit;
	$returnParams['goods'] = $goods;
    return $returnParams;
}

?>