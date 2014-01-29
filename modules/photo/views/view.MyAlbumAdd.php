<?php
function photoViewMyAlbumAdd(View $View){
    $Session                    = Registry::get('Session');
    $sessionId                  = Registry::get('s');
    $userId                     = $Session->get_value($sessionId,'user_id');
    if(empty($userId)) {
        header('Location: /');
        exit;
    }
    $returnParams               = array();
    
    return $returnParams;
}

?>