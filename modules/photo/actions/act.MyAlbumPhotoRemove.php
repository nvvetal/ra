<?php

function photoActionMyAlbumPhotoRemove( ActionProcessor $actionProcessor ){

    $templator = $actionProcessor->getParam('templator');    
    $Session   = Registry::get('Session');
    $sessionId = Registry::get('s');
   
    $photoId   = isset($_REQUEST['photo_id']) ? $_REQUEST['photo_id'] : '';
    $albumId   = isset($_REQUEST['album_id']) ? $_REQUEST['album_id'] : '';

    $DBFactory  = Registry::get('DBFactory');
    $userId     = $Session->get_value($sessionId, 'user_id');
    $Photo      = new Photo($DBFactory->get_db_handle('rakscom'));
    //checking user album
    try{
        $Photo->findById($photoId);
        if($Photo->owner_id != $userId || $Photo->owner_type != 'user') throw new Exception('User photo '.$photoId.' is wrong!');        
        $albumId = $Photo->album_id;
        $Photo->delete();
    }catch(Exception $e){
        exception_handler($e);
        $templator->assign('errors',array('Technical Error'=>array('message'=>'Wrong photo Id')));
        return array(
            'ok'        => false,
            'go'        => "my_album_photos",
            's'         => $sessionId,
            'album_id'  => $albumId,
        );
    }
    $go = $actionProcessor->getParam($actionProcessor->getGoName());
    return array(
        'ok'        =>true,
        'urlParams' =>array(
            'go'        => $go,
            'album_id'  => $albumId,
            's'         => $sessionId,
        ),
    );
}

?>