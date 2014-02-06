<?php
function videoViewUserAlbums(View $View){
    $returnParams               = array();
    $page                       = isset($_REQUEST['page']) ? intval($_REQUEST['page']) : 1;
    $perPage                    = 10;
    $DBFactory                  = Registry::get('DBFactory');
    $userId                     = isset($_REQUEST['user_id']) ? intval($_REQUEST['user_id']) : 0;
    $Albums                     = new VideoAlbums($DBFactory->get_db_handle('rakscom'));
    $userAlbums                 = $Albums->byOwner('user', $userId, 'DESC', $page, 10);
    $returnParams['userAlbums'] = $userAlbums;      
    return $returnParams;
}
