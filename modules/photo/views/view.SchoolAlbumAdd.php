<?php
function photoViewSchoolAlbumAdd(View $View){
    $returnParams               = array();
    require_once('../schools/school.class.php');
    $DBFactory                  = Registry::get('DBFactory');
    $school                     = new school($DBFactory->get_db_handle('rakscom'));
    $schoolId                   = isset($_REQUEST['school_id']) ? intval($_REQUEST['school_id']) : 0;
    $schoolCurrent              = $school->get_school($schoolId);
    $Session                    = Registry::get('Session');
    $sessionId                  = Registry::get('s');
    $userId                     = $Session->get_value($sessionId,'user_id');
    if(empty($userId)) {
        header('Location: /');
        exit;
    }
    $returnParams['schoolCurrent'] = $schoolCurrent;
    return $returnParams;
}

?>