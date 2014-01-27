<?php
function photoViewSchoolAlbumAdd(View $View){
    $returnParams               = array();
    require_once('../schools/school.class.php');
    $DBFactory                  = Registry::get('DBFactory');
    $school                     = new school($DBFactory->get_db_handle('rakscom'));
    $schoolId                   = isset($_REQUEST['school_id']) ? intval($_REQUEST['school_id']) : 0;
    $schoolCurrent              = $school->get_school($schoolId);    
    $returnParams['schoolCurrent'] = $schoolCurrent;
    return $returnParams;
}

?>