<?php

require_once('config.php');
$s = isset($_REQUEST['s']) ? $_REQUEST['s'] : '';
#Include

require_once("lib_school.php");
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


require_once('school.class.php');
require_once('school_blog.class.php');
global $Geo;

$Utils = new Utils();
$Geo = new Geo($DBFactory->get_db_handle('rakscom'));

$school = new school($DBFactory->get_db_handle('rakscom'));
$school_blog = new school_blog('school_blog',$DBFactory->get_db_handle('rakscom'));


$smarty->assign_by_ref('school',$school);
$smarty->assign_by_ref('school_blog',$school_blog);

$smarty->assign_by_ref('Geo',$Geo);
$smarty->assign_by_ref('Session', $Session);
$smarty->assign_by_ref('User', $User);
$smarty->assign_by_ref('Images', $Images);

$smarty->assign_by_ref('Utils',$Utils);
$user_id = $Session->get_value($s, 'user_id');
$smarty->assign_by_ref('user_id', $user_id);

$metaDescription = 'Танец живота обучение, обучение восточному танцу, школы танца живота, школы восточного танца, школы индийского танца, обучение индийскому танцу, школы трайбла, обучение трайблу, школа танца Аллы Кушнир, Школа танца Марты Корзун, школа танца Дарьи Мицкевич';
$smarty->assign('metaDescription', $metaDescription);

require_once ($GLOBALS['XAJAX_PATH']."xajax.inc.php");                                                                                                 
$xajax = new xajax("school.server.php");                                                                                                 
$xajax->debugOff();                                                                                                                        

$xajax->registerFunction('get_school_country_subdivisions'); 
$xajax->registerFunction('get_school_subdivision_cities'); 
$xajax->registerFunction('get_school_subdivision_cities_created'); 
$xajax->registerFunction('get_school_country_subdivisions_search'); 

$xjs=$xajax->getJavascript($GLOBALS['XAJAX_JS_PATH']);                                                                                                 
$smarty->assign("xjs",$xjs);
