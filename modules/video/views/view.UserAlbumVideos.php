<?php
function videoViewUserAlbumVideos(View $View){
    $returnParams               = array();
    $albumId                    = isset($_REQUEST['album_id']) ? $_REQUEST['album_id'] : 0;
    $page                       = isset($_REQUEST['page']) ? intval($_REQUEST['page']) : 0;
    $perPage                    = 10;    
    $DBFactory                  = Registry::get('DBFactory');
    $Session                    = Registry::get('Session');
    $sessionId                  = Registry::get('s');
    $userId                     = $Session->get_value($sessionId, 'user_id');
    $Videos                    	= new Videos($DBFactory->get_db_handle('rakscom'));
    
    $userAlbum                  = new VideoAlbum($DBFactory->get_db_handle('rakscom'));
    $userAlbum->findById($albumId);
	
	if($userAlbum->owner_id == $userId) {
		header('Location: ?go=my_album_videos&album_id='.$albumId.'&s='.$sessionId);
		exit;
	}
	$userVideos               	= $Videos->byOwner('user', $userAlbum->owner_id, $albumId, 'DESC', $page, $perPage);
	
    $returnParams['userAlbum']  = $userAlbum;     
    $returnParams['userVideos'] = $userVideos;      
    return $returnParams;
}

?>