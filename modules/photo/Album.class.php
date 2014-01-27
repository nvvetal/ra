<?php

class Album extends API_Item {
    protected $_itemTable = 'photo_albums';
    protected $_isDelete  = false;
    
    private function _createPicasaAlbum()
    {  
        $data = false;
        Zend_Loader::loadClass('Zend_Gdata_Photos');
        Zend_Loader::loadClass('Zend_Gdata_ClientLogin');
        Zend_Loader::loadClass('Zend_Gdata_AuthSub');
        $serviceName = Zend_Gdata_Photos::AUTH_SERVICE_NAME;
        $PhotosAuth = Registry::get('PhotosAuth');

        $client = Zend_Gdata_ClientLogin::getHttpClient($PhotosAuth['login'], $PhotosAuth['password'], $serviceName);
        $gp = new Zend_Gdata_Photos($client, "Google-DevelopersGuide-1.0");
        try {
            $entry          = new Zend_Gdata_Photos_AlbumEntry();
            $name           = md5(microtime(true).mt_rand(1000,1000000));
            $entry->setTitle($gp->newTitle($name));
            $createdEntry   = $gp->insertAlbumEntry($entry);
            $data = array(
                'picasa_album_id'   => $createdEntry->getGphotoId()->text,
                'picasa_album_name' => $name,
            );
        }catch(Exception $e){
            add_to_log('[error '.$e->getMessage().']','exception_album');
        }
        return $data;
    }
    
    public function create($data)
    {
        //$picasa                     = $this->_createPicasaAlbum();
        //if($picasa === false) return false;
        //$data['picasa_album_id']    = $picasa['picasa_album_id'];
        //$data['picasa_album_name']  = $picasa['picasa_album_name'];
        return parent::create($data);                
    }
    
    public function getFirstPhotoUrl($w)
    {
        $photos         = new Photos($this->_dbh);
        $albumPhotos    = $photos->byParentAndTime('album_id', $this->id, 'ASC');
        if(count($albumPhotos['items']) == 0) return false;
        return $albumPhotos['items'][0]->getUrlCenterSquare($w);
    }
	
	public function getOwnerLogin()
	{
		$userId = $this->owner_id;
		$user 	= Registry::get('User');
		return $user->get_value($userId, 'login'); 
	}
}

?>