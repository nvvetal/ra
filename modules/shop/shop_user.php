<?php

require_once('config.php');

$go = isset($_REQUEST['go']) ? $_REQUEST['go'] : '';

if(!in_array($go, array('by_tag', 'by_user'))){
	exit;
}

$smarty->assign('User', $User);
$params = array(
	'templator'        => $smarty,
	'templatesPath'    => "modules/$module_name/",
);
require_once($GLOBALS["CLASSES_DIR"].'ActionProcessor.class.php');
$actionProcessor = new ActionProcessor($module_name, $params);
$actionProcessor->setGoName('go');
$actionProcessor->showContent();
require_once($GLOBALS['LIB_ROOT'].'/debug.php'); 
