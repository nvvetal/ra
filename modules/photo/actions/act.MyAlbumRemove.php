<?php

function photoActionMyAlbumRemove( ActionProcessor $actionProcessor ){

    $templator = $actionProcessor->getParam('templator');    
    
    $albumId   = isset($_REQUEST['album_id']) ? $_REQUEST['album_id'] : '';
    $Session    = Registry::get('Session');
    $sessionId  = Registry::get('s');
    if(empty($albumId)){
        $templator->assign('errors',array('name'=>array('message'=>'Please select album!')));
        return array(
            'ok'        => false,
            'go'        => "my_albums",
            's'         => $sessionId,
        );
    }

    $DBFactory  = Registry::get('DBFactory');
    $userId     = $Session->get_value($sessionId, 'user_id');
    $Album      = new Album($DBFactory->get_db_handle('rakscom'));
    //checking user album
    try{
        $Album->findById($albumId);
        if($Album->owner_id != $userId || $Album->owner_type != 'user') throw new Exception('User album '.$albumId.' is wrong!');        
        $Album->delete();
    }catch(Exception $e){
        exception_handler($e);
        $templator->assign('errors',array('Technical Error'=>array('message'=>$e->getMessage())));
        return array(
            'ok'        => false,
            'go'        => "my_albums",
            's'         => $sessionId,
        );
    }
    
    $go = $actionProcessor->getParam($actionProcessor->getGoName());
    return array(
        'ok'        =>true,
        'urlParams' =>array(
            'go'        => $go,
            's'         => $sessionId,
        ),
    );
}

?>