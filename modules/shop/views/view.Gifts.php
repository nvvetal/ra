<?php
function shopViewGifts(View $View){
    $returnParams   = array();
    $DBFactory      = Registry::get('DBFactory');
	$dbh			= $DBFactory->get_db_handle('rakscom');
	$User      		= Registry::get('User');
	$userId			= isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : '';
	$page 			= isset($_REQUEST['page']) ? $_REQUEST['page'] : '';
	$perPage		= isset($_REQUEST['per_page']) ? $_REQUEST['per_page'] : 10;
	
	$session		= Registry::get('Session');
	$sessId			= Registry::get('s');	
	
	$currentUserId	= $session->get_value($sessId, 'user_id');
	if(empty($userId)) $userId = $currentUserId;
	$canShowPrivateComment	= ($userId == $currentUserId) ? 1 : 0;
	$shopUserItems	= new ShopUserItems($dbh);
	$userGoods		= $shopUserItems->getGoodsByUser($userId, 'action_time DESC', $page, $perPage);
	$returnParams 	= array(
		'canShowPrivateComment' => $canShowPrivateComment,
		'userGoods'				=> $userGoods,
	);		 
    return $returnParams;
}

?>