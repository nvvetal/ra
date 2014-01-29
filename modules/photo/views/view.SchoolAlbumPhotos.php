<?php
function photoViewSchoolAlbumPhotos(View $View){
    $returnParams               = array();
    $albumId                    = isset($_REQUEST['album_id']) ? $_REQUEST['album_id'] : 0;
    $page                       = isset($_REQUEST['page']) ? intval($_REQUEST['page']) : 1;
    $perPage                    = 10;    
    $DBFactory                  = Registry::get('DBFactory');
    $Session                    = Registry::get('Session');
    $sessionId                  = Registry::get('s');
    $userId                     = $Session->get_value($sessionId,'user_id');
    if(empty($userId)) {
        header('Location: /');
        exit;
    }
    $Photos                     = new Photos($DBFactory->get_db_handle('rakscom'));
    $schoolAlbum                = new Album($DBFactory->get_db_handle('rakscom'));
    $schoolAlbum->findById($albumId);
    require_once('../schools/school.class.php');
    $schoolId                       = isset($_REQUEST['school_id']) ? intval($_REQUEST['school_id']) : 0;    
    $school                         = new school($DBFactory->get_db_handle('rakscom'));
    $schoolCurrent                  = $school->get_school($schoolId);
    $schoolPhotos                   = $Photos->byOwner('school', $schoolId, $albumId, 'DESC', $page, $perPage);
    $returnParams['isOwner']        = ($schoolCurrent['owner_id'] == $userId) ? 1 : 0; 
    $returnParams['schoolCurrent']  = $schoolCurrent;    
    $returnParams['schoolAlbum']    = $schoolAlbum;     
    $returnParams['schoolPhotos']   = $schoolPhotos;      
    return $returnParams;
}

?>