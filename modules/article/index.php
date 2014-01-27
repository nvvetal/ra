<?php

require_once('article.common.php');

sess_auth($s, $Session);

user_auth($s, $User, $Session);

$go = bwls($go, $action, $params);

$params = array(
    'templator'        => &$smarty,
    'templatesPath'    => "modules/$module_name/",
);
require_once($GLOBALS["CLASSES_DIR"].'ActionProcessor.class.php');
$actionProcessor = new ActionProcessor($module_name, $params);
$actionProcessor->setGoName('go');
$actionProcessor->showContent();
require_once($GLOBALS['LIB_ROOT'].'/debug.php');

?>