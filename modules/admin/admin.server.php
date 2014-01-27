<?php

require_once('admin.common.php');

function get_country_subdivisions($country_id){
    global $smarty;
    $country_id = intval($country_id);
    $objResponse = new xajaxResponse();
    $smarty->assign('country_id',$country_id);
    $data = $smarty->fetch('modules/admin/admin/i_country_subdivisions.tpl');
    $objResponse->addAssign('subdivision_id','innerHTML',$data);
    return $objResponse; 
}

$xajax->processRequests();
?>