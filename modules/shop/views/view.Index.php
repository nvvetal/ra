<?php
function shopViewIndex(View $View){
    $returnParams                   = array();
    $DBFactory                      = Registry::get('DBFactory');
    $Shops 	                        = new Shops($DBFactory->get_db_handle('rakscom'));
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
    $shopsData                     	= $Shops->all();
    $returnParams['shopsData']     	= $shopsData;
    return $returnParams;
}

?>