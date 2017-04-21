<?php
require_once __DIR__ . '/../vendor/autoload.php';

require_once('../lib/config.php');
require_once($GLOBALS['CLASSES_DIR']."Geo.class.php");
$Geo = new Geo($DBFactory->get_db_handle('rakscom'));
$smarty->assign('Geo',$Geo);

require_once ($GLOBALS['XAJAX_PATH']."xajax.inc.php");                                                                                                 
$xajax = new xajax("server.php");                                                                                                 
$xajax->debugOff();                                                                                                                        


$xajax->registerFunction('get_country_subdivisions'); 
$xajax->registerFunction('get_subdivision_cities'); 


$xjs=$xajax->getJavascript($GLOBALS['XAJAX_JS_PATH']);                                                                                                 
$smarty->assign("xjs",$xjs);
