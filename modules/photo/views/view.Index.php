<?php
function photoViewIndex(View $View){
    $returnParams                   = array();
    $DBFactory                      = Registry::get('DBFactory');
    $page                           = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
    $Photos                         = new Photos($DBFactory->get_db_handle('rakscom'));
    $maxPerLine                     = 9;
    $photosData                     = $Photos->byOwnerGroupedLine('DESC', $page, 21, $maxPerLine);
    $photoRandom                    = $Photos->getRandomPhoto();
    $photoMaxRated                  = $Photos->getMaxRatedPhoto();
    $photoOfDay                     = $Photos->getPhotoOfDay();
    $returnParams['photosData']     = $photosData;      
    $returnParams['photoRandom']    = $photoRandom;      
    $returnParams['photoMaxRated']  = $photoMaxRated;      
    $returnParams['photoOfDay']     = $photoOfDay;
    require_once('../schools/school.class.php');
    $schoolObj                      = new school($DBFactory->get_db_handle('rakscom'));
    $returnParams['schoolObj']      = $schoolObj;
    $returnParams['page']           = $page;
    $returnParams['maxPerLine']     = $maxPerLine;
    return $returnParams;
}

?>