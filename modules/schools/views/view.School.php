<?php
function schoolsViewSchool(View $View){
    require_once('../photo/Albums.class.php');
    require_once('../photo/Photos.class.php');
    require_once('../photo/Photo.class.php');
    require_once('../photo/Album.class.php');
    $returnParams                   = array();
    $schoolId                       = isset($_REQUEST['school_id']) ? $_REQUEST['school_id'] : '';
    $DBFactory                      = Registry::get('DBFactory');
    $Albums                         = new Albums($DBFactory->get_db_handle('rakscom'));
    $schoolAlbums                   = $Albums->byOwner('school', $schoolId, 'DESC', 1, 10000);
    $returnParams['schoolAlbums']   = $schoolAlbums;     
    return $returnParams;
}

?>