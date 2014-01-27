<?php

function photo_actions($go,$action,$params){
    switch ($action){
        case "upload":
            $DBFactory  = Registry::get('DBFactory');
            $Photo      = new Photo($DBFactory->get_db_handle('rakscom'));
            $photoId  = $Photo->uploadPhoto('image');
            if($photoData === false) return $go;
            $photoParams = array(
                'name'          => '',
                'album_id'      => 1,
                'owner_type'    => 'user',
                'owner_id'      => 1,
                'created_time'  => time(),
                'image_id'      => $photoId,
            );
            $Photo->create($photoParams);
            
        break;
        /*
        case "my_album_add":
            $name       = isset($_REQUEST['name']) ? $_REQUEST['name'] : '';
            if(empty($name)){
                $params['smarty']->assign('errors',array('name'=>array('message'=>'Please set name of album!')));
                $go = "my_album_add";
                return $go;             
            }
            $s          = isset($_REQUEST['s']) ? $_REQUEST['s'] : '';
            $DBFactory  = Registry::get('DBFactory');
            $Album      = new Album($DBFactory->get_db_handle('rakscom'));
            $data       = array(
                'name'          => $name,
                'created_time'  => time(),
                'owner_type'    => 'user',
                'owner_id'      => $params['Session']->get_value($params['s'],'user_id'),
            );
            $Album->create($data);
            $albumId    = $Album->id;
            header('Location: ?go=my_album_photos&album_id='.$albumId.'&s='.$s);
            exit;
        break;
        */
    }
    return $go;
}
?>