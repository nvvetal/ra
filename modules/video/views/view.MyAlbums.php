<?php
function videoViewMyAlbums(View $View){
    $returnParams               = array();
    $page                       = isset($_REQUEST['page']) ? intval($_REQUEST['page']) : 1;
    $DBFactory                  = Registry::get('DBFactory');
    $Session                    = Registry::get('Session');
    $sessionId                  = Registry::get('s');
    $userId                     = $Session->get_value($sessionId,'user_id');
    if(empty($userId)) {
        header('Location: /');
        exit;
    }
    $Albums                     = new VideoAlbums($DBFactory->get_db_handle('rakscom'));
    $userAlbums                 = $Albums->byOwner('user', $userId, 'DESC', $page, 10);
    $returnParams['userAlbums'] = $userAlbums;      
    return $returnParams;
}

?>