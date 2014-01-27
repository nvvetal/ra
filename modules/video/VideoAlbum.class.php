<?php

class VideoAlbum extends API_Item {
    protected $_itemTable = 'video_albums';
    protected $_isDelete  = false;

    public function create($data)
    {
        return parent::create($data);                
    }
	
	public function getOwnerLogin()
	{
		$userId = $this->owner_id;
		$user 	= Registry::get('User');
		return $user->get_value($userId, 'login'); 
	}    
}

?>