<?php
function shopViewShop(View $View){
    $shopId = isset($_REQUEST['shop_id']) ? $_REQUEST['shop_id'] : 0;
    $userForumId = isset($_REQUEST['user_forum_id']) ? $_REQUEST['user_forum_id'] : '';
    $userId = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : '';
    $user = Registry::get('User');
    /**
     * @var $session Session
     */
    $session = Registry::get('Session');
    $sessId = Registry::get('s');
    if(empty($userId) && !empty($userForumId)){
        $foundUserId = $user->findUserIdByForumId($userForumId);
        if($foundUserId !== false) $userId = $foundUserId;
    }
    if(!empty($userId) && $user->is_user_id_exists($userId))
    {
        $session->set_value($sessId, 'shop_user_id', $userId);
    }
    $returnParams = array();
    $DBFactory = Registry::get('DBFactory');
    try {
        $Shop = new Shop($DBFactory->get_db_handle('rakscom'));
        $res = $Shop->findById($shopId);
        if($res === false) throw new Exception('Cannot find shop '.$shopId);
        $returnParams['shop'] = $Shop;
    }catch(Exception $e){
        exception_handler($e);
    }

    return $returnParams;
}

?>