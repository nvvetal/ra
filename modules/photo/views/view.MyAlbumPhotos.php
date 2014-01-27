<?php
function photoViewMyAlbumPhotos(View $View){
    $returnParams               = array();
    $albumId                    = isset($_REQUEST['album_id']) ? $_REQUEST['album_id'] : 0;
    $page                       = isset($_REQUEST['page']) ? intval($_REQUEST['page']) : 1;
    $perPage                    = 0;    
    $DBFactory                  = Registry::get('DBFactory');
    $Session                    = Registry::get('Session');
    $sessionId                  = Registry::get('s');
    $userId                     = $Session->get_value($sessionId,'user_id');
    $Photos                     = new Photos($DBFactory->get_db_handle('rakscom'));
    $userPhotos                 = $Photos->byOwner('user', $userId, $albumId, 'DESC', $page, $perPage);
    $userAlbum                      = new Album($DBFactory->get_db_handle('rakscom'));
    $userAlbum->findById($albumId);
    $returnParams['userAlbum']  = $userAlbum;     
    $returnParams['userPhotos'] = $userPhotos;      
    return $returnParams;
}

?>