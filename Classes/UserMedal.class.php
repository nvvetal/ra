<?php

class UserMedal extends API_Item{
    protected $_itemTable = 'phpbb_medals';
    protected $_isDelete  = false;
			
    public function getMedalUrl()
    {
    	//http://raks.com.ua/forum/images/medals/3000.gif
        return $GLOBALS['HTTP_FORUM_IMAGES_PATH'].'medals/'.$this->image;
    }           
            
}

?>