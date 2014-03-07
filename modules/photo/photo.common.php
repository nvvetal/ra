<?php

require_once('config.php');

#Include

require_once("lib_photo.php");


$Utils = new Utils();
#SMARTY
global $Geo;
$go = @$_REQUEST['go'];
if($go == '') $go='index';
$action = @$_REQUEST['action'];
$s = isset($_REQUEST['s']) ? $_REQUEST['s'] : '';
$Geo = new Geo($DBFactory->get_db_handle('rakscom'));
$params['Validator'] = $Validator;
$params['User'] = $User;
$params['Session'] = $Session;
Registry::set('Session', $Session);
Registry::set('s', $s);
$params['smarty'] = $smarty;
$params['modules'] = $modules;
$params['s'] = $s;
$params['DBFactory'] = $DBFactory;
$params['Images'] = $Images;
$params['Geo'] = $Geo;
$smarty->assign_by_ref('s',$s);
$smarty->assign_by_ref('Geo',$Geo);
$smarty->assign_by_ref('Session', $Session);
$smarty->assign_by_ref('User', $User);
$smarty->assign_by_ref('Images', $Images);
$smarty->assign_by_ref('Utils',$Utils);
$user_id = $Session->get_value($s, 'user_id');
$smarty->assign_by_ref('user_id', $user_id);
$metaURL = getMetaURL($s);
$smarty->assign("metaURL", $metaURL);
require_once ($GLOBALS['XAJAX_PATH']."xajax.inc.php");                                                                                                 
$xajax = new xajax("photo.server.php");                                                                                                 
$xajax->debugOff(); 
                                                                                                                     
                                                                                                                                          
                                                                                                                                           
//functions                                                                                                                                
$xajax->registerFunction('getPhotoComments');                                                                                                                                       
$xajax->registerFunction('addPhotoComment');                                                                                                                                       
$xajax->registerFunction('getPhotoRating');                                                                                                                                       
$xajax->registerFunction('setPhotoRating');                                                                                                                                       
$xajax->registerFunction('getPhotoAdditional');                                                                                                                                       
$xajax->registerFunction('showEditPhoto');
$xajax->registerFunction('savePhotoData');
$xajax->registerFunction('setPhotoAlbumName');
$xajax->registerFunction('showPhotoAlbumEdit');

$xjs=$xajax->getJavascript($GLOBALS['XAJAX_JS_PATH']);                                                                                                 
$smarty->assign("xjs",$xjs);
