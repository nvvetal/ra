<?php
require_once('common.php');
#Include
require_once($GLOBALS['MODULES_DIR']."schools/school.class.php");
#logic
require_once($GLOBALS['LIB_ROOT']."/bwls.php");
#user
require_once($GLOBALS['LIB_ROOT']."/lib_auth.php");
$school = new school($DBFactory->get_db_handle('rakscom'));
$go = @$_REQUEST['go'];
if($go == '') $go='index';
$action = @$_REQUEST['action'];
$s = isset($_REQUEST['s']) ? $_REQUEST['s'] : '';
sess_auth($s, $Session);
user_auth($s, $User, $Session);
$params['Validator'] = $Validator;
$params['school'] = $school;
$params['User'] = $User;
$params['Session'] = $Session;
$params['smarty'] = $smarty;
$params['modules'] = $modules;
$params['s'] = $s;

$params['DBFactory'] = $DBFactory;
$params['Images'] = $Images;
$go = bwls($go, $action, $params);
$go = page_content($go,$action,$params);
$smarty->assign('s',$s);
Registry::set('s', $s);
$smarty->assign('Session', $Session);
$smarty->assign('User', $User);
$smarty->assign('Images', $Images);
$smarty->assign('school', $school);
$smarty->assign('user_id', $Session->get_value($s,'user_id'));

$smarty->display($go.'.tpl');
require_once($GLOBALS['LIB_ROOT'].'/debug.php');
?>