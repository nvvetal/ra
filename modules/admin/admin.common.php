<?php
require_once('config.php');
#logic
require_once("lib_admin.php");
require_once("admin_menu.class.php");
#logic
require_once($GLOBALS['LIB_ROOT']."/lib_auth.php");
require_once($GLOBALS['LIB_ROOT']."/bwls.php");

$go = @$_REQUEST['go'];

if($go == '')$go='index';

$action = @$_REQUEST['action'];

$s = isset($_REQUEST['s']) ? $_REQUEST['s'] : '';

sess_auth($s, $Session);

user_auth($s, $User, $Session);
$userType = $User->get_value($Session->get_value($s,'user_id'),'type');
if ($Session->get_value($s,'is_logged') == 0 || !in_array($userType,array('admin','moderator'))){
    header('Location: '.$GLOBALS['HTTP_PROJECT_ROOT']."?go=access_denied");
    exit;
}

require_once($GLOBALS['CLASSES_DIR']."Geo.class.php");
require_once($GLOBALS['CLASSES_DIR']."Utils.class.php");

$admin_menu = new admin_menu($GLOBALS['MODULES_DIR'],$DBFactory->get_db_handle("rakscom"));

$Utils = new Utils();

$Geo = new Geo($DBFactory->get_db_handle('rakscom'));

$smarty->assign_by_ref('s', $s);
$smarty->assign_by_ref('Geo', $Geo);
$smarty->assign_by_ref('Session', $Session);
$smarty->assign_by_ref('User', $User);
$smarty->assign_by_ref('Images', $Images);
$smarty->assign_by_ref('Utils', $Utils);
$userId = $Session->get_value($s,'user_id');
$smarty->assign_by_ref('user_id', $userId);

$menu_id = isset($_REQUEST['a_id']) ? $_REQUEST['a_id'] : '';
$menu_selected_id = isset($_REQUEST['a_sid']) ? $_REQUEST['a_sid'] : '';

$menu = $admin_menu->get_menu( $params, $menu_id, $menu_selected_id);

$event_menu = $admin_menu->get_menu_obj_by_id($menu_id);

$event_menu_module = (is_object($event_menu)) ? $event_menu->get_module() : '';

$ago = isset($_REQUEST['ago']) ? $_REQUEST['ago'] : '';


$event_params = array(
    'smarty'=>&$smarty,
    'a_id'=>$menu_id,
    'a_sid'=>$menu_selected_id,
    'menu_obj'=>$event_menu,
    'template_path'=>$GLOBALS['SMARTY_MODULES_DIR'].$event_menu_module."/admin/",
    'DBFactory'=>&$DBFactory,
    'User'=>&$User,
    'Session'=>&$Session,
    'Validator'=>&$Validator,
    'Images'=>&$Images,
    'action'=>isset($_REQUEST['action'])?$_REQUEST['action']:'',
    'ago'=>$ago,
    'module'=>$event_menu_module,
);


$ago = $admin_menu->event_dispatcher($event_params);
$event_params['ago'] = $ago;

$page_content = $admin_menu->page_dispatcher($event_params);
if($page_content !== false){
    $smarty->assign('admin_content',$page_content);
}


//echo "<pre>";
//print_r($menu);
$smarty->assign('admin_menu',$menu);

require_once ($GLOBALS['XAJAX_PATH']."xajax.inc.php");                                                                                                 
$xajax = new xajax("admin.server.php");                                                                                                 
$xajax->debugOff();         
//functions                                                                                                                                
$xajax->registerFunction('get_country_subdivisions');                                                                                                                                           
                                                                                                                                      
                                                                                                                                           
$xjs=$xajax->getJavascript($GLOBALS['XAJAX_JS_PATH']);                                                                                                 
$smarty->assign("xjs",$xjs);
?>