<?php
function videoViewMyAlbumVideos(View $View){
    $returnParams               = array();
    $albumId                    = isset($_REQUEST['album_id']) ? $_REQUEST['album_id'] : 0;
    $page                       = isset($_REQUEST['page']) ? intval($_REQUEST['page']) : 0;
    $perPage                    = 10;    
    $DBFactory                  = Registry::get('DBFactory');
    $Session                    = Registry::get('Session');
    $sessionId                  = Registry::get('s');
    $userId                     = $Session->get_value($sessionId,'user_id');
    $Videos                    	= new Videos($DBFactory->get_db_handle('rakscom'));
    $userVideos               	= $Videos->byOwner('user', $userId, $albumId, 'DESC', $page, $perPage);
    $userAlbum                  = new VideoAlbum($DBFactory->get_db_handle('rakscom'));
	
	if(empty($albumId)){
		header('Location: ?go=my_albums&s='.$sessionId);
		exit;
	}
	
    $userAlbum->findById($albumId);
    $returnParams['userAlbum']  = $userAlbum;     
    $returnParams['userVideos'] = $userVideos;      
    return $returnParams;
}

?>