<?php
function videoViewMyAlbumAdd(View $View){
    $returnParams               = array();
    $Session                    = Registry::get('Session');
    $sessionId                  = Registry::get('s');
    $userId                     = $Session->get_value($sessionId,'user_id');
    if(empty($userId)) {
        header('Location: /');
        exit;
    }
    return $returnParams;
}

?>