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
}

?>