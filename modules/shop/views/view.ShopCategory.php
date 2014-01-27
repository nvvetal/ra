<?php
function shopViewShopCategory(View $View){
	$shopId							= isset($_REQUEST['shop_id']) ? $_REQUEST['shop_id'] : 0;
	$categoryId						= isset($_REQUEST['category_id']) ? $_REQUEST['category_id'] : 0;
	
    $returnParams                   = array();
    $DBFactory                      = Registry::get('DBFactory');
	try {
		$Shop 	                    = new Shop($DBFactory->get_db_handle('rakscom'));
		$res = $Shop->findById($shopId);
		if($res === false) throw new Exception('Cannot find shop '.$shopId);
		$returnParams['shop'] 		= $Shop;
		$category					= new ShopCategory($DBFactory->get_db_handle('rakscom'));
		$category->findById($categoryId);		
		if($res === false) throw new Exception('Cannot find category '.$categoryId.' for shop '.$shopId);
		$returnParams['shopCategory'] = $category;
	}catch(Exception $e){
		exception_handler($e);		
	}
	
    return $returnParams;
}

?>