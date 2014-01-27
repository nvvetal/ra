<?php

require_once('calendar.common.php');

function add_container_element($id,$name,$tpl_name,$value){
    global $smarty;
    $objResponse = new xajaxResponse();
    $iid = 'lfm_'.md5(mt_rand().microtime());        
    $smarty->assign('name',$name);
    $smarty->assign('value',$value);
    $smarty->assign('delete_url',"document.getElementById('$id').removeChild(document.getElementById('$iid'));");
    $res = $smarty->fetch($GLOBALS['SMARTY_MODULE_DIR'].$tpl_name.'.tpl');
    $objResponse->addCreate($id,'div',$iid);
    $objResponse->addAssign($iid,"innerHTML",$res);
    //$objResponse->addAlert('test');
    return $objResponse; 
}

function get_calendar_country_subdivisions($country_id){
    global $smarty;
    $country_id = intval($country_id);
    $objResponse = new xajaxResponse();
    $smarty->assign('country_id',$country_id);
    $data = $smarty->fetch('modules/calendar/i_country_subdivisions.tpl');
    $objResponse->addAssign('subdivision_id','innerHTML',$data);
    $objResponse->addAssign('city_id','innerHTML','');
    return $objResponse; 
}

function get_calendar_subdivision_cities($subdivision_id){
    global $smarty;
    $subdivision_id = intval($subdivision_id);
    $objResponse = new xajaxResponse();
    $smarty->assign('subdivision_id',$subdivision_id);
    $data = $smarty->fetch('modules/calendar/i_cities.tpl');
    $objResponse->addAssign('city_id','innerHTML',$data);
    return $objResponse; 
}

function set_vip($calendarId, $s)
{
	$objResponse 	= new xajaxResponse();
	$Session		= Registry::get('Session');
	$Calendar		= Registry::get('calendar');
	$User 			= Registry::get('User');
	$i18n 			= Registry::get('i18n');
	$user_id 		= $Session->get_value($s, 'user_id');
    $isOwner 		= $Calendar->is_user_owner($calendarId, $user_id);
	$raksMoney 		= $Calendar->get_cost('makeCalendarVIP');
    if(!$isOwner){
    	$text = $i18n->get_translate(Registry::get('lang'), 'You are not owner of this action!');
		$objResponse->addAlert($text);
		return $objResponse;	
    }
    $canPay = $User->can_pay_raks_money($user_id, $raksMoney);
    if(!$canPay['ok']){
    	$text = $i18n->get_translate(Registry::get('lang'), 'You dont have enought raks money to pay!');
		$objResponse->addAlert($text);
		return $objResponse;		
    }
	if($Calendar->is_vip($calendarId)){
    	$text = $i18n->get_translate(Registry::get('lang'), 'Action already VIP!');
		$objResponse->addAlert($text);
		return $objResponse;						
	}
	$User->pay_raks_money($user_id, $raksMoney); 
   	$Calendar->set_vip($calendarId);
        
    $Payment = Registry::get('Payment');
    $Payment->addStats($user_id, 'calendar_premium', 1);
    $Payment->addStats($user_id, 'raks_out', $raksMoney);
    $text = $i18n->get_translate(Registry::get('lang'), 'Action VIPped succeffully!');
	$objResponse->addAlert($text);
	$objResponse->addAssign('vip', 'innerHTML', '');
	return $objResponse;		
}

$xajax->processRequests();
?>