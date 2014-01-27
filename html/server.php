<?php
require_once('common.php');


function get_country_subdivisions($country_id){
    global $smarty;
    $country_id = intval($country_id);
    $objResponse = new xajaxResponse();
    $smarty->assign('country_id',$country_id);
    $data = $smarty->fetch('i_country_subdivisions.tpl');
    $objResponse->addAssign('subdivision_id','innerHTML',$data);
    $objResponse->addScript('xajax_get_subdivision_cities(0);');
    return $objResponse; 
}

function get_subdivision_cities($subdivision_id){
    global $smarty;
    $subdivision_id = intval($subdivision_id);
    $objResponse = new xajaxResponse();
    $smarty->assign('subdivision_id',$subdivision_id);
    $data = $smarty->fetch('i_cities.tpl');
    $objResponse->addAssign('city_id','innerHTML',$data);
    return $objResponse; 
}

$xajax->processRequests();
?>