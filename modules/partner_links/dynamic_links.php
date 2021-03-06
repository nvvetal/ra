<?php
require_once('config.php');



#Include

require_once("lib_partner_links.php");
require_once($GLOBALS['CLASSES_DIR']."DBFactory.class.php");
require_once($GLOBALS['SMARTY_DIR']."Smarty.class.php");
require_once($GLOBALS['CLASSES_DIR']."Validator.class.php");
require_once($GLOBALS['CLASSES_DIR']."ValidatorContainer.class.php");

#logic
require_once($GLOBALS['LIB_ROOT']."/bwls.php");

#user
require_once($GLOBALS['LIB_ROOT']."/lib_auth.php");
require_once($GLOBALS['CLASSES_DIR']."User.class.php");
require_once($GLOBALS['CLASSES_DIR']."Session.class.php");

#Images
require_once($GLOBALS['CLASSES_DIR']."Images.class.php");


require_once($GLOBALS['CLASSES_DIR']."Geo.class.php");


require_once('partner_links.class.php');


#DBFactory
    
$DBFactory = new DBFactory();

$DBFactory->add_db_handle("rakscom",$db_params['rakscom']['server'],$db_params['rakscom']['database'],
    $db_params['rakscom']['user'],$db_params['rakscom']['password']);
#SMARTY
$smarty = new Smarty();
$smarty->template_dir = $GLOBALS['SMARTY_TEMPLATE_DIR'];
$smarty->compile_dir = $GLOBALS['SMARTY_COMPILE_DIR'];
$smarty->config_dir = $GLOBALS['SMARTY_CONFIG_DIR'];
$smarty->cache_dir = $GLOBALS['SMARTY_CACHE_DIR'];
$smarty->caching=false;

$Validator = new Validator();



$User = new User($DBFactory->get_db_handle("rakscom"));

$Session = new Session($DBFactory->get_db_handle("rakscom"));
$Images = new Images($DBFactory->get_db_handle('rakscom'),$GLOBALS['IMAGEMAGICK_PATH'], $image_rules);

$go = 'external_show_links';

$s = isset($_REQUEST['s']) ? $_REQUEST['s'] : '';



sess_auth($s, $Session);

user_auth($s, $User, $Session);


$partner_links = new partner_links($DBFactory->get_db_handle('rakscom'));

$Geo = new Geo($DBFactory->get_db_handle('rakscom'));

$params['partner_links'] = &$partner_links;
$params['Validator'] = $Validator;
$params['User'] = &$User;
$params['Session'] = &$Session;
$params['smarty'] = &$smarty;
//$params['modules'] = $modules;
$params['s'] = $s;
$params['DBFactory'] = &$DBFactory;
$params['Images'] = &$Images;

$smarty->assign('s',$s);
$smarty->assign('partner_links',$partner_links);
$smarty->assign('Geo',$Geo);
$smarty->assign('Session', $Session);
$smarty->assign('User', $User);
$smarty->assign('Images', $Images);

$smarty->assign('user_id',$Session->get_value($s,'user_id'));
$smarty->assign("http_images_path",$GLOBALS['HTTP_IMAGES_PATH']);
$smarty->assign("http_project_path",$GLOBALS['HTTP_PROJECT_PATH']);
$smarty->assign("http_module_path",$GLOBALS['HTTP_PROJECT_PATH'].$module_name.'/');
$smarty->assign("smarty_module_path","modules/$module_name/");

$smarty->display("modules/$module_name/".$go.'.tpl');