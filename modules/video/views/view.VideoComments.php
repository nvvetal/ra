<?php
function videoViewVideoComments(View $View){
    $returnParams               	= array();
    $videoId                    	= isset($_REQUEST['video_id']) ? $_REQUEST['video_id'] : 0;
    $DBFactory                  	= Registry::get('DBFactory');
    $Session                    	= Registry::get('Session');
    $sessionId                  	= Registry::get('s');
    $userId                     	= $Session->get_value($sessionId,'user_id');
	$video							= new Video($DBFactory->get_db_handle('rakscom'));
	$video->findById($videoId);
    $videoAlbum                 	= new VideoAlbum($DBFactory->get_db_handle('rakscom'));
    $videoAlbum->findById($video->album_id);
	$videoComments					= $video->getComments();
	$returnParams['video']  		= $video;   
    $returnParams['videoAlbum']  	= $videoAlbum;     
    $returnParams['videoComments'] 	= $videoComments;    
	 
    return $returnParams;
}

?>