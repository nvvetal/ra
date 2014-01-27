<?php
function videoViewMyAlbumVideoAdd(View $View){
    $returnParams               = array();
    $albumId                    = isset($_REQUEST['album_id']) ? $_REQUEST['album_id'] : 0;
    $DBFactory                  = Registry::get('DBFactory');
    $Session                    = Registry::get('Session');
    $sessionId                  = Registry::get('s');
    $userId                     = $Session->get_value($sessionId,'user_id');
    $userAlbum                  = new VideoAlbum($DBFactory->get_db_handle('rakscom'));
    $userAlbums                 = new VideoAlbums($DBFactory->get_db_handle('rakscom'));
    $userAlbum->findById($albumId);
    $returnParams['userAlbum']  = $userAlbum;
    $returnParams['userAlbums']  = $userAlbums->byOwner('user', $userId);
    return $returnParams;
}

?>