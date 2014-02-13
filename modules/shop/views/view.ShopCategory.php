<?php
function shopViewShopCategory(View $View){
    $shopId = isset($_REQUEST['shop_id']) ? $_REQUEST['shop_id'] : 0;
    $categoryId = isset($_REQUEST['category_id']) ? $_REQUEST['category_id'] : 0;
    $returnParams = array();
    $DBFactory = Registry::get('DBFactory');
    $user = Registry::get('User');
    /**
     * @var $session Session
     */
    $session = Registry::get('Session');
    $sessId = Registry::get('s');
    try {
        $Shop = new Shop($DBFactory->get_db_handle('rakscom'));
        $res = $Shop->findById($shopId);
        if($res === false) throw new Exception('Cannot find shop '.$shopId);
        $returnParams['shop'] = $Shop;
        $category   = new ShopCategory($DBFactory->get_db_handle('rakscom'));
        $category->findById($categoryId);
        if($res === false) throw new Exception('Cannot find category '.$categoryId.' for shop '.$shopId);
        $returnParams['shopCategory'] = $category;
        $toUserId = $session->get_value($sessId, 'shop_user_id');
        if(is_numeric($toUserId)) {
            $returnParams['toUsername'] = $user->get_value($toUserId, 'login');
        }
    }catch(Exception $e){
        exception_handler($e);
    }

    return $returnParams;
}

?>