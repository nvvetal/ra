<?php
function photoViewMyAlbumPhotoAdd(View $View){
    $returnParams               = array();
    $albumId                    = isset($_REQUEST['album_id']) ? $_REQUEST['album_id'] : 0;
    $DBFactory                  = Registry::get('DBFactory');
    $Session                    = Registry::get('Session');
    $sessionId                  = Registry::get('s');
    $userId                     = $Session->get_value($sessionId,'user_id');
    if(empty($userId)) {
        header('Location: /');
        exit;
    }
    $userAlbum                      = new Album($DBFactory->get_db_handle('rakscom'));
    $userAlbum->findById($albumId);
    $returnParams['userAlbum']  = $userAlbum;      
    return $returnParams;
}

?>