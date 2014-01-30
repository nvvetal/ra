<?php

class Photo extends API_Item
{
    protected $_itemTable = 'photo_photos';
    protected $_isDelete  = true;

    private function _createPicasaAlbumPhoto($data)
    {
        $data['picasa_image_name']  = md5(microtime(true).mt_rand(10000,100000));
        $gp = Registry::get('Photo_GP');
        $PhotosAuth = Registry::get('PhotosAuth');
        try {
            $filename = $GLOBALS['PHOTO_UPLOAD_ORIGINAL_PATH'].$data['path'].'/'.$data['filename'];
            $fileData = getimagesize($filename);
            $fd = $gp->newMediaFileSource($filename);
            $fd->setContentType($fileData['mime']);
            $photoEntry          = $gp->newPhotoEntry();
            $photoEntry->setMediaSource($fd);
            $photoEntry->setTitle($gp->newTitle($data['picasa_image_name']));
            $albumQuery = $gp->newAlbumQuery();
            $albumQuery->setUser($PhotosAuth['user_id']);
            $albumQuery->setAlbumId($this->getPicasaAlbumId($data['album_id']));
            $insertedEntry = $gp->insertPhotoEntry($photoEntry, $albumQuery->getQueryUrl());
            $data['picasa_image_id']    = $insertedEntry->getGphotoId()->text;
        }catch(Exception $e){
            add_to_log('[error '.$e->getMessage().']','exception_photo');
        }
        return $data;
    }

    public function create($data)
    {
        //$data = $this->_createPicasaAlbumPhoto($data);
        $res = parent::create($data);
        $Images = Registry::get('Images');
        $Images->assign_image($data['image_id'], $res['id'], 'photo');
        return $res;
    }

    public function uploadPhoto($name)
    {

        /**
         * @var $Images Images
         */
        $Images = Registry::get('Images');
        $res = $Images->upload_image($_FILES[$name], $GLOBALS['IMAGE_UPLOAD_ORIGINAL_PATH'], 'upload');
        if($res != true ) return false;
        return $res['ID'];
    }

    public function getUrl($w, $h = '', $ext = 'jpg')
    {
        $contentUrl = "";
        if(empty($h)) $h = $w;
        try {
            $Images = Registry::get('Images');
            $contentUrl = $GLOBALS['HTTP_IMAGES_PATH'].$Images->get_image_url($this->image_id, $w, $h, $ext);
        }catch(Exception $e){
            exception_handler($e);
        }
        return $contentUrl;
    }

    public function getUrlCenterSquare($w, $ext = 'jpg')
    {
        $contentUrl = "";
        try {
            $Images = Registry::get('Images');
            $contentUrl = $GLOBALS['HTTP_IMAGES_PATH'].$Images->get_image_url_center_square($this->image_id, $w, $ext);
        }catch(Exception $e){
            exception_handler($e);
        }
        return $contentUrl;
    }

    public function getOriginalUrl($ext = 'jpg')
    {
        $contentUrl = "";
        try {
            $Images = Registry::get('Images');
            $sizes = $Images->get_original_image_size($this->image_id, $GLOBALS['IMAGE_UPLOAD_ORIGINAL_PATH']);
            if($sizes === false) throw new Exception('Cannot find size for '.$this->image_id);
            $contentUrl = $this->getUrl($sizes['width'], $sizes['height'], $ext);
        }catch(Exception $e){
            exception_handler($e);
        }
        return $contentUrl;
    }

    public function getOriginalWidth()
    {
        $width = 100;
        try {
            $Images = Registry::get('Images');
            $sizes = $Images->get_original_image_size($this->image_id, $GLOBALS['IMAGE_UPLOAD_ORIGINAL_PATH']);
            if($sizes === false) throw new Exception('Cannot find size for '.$this->image_id);
            $width = $sizes['width'];
        }catch(Exception $e){
            exception_handler($e);
        }
        return $width;
    }

    public function getOriginalHeight()
    {
        $height = 100;
        try {
            $Images = Registry::get('Images');
            $sizes = $Images->get_original_image_size($this->image_id, $GLOBALS['IMAGE_UPLOAD_ORIGINAL_PATH']);
            if($sizes === false) throw new Exception('Cannot find size for '.$this->image_id);
            $height = $sizes['height'];
        }catch(Exception $e){
            exception_handler($e);
        }
        return $height;
    }

    public function getPicasaAlbumId($albumId = NULL)
    {
        $Album = new Album($this->_dbh);
        $albumId = is_null($albumId) ? $this->album_id : $albumId;
        $Album->findById($albumId);
        return $Album->picasa_album_id;
    }

    public function getAlbum()
    {
        $album = false;
        try {
            $album = new Album($this->_dbh);
            $album->findById($this->album_id);
        }catch(Exception $e){
            exception_handler($e);
        }
        return $album;
    }

    public function getOwnerUserId()
    {
        if($this->owner_type == 'user') return $this->owner_id;
        if($this->owner_type == 'school') {
            require_once('../schools/school.class.php');
            $schoolObj  = new school($this->_dbh);
            $school     = $schoolObj->get_school($this->owner_id);
            return $school['owner_id'];
        }
    }

}

?>