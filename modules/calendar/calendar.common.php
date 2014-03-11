<?php

require_once('config.php');

#Include

require_once("lib_calendar.php");
require_once($GLOBALS['CLASSES_DIR']."DBFactory.class.php");
require_once($GLOBALS['SMARTY_DIR']."Smarty.class.php");
require_once($GLOBALS['CLASSES_DIR']."Validator.class.php");
require_once($GLOBALS['CLASSES_DIR']."ValidatorContainer.class.php");
require_once($GLOBALS['CLASSES_DIR']."Utils.class.php");

#logic
require_once($GLOBALS['LIB_ROOT']."/bwls.php");

#user
require_once($GLOBALS['LIB_ROOT']."/lib_auth.php");
require_once($GLOBALS['CLASSES_DIR']."User.class.php");
require_once($GLOBALS['CLASSES_DIR']."Session.class.php");

#Images
require_once($GLOBALS['CLASSES_DIR']."Images.class.php");
require_once($GLOBALS['CLASSES_DIR']."Geo.class.php");
require_once('calendar.class.php');
require_once('calendar_forum.class.php');


$Utils = new Utils();



#SMARTY
global $Geo;




$go = @$_REQUEST['go'];

if($go == '')$go='calendar';
$action = @$_REQUEST['action'];

$s = isset($_REQUEST['s']) ? $_REQUEST['s'] : '';


$calendar = new calendar($DBFactory->get_db_handle('rakscom'));
$calendar_forum = new calendar_forum();

$Geo = new Geo($DBFactory->get_db_handle('rakscom'));

$params['calendar'] = $calendar;

$params['Validator'] = $Validator;
$params['User'] = $User;
$params['Session'] = $Session;
$params['smarty'] = $smarty;
$params['modules'] = $modules;
$params['s'] = $s;
$params['DBFactory'] = $DBFactory;
$params['Images'] = $Images;
$params['Geo'] = $Geo;

$smarty->assign_by_ref('s', $s);
Registry::set('s', $s);
Registry::set('calendar', $calendar);
$smarty->assign_by_ref('calendar', $calendar);
$smarty->assign_by_ref('calendar_forum', $calendar_forum);

$smarty->assign_by_ref('Geo',$Geo);
$smarty->assign_by_ref('Session',$Session);
$smarty->assign_by_ref('User',$User);
$smarty->assign_by_ref('Images',$Images);

$smarty->assign_by_ref('Utils',$Utils);
$user_id = $Session->get_value($s, 'user_id');
$smarty->assign_by_ref('user_id', $user_id);
$metaDescription = 'Фестивали восточного танца, конкурсы по восточному танцу';
$smarty->assign('metaDescription', $metaDescription);


require_once ($GLOBALS['XAJAX_PATH']."xajax.inc.php");                                                                                                 
$xajax = new xajax("calendar.server.php");                                                                                                 
$xajax->debugOff();                                                                                                                        
                                                                                                                                           
                                                                                                                                           
//functions                                                                                                                                
$xajax->registerFunction('add_container_element');                                                                                                                                           
$xajax->registerFunction('get_calendar_country_subdivisions');                                                                                                                                           
$xajax->registerFunction('get_calendar_subdivision_cities');  
$xajax->registerFunction('set_vip'); 
                                                                                                                                         
                                                                                                                                           
$xjs=$xajax->getJavascript($GLOBALS['XAJAX_JS_PATH']);                                                                                                 
$smarty->assign("xjs",$xjs);
