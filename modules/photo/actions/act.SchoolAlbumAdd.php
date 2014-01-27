<?php

function photoActionSchoolAlbumAdd( ActionProcessor $actionProcessor ){

    $templator = $actionProcessor->getParam('templator');    
    
    $name       = isset($_REQUEST['name']) ? $_REQUEST['name'] : '';
    $schoolId   = isset($_REQUEST['school_id']) ? $_REQUEST['school_id'] : 0;
    if(empty($name)){
        $templator->assign('errors',array('name'=>array('message'=>'Please set name of album!')));
        return array(
            'ok'        => false,
            'go'        => "school_album_add",
        );
    }
    //todo: check owner of school
    $Session    = Registry::get('Session');
    $sessionId  = Registry::get('s');
    $DBFactory  = Registry::get('DBFactory');
    $userId     = $Session->get_value($sessionId, 'user_id');
    $Album      = new Album($DBFactory->get_db_handle('rakscom'));
    $data       = array(
        'name'          => $name,
        'created_time'  => time(),
        'owner_type'    => 'school',
        'owner_id'      => $schoolId,
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
            'school_id' => $schoolId,
        ),
    );
}

?>