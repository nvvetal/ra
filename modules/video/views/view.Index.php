<?php
function videoViewIndex(View $View){
    $returnParams                   = array();
    $DBFactory                      = Registry::get('DBFactory');
    $Videos                         = new Videos($DBFactory->get_db_handle('rakscom'));
    $page                           = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
    $maxPerLine                     = 4;
    $videosData                     = $Videos->byOwnerGroupedLine('DESC', $page, 21, $maxPerLine);
    $videoRandom                    = $Videos->getRandomVideo();
    $videoMaxRated                  = $Videos->getMaxRatedVideo();
    $videoOfDay                     = $Videos->getVideoOfDay();
    $returnParams['videosData']     = $videosData;
    $returnParams['videoRandom']    = $videoRandom;
    $returnParams['videoMaxRated']  = $videoMaxRated;
    $returnParams['videoOfDay']     = (is_object($videoOfDay)) ? $videoOfDay : $videoRandom;
    require_once('../schools/school.class.php');
    $schoolObj                      = new school($DBFactory->get_db_handle('rakscom'));
    $returnParams['schoolObj']      = $schoolObj;
    $returnParams['maxPerLine']           = $maxPerLine;
    return $returnParams;
}
