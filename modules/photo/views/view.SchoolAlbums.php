<?php
function photoViewSchoolAlbums(View $View){
    $returnParams                   = array();
    $page                           = isset($_REQUEST['page']) ? intval($_REQUEST['page']) : 1;
    $perPage                        = 10;
    $DBFactory                      = Registry::get('DBFactory');
    $Session                        = Registry::get('Session');
    $sessionId                      = Registry::get('s');
    $Albums                         = new Albums($DBFactory->get_db_handle('rakscom'));
    require_once('../schools/school.class.php');
    $schoolId                       = isset($_REQUEST['school_id']) ? intval($_REQUEST['school_id']) : 0;    
    $school                         = new school($DBFactory->get_db_handle('rakscom'));
    $schoolCurrent                  = $school->get_school($schoolId);
    $returnParams['schoolCurrent']  = $schoolCurrent;   
    $userId                         = $Session->get_value($sessionId,'user_id');
    $schoolAlbums                   = $Albums->byOwner('school', $schoolId, 'DESC', $page, 10);
    $returnParams['schoolAlbums']   = $schoolAlbums;      
       
    $returnParams['isOwner']        = $schoolCurrent['owner_id'] == $userId ? 1 : 0;      
    return $returnParams;
}

?>