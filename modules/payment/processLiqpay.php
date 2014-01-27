<?php

$module_name = "payment";
require_once("../../lib/config.php");




$Payment = Registry::get('Payment');
require_once($GLOBALS['CLASSES_DIR'].'payment/payment_liqpay.class.php');
$paymentLiqpay = new paymentLiqpay();  
$dbh = Registry::get('DBFactory')->get_db_handle("rakscom");  
$paymentLiqpay->setDbh($dbh);
$Payment = Registry::get('Payment');
$paymentConfig = $Payment->getPaymentConfig('liqpay');   

$signature = isset($_REQUEST['signature']) ? $_REQUEST['signature'] : '';
$operation_xml = isset($_REQUEST['operation_xml']) ? $_REQUEST['operation_xml'] : '';

$params = array(
    'merchant_id'           => $paymentConfig['merchant_id'],
    'merchant_signature'    => $paymentConfig['merchant_signature'],    
    'signature'             => $signature,    
    'operation_xml'         => $operation_xml,    
);
$response = $paymentLiqpay->savePaymentData($params);
add_to_log("[response ".print_r($response,true)."][got ".print_r($_REQUEST,true)."]",'payment');

if($response['ok'] == false) exit;

$order = $Payment->getOrder($response['order_id']);

if($order['type'] == 'prepay'){
    $prices = $Payment->getPrices($order['currency']);
    $points = $prices[$order['amount']];
    $User->inc_raks_money($order['user_id'],$points);
    $Payment = Registry::get('Payment');
    $Payment->addStats($order['user_id'],'prepay',1);
    $Payment->addStats($user_id,'raks_in',$points);     
    add_to_log("[action add][type payment prepay][order_id {$response['order_id']}][points $points]","points");
}
?>