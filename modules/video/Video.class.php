<?php

class Video extends API_Item
{
    protected $_itemTable = 'video_videos';
    protected $_isDelete  = true;
   
    public function create($data)
    {
        $res = parent::create($data);
        return $res; 
    } 
   
    public function getUrl()
    {
        $contentUrl = "";
        try {
            
        }catch(Exception $e){
            exception_handler($e);
        }
        return $contentUrl;
    }
	
    public function getAlbum()
    {
        $album = false;
        try {
            $album = new VideoAlbum($this->_dbh);
            $album->findById($this->album_id);
        }catch(Exception $e){
            exception_handler($e);
        }
        return $album;
    }
    
    public function parseLink($link)
    {
        //<iframe width="560" height="315" src="http://www.youtube.com/embed/tU2MFVILoRE" frameborder="0" allowfullscreen></iframe>
        $resLink = false;
        if(preg_match("/<iframe width=\"\d+\" height=\"\d+\" src=\"http:\/\/www\.youtube\.com\/embed\/([^\"]+)\"/i", $link, $m)){
            $resLink = $m[1];            
        //http://youtu.be/tU2MFVILoRE
        }elseif(preg_match("/^http:\/\/youtu\.be\/(\w+)$/i", $link, $m)){
            $resLink = $m[1]; 
        }elseif(preg_match("/^https:\/\/youtu\.be\/(\w+)$/i", $link, $m)){
            $resLink = $m[1]; 
        //https://www.youtube.com/watch?v=QLVp_-EyAC4&feature=g-vrec
        }elseif(preg_match("/youtube\.com\/watch\?v=([^\&]+)\&/i", $link, $m)){
            $resLink = $m[1];
        }elseif(preg_match("/youtube\.com\/watch\?v=(\S+)$/i", $link, $m)){
            $resLink = $m[1];
        }
        return $resLink;
    }
    
    public function getRateAgr()
    {
        $RateAgr = new RateAgr($this->_dbh);
        $RateAgr->findByRateIdAndType($this->id, 'video');
        return $RateAgr;
    }
    
    public function getComments()
    {
        $Comments 		= new Comments($this->_dbh);
        $videoComments 	= $Comments->getCommentsBy('video', $this->id);  
        return $videoComments;         
    }
    
    public function getCommentsCount()
    {
        $comments = $this->getComments();
        return count($comments);
    }   
	
	public function isUserRatedVideo($userId)
	{
		$Rates 		= new Rates($this->_dbh);			
		$lastRate 	= $Rates->getLastRateByFrom($this->id, 'video', $userId, 'user');
    	return ($lastRate !== false) ? true : false;
	} 
	
	public function getCommentBackUrl()
	{
		return urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);	
	}
	
	public function getOwnerLogin()
	{
		$user = new User($this->_dbh);
		return $user->get_value($this->owner_id, 'login');
	}
	
	public function getTags()
	{
		$tags = new VideoTags($this->_dbh);
		$tagsData = $tags->byVideoId($this->id);
		return $tagsData;
	}	
}

?>