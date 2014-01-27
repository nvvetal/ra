<?php
function photoViewUserAlbums(View $View){
    $returnParams               = array();
    $page                       = isset($_REQUEST['page']) ? intval($_REQUEST['page']) : 1;
	$userId                     = isset($_REQUEST['user_id']) ? intval($_REQUEST['user_id']) : '';
    $perPage                    = 10;
    $DBFactory                  = Registry::get('DBFactory');
    $Session                    = Registry::get('Session');
	$User                    	= Registry::get('User');
    $sessionId                  = Registry::get('s');
	
    $Albums                     = new Albums($DBFactory->get_db_handle('rakscom'));
    $userAlbums                 = $Albums->byOwner('user', $userId, 'DESC', $page, 10);
    $returnParams['userAlbums'] = $userAlbums;
	$returnParams['userLogin']  = $User->get_value($userId, 'login');
    return $returnParams;
}

?>