<?php

class Shop extends API_Item {
    protected $_itemTable = 'shop_shops';
    protected $_isDelete  = false; 
	
	public function getCategories($orderBy = 'name', $order = 'ASC')
	{
		$shopCategories = new ShopCategories($this->_dbh);
		$items = $shopCategories->byParent('shop_id', $this->id, $orderBy, $order);
		return $items;
	}
    
    public function getGoodsCount()
    {
        $q = "
            SELECT COUNT(si.id) as cnt
            FROM shop_items as si
            INNER JOIN shop_categories as sc ON (sc.shop_id = ".SQLQuote($this->id).")
            WHERE si.category_id = sc.id
        ";
        //echo $q;
        $data = SQLGet($q, $this->_dbh);
        return isset($data['cnt']) ? $data['cnt'] : 0;
    }
	
   
    public function imageUrl($w, $h)
    {
        return 'http://www.iamintheuk.com/wp-content/uploads/2011/06/bodyshop-2.jpg';
    } 
    
    public function getOwnerData($key)
    {
        $user = new User($this->_dbh);
        return $user->get_value($this->user_id, $key);
    } 
}

?>