<?php

function photoActionSchoolAlbumPhotoAdd( ActionProcessor $actionProcessor ){

    $Session    = Registry::get('Session');
    $sessionId  = Registry::get('s');
   
    $albumId   = isset($_REQUEST['album_id']) ? $_REQUEST['album_id'] : '';
    $schoolId   = isset($_REQUEST['school_id']) ? $_REQUEST['school_id'] : '';
    $name      = '';

    $DBFactory  = Registry::get('DBFactory');
    $Album      = new Album($DBFactory->get_db_handle('rakscom'));
    //checking user album
    try{
        $Album->findById($albumId);
        if($Album->owner_id != $schoolId || $Album->owner_type != 'school') throw new Exception('User album '.$albumId.' is wrong!');        
    }catch(Exception $e){
        exception_handler($e);
        die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');

    }
    
    $data       = array(
        'album_id'      => $albumId,
        'name'          => $name,
        'created_time'  => time(),
        'owner_type'    => 'school',
        'owner_id'      => $schoolId,
    );
    $Photo      = new Photo($DBFactory->get_db_handle('rakscom'));
    try {
        $photoID = $Photo->uploadPhoto('file');
        if($photoID === false) throw new Exception('Cannot upload image!');
        $data['image_id'] = $photoID;
        $Photo->create($data);
    }catch(Exception $e){
        exception_handler($e);
        die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
    }
    die('{"jsonrpc" : "2.0", "result" : null, "id" : "id", "photoUrl" : "'.$Photo->getUrlCenterSquare(200,'gif').'", "photoId": "'.$photoID.'"}');

}

?>