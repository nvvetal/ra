<?php

function videoActionMyAlbumAdd( ActionProcessor $actionProcessor ){

    $templator = $actionProcessor->getParam('templator');    
    
    $name       = isset($_REQUEST['name']) ? $_REQUEST['name'] : '';
    if(empty($name)){
        $templator->assign('errors',array('name'=>array('message'=>'Please set name of album!')));
        return array(
            'ok'        => false,
            'go'        => "my_album_add",
        );
    }
    $Session    = Registry::get('Session');
    $sessionId  = Registry::get('s');
    $DBFactory  = Registry::get('DBFactory');
    $userId     = $Session->get_value($sessionId, 'user_id');
    $Album      = new VideoAlbum($DBFactory->get_db_handle('rakscom'));
    $data       = array(
        'name'          => $name,
        'created_time'  => time(),
        'owner_type'    => 'user',
        'owner_id'      => $userId,
    );
    $Album->create($data);

    $albumId    = $Album->id;
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