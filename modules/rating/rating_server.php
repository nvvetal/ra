<?php


require_once("config.php");



if(!isset($_REQUEST['pass']) || 
	$_REQUEST['pass'] != 'cxvlkjl34mn6' || 
	!isset($_REQUEST['action']) ||
	!isset($_REQUEST['id']) ||
	!isset($_REQUEST['type']) ){
	
	add_to_log("[err some data not set!][ua ".@$_SERVER['HTTP_USER_AGENT']."][ip {$_SERVER['REMOTE_ADDR']}]",'error_rating_server');
    
    exit;
}

#Include                                                                                                                                   
require_once($GLOBALS['CLASSES_DIR']."DBFactory.class.php"); 
require_once("rating.class.php");                                                                                                          

#DBFactory                                                                                                                                 
                                                                                                                                           
$DBFactory = new DBFactory();                                                                                                              
                                                                                                                                           
$DBFactory->add_db_handle("rakscom",$db_params['rakscom']['server'],$db_params['rakscom']['database'],
    $db_params['rakscom']['user'],$db_params['rakscom']['password']);                                                                                                                                           
                                                                                                                                           
$rating_class = new rating($rules,$DBFactory->get_db_handle("rakscom")); 



switch ($_REQUEST['action']){
	case "add":
		$rating_class->add_rating_value($_REQUEST['id'],$_REQUEST['type']);
		add_to_log("[action add][item_id {$_REQUEST['id']}][name {$_REQUEST['type']}]",'rating_server');
	break;
	
	case "delete":
		$rating_class->delete_rating_value($_REQUEST['id'],$_REQUEST['type']);
		add_to_log("[action delete][item_id {$_REQUEST['id']}][name {$_REQUEST['type']}]",'rating_server');
		
	break;
	
	default:
		add_to_log("[action {$_REQUEST['action']}][err action unknown][item_id {$_REQUEST['id']}][name {$_REQUEST['type']}]",'error_rating_server');
	
	break;
	
	
}


?>