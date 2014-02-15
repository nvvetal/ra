<?php

require_once('shop.common.php');

function sendUserGift($dataParse){
    $objResponse 	= new xajaxResponse();
    $i18n 			= Registry::get('i18n');
    $DBFactory 		= Registry::get('DBFactory');
    $dbh			= $DBFactory->get_db_handle('rakscom');
    $Session		= Registry::get('Session');

    parse_str($dataParse, $data);
    $sessId			= isset($data['s']) ? $data['s'] : '';
    $userId 		= $Session->get_value($sessId,'user_id');
    //check user is logged
    if(is_null($userId) || empty($userId)){
        $text = $i18n->get_translate(Registry::get('lang'), 'Please login!');
        $objResponse->addAssign('user-send-result', 'innerHTML', $text);
        return $objResponse;
    }

    //check username
    $userName 	= isset($data['user']) ? $data['user'] : '';
    $message	= isset($data['message']) ? $data['message'] : '';
    //add_to_log(var_export($dataParse,true),'zzz');
    $User 		= Registry::get('User');
    $isExists 	= $User->is_user_exists(array('login'=>$userName));
    if(!$isExists){
        $text = $i18n->get_translate(Registry::get('lang'), 'User not existing!');
        $objResponse->addAssign('user-send-result', 'innerHTML', $text);
        return $objResponse;
    }
    //check raks credits
    $giftId = isset($data['gift_id']) ? $data['gift_id'] : '';
    $shopGood = new ShopGood($dbh);
    $shopGood->findById($giftId);
    $giftPrice = $shopGood->price;
    $canPay = $User->can_pay_raks_money($userId, $giftPrice);
    if($canPay['ok'] !== true){
        $text = $i18n->get_translate(Registry::get('lang'), 'You have not enough raks money!');
        $objResponse->addAssign('user-send-result', 'innerHTML', $text);
        return $objResponse;
    }
    $toUserId = $User->find_user_id_by_login($userName);
    if($userId == $toUserId){
        $text = $i18n->get_translate(Registry::get('lang'), 'You cannot send gift to yourself!');
        $objResponse->addAssign('user-send-result', 'innerHTML', $text);
        return $objResponse;
    }


    $User->pay_raks_money($userId, $giftPrice);
    $Payment = Registry::get('Payment');
    $Payment->addStats($userId, 'gift', $giftPrice);
    $Payment->addStats($userId,'raks_out', $giftPrice);
    //send gift
    $ShopUserItem = new ShopUserItem($dbh);
    $ShopUserItem->addUserGift($userId, $toUserId, $giftId, $message);
    $text = '<b>'.$i18n->get_translate(Registry::get('lang'), 'Gift sent successfully!').'</b>'.
        '<br/><a style="color: red;" href="javascript:void(0)" onclick="$( \'#dialog-select-gift-user\' ).dialog( \'close\' );">'.
        $i18n->get_translate(Registry::get('lang'), 'Send more gifts!').
        '</a>';
    $objResponse->addAssign('user-send-result-success', 'innerHTML', $text);
    if($Session->get_value($sessId, 'shop_user_id') != NULL){
        $Session->set_value($sessId, 'shop_user_id', NULL);
    }
    return $objResponse;
}

$xajax->processRequests();