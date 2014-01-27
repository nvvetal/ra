<?php

class ShopUserItem extends API_Item {
    protected $_itemTable = 'shop_user_items';
    protected $_isDelete  = false;
    
    public function addUserGift($fromUserId, $toUserId, $giftId, $privateMessage = '')
	{
		$fields = array(
			'from_user_id' 	=> $fromUserId,
			'to_user_id'	=> $toUserId,
			'item_id'		=> $giftId, 
			'action_time'	=> time(),
			'message'		=> $privateMessage,
		);
		SQLInsert($this->_itemTable, $fields, $this->_dbh);
	}
	
	   
}

?>