<?php

class ShopGood extends API_Item {
    protected $_itemTable = 'shop_items';
    protected $_isDelete  = false;
    
    public function getImageUrl($w, $h, $ext)
    {
        $Images = Registry::get('Images');
        return $Images->get_image_url($this->image_id, $w, $h, $ext);
        //return 'http://www.iamintheuk.com/wp-content/uploads/2011/06/bodyshop-2.jpg';
    }    

    public function getImageUrlH($h, $ext)
    {
        $Images = Registry::get('Images');
        return $Images->get_image_url_main_h($this->image_id, $h, $ext);

    } 
	
    public function getOwnerData($key)
    {
        $user = new User($this->_dbh);
        return $user->get_value($this->user_id, $key);
    } 
    
    public function getCategory()
    {
        $shopCategory = new ShopCategory($this->_dbh);
        $shopCategory->findById($this->category_id);
        return $shopCategory;
    }
    
    public function getShopId()
    {
        $category = $this->getCategory();
        return $category->shop_id;
    }
    
}

?>