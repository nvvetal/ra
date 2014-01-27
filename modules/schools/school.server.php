<?php

require_once('school.common.php');

function get_school_country_subdivisions($country_id){
    global $smarty;
    $country_id = intval($country_id);
    $objResponse = new xajaxResponse();
    $smarty->assign('country_id',$country_id);
    $data = $smarty->fetch('modules/schools/i_country_subdivisions.tpl');
    $objResponse->addAssign('subdivision_id','innerHTML',$data);
    $objResponse->addAssign('city_id','innerHTML','');
    return $objResponse; 
}


function get_school_country_subdivisions_search($country_id){
    global $smarty;
    $country_id = intval($country_id);
    $objResponse = new xajaxResponse();
    $smarty->assign('country_id',$country_id);
    $data = $smarty->fetch('modules/schools/i_search_country_subdivisions.tpl');
    $objResponse->addAssign('subdivision_id','innerHTML',$data);
    $objResponse->addScript('xajax_get_school_subdivision_cities_created(0);');
    return $objResponse; 
}

function get_school_subdivision_cities($subdivision_id){
    global $smarty;
    $subdivision_id = intval($subdivision_id);
    $objResponse = new xajaxResponse();
    $smarty->assign('subdivision_id',$subdivision_id);
    $data = $smarty->fetch('modules/schools/i_cities.tpl');
    $objResponse->addAssign('city_id','innerHTML',$data);
    return $objResponse; 
}

function get_school_subdivision_cities_created($subdivision_id){
    global $smarty;
    $subdivision_id = intval($subdivision_id);
    $objResponse = new xajaxResponse();
    $smarty->assign('subdivision_id',$subdivision_id);
    $data = $smarty->fetch('modules/schools/i_cities_created.tpl');
    $objResponse->addAssign('city_id','innerHTML',$data);
    return $objResponse; 
}

$xajax->processRequests();
?>