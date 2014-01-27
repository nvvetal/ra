<?php

require_once('school.common.php');


$go = @$_REQUEST['go'];
if($go == '')$go='schools';
$action = @$_REQUEST['action'];



sess_auth($s, $Session);

user_auth($s, $User, $Session);







$params['school'] = $school;
$params['school_blog'] = $school_blog;

$params['Validator'] = $Validator;
$params['User'] = $User;
$params['Session'] = $Session;
$params['smarty'] = $smarty;
$params['modules'] = $modules;
$params['s'] = $s;
Registry::set('s', $s);
$params['DBFactory'] = $DBFactory;
$params['Images'] = $Images;
$params['Geo'] = $Geo;



$go = bwls($go, $action, $params);

$go = school_actions($go,$action,$params);
$smarty->assign('s',$s);
$smarty->assign('user_id',$Session->get_value($s,'user_id'));

//$smarty->display("modules/$module_name/".$go.'.tpl');
$params = array(
	'templator'        => $smarty,
	'templatesPath'    => "modules/$module_name/",
);
$actionProcessor = new ActionProcessor($module_name, $params);
$actionProcessor->setGoName('go');
$actionProcessor->showContent();

require_once($GLOBALS['LIB_ROOT'].'/debug.php');


?>