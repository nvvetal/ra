<?php

class ShopCategory extends API_Item {
    protected $_itemTable = 'shop_categories';
    protected $_isDelete  = false;
    
    public function getCategoryItems($sortBy, $sortOrder, $page = 1, $perPage = 0)
    {
        $shopGoods = new ShopGoods($this->_dbh);
        $items = $shopGoods->byParent('category_id', $this->id, $sortBy, $sortOrder, $page, $perPage);
        return $items['items'];
    }
    
    public function getCategoryItemPages($page, $perPage)
    {
        $shopGoods = new ShopGoods($this->_dbh);
        $items = $shopGoods->byParent('category_id', $this->id, 'image_id', 'DESC', $page, $perPage);
        return $items['pages'];
    }

    public function findByShopAndName($shopId, $name)
    {
        $q = "
            SELECT *
            FROM ".$this->_itemTable."
            WHERE shop_id = ".SQLQuote($shopId)." AND name = ".SQLQuote($name)."
            LIMIT 1
        ";
        $data = SQLGet($q, $this->_dbh);
        if($data !== false) {
            $this->_initCache($data['id']);
            $this->_cache->setData($data);
            $this->_itemData = $data;
            return true;
        }
        return false;
    }

}

?>