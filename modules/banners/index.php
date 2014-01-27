<?php

require_once('config.php');



#Include

require_once($GLOBALS['CLASSES_DIR']."DBFactory.class.php");

require_once(SMARTY_DIR."Smarty.class.php");
require_once($GLOBALS['CLASSES_DIR']."Validator.class.php");
require_once($GLOBALS['CLASSES_DIR']."ValidatorContainer.class.php");

require_once(LIB_ROOT."/lib_auth.php");
require_once($GLOBALS['CLASSES_DIR']."User.class.php");
require_once($GLOBALS['CLASSES_DIR']."Session.class.php");

#Images
require_once($GLOBALS['CLASSES_DIR']."Images.class.php");


require_once($GLOBALS['CLASSES_DIR']."Geo.class.php");


require_once('banners.class.php');


#DBFactory
    
$DBFactory = new DBFactory();

$DBFactory->add_db_handle("rakscom",$db_params['rakscom']['server'],$db_params['rakscom']['database'],
    $db_params['rakscom']['user'],$db_params['rakscom']['password']);

#SMARTY
$smarty = new Smarty();
$smarty->template_dir = SMARTY_TEMPLATE_DIR;
$smarty->compile_dir = SMARTY_COMPILE_DIR;
$smarty->config_dir = SMARTY_CONFIG_DIR;
$smarty->cache_dir = SMARTY_CACHE_DIR;
$smarty->caching=false;

$Validator = new Validator();



$User = new User($DBFactory->get_db_handle("rakscom"));

$Session = new Session($DBFactory->get_db_handle("rakscom"));



$Images = new Images($DBFactory->get_db_handle('rakscom'),IMAGEMAGICK_PATH,$image_rules);

$go = 'index';


$banners = new banners($DBFactory->get_db_handle('rakscom'));


$params['banners'] = &$banners;
$params['Validator'] = $Validator;
$params['User'] = &$User;
$params['Session'] = &$Session;
$params['smarty'] = &$smarty;
$params['modules'] = $modules;
$params['DBFactory'] = &$DBFactory;
$params['Images'] = &$Images;



$smarty->assign('banners',$banners);

$smarty->assign("http_images_path",HTTP_IMAGES_PATH);
$smarty->assign("http_project_path",HTTP_PROJECT_PATH);
$smarty->assign("http_module_path",HTTP_PROJECT_PATH.$module_name.'/');





$smarty->assign("smarty_module_path","modules/$module_name/");

$content = $smarty->fetch("modules/$module_name/".$go.'.tpl');

echo $content;



?>