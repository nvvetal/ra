<?php
function photoViewSchoolAlbumPhotoAdd(View $View){
    $returnParams               = array();
    $albumId                    = isset($_REQUEST['album_id']) ? $_REQUEST['album_id'] : 0;
    $DBFactory                  = Registry::get('DBFactory');
    $Session                    = Registry::get('Session');
    $sessionId                  = Registry::get('s');
    $userId                     = $Session->get_value($sessionId,'user_id');
    if(empty($userId)) {
        header('Location: /');
        exit;
    }
    require_once('../schools/school.class.php');
    $schoolId                       = isset($_REQUEST['school_id']) ? intval($_REQUEST['school_id']) : 0;    
    $school                         = new school($DBFactory->get_db_handle('rakscom'));
    $schoolCurrent                  = $school->get_school($schoolId);    
    $schoolAlbum                  = new Album($DBFactory->get_db_handle('rakscom'));
    $schoolAlbum->findById($albumId);
    $returnParams['schoolAlbum']  = $schoolAlbum;      
    $returnParams['schoolCurrent']  = $schoolCurrent;      
    return $returnParams;
}

?>