<?php
require_once('admin.common.php');

$go = bwls($go,$action,$params);


$smarty->display("modules/$module_name/".$go.'.tpl');

require_once($GLOBALS['LIB_ROOT'].'/debug.php'); 

?>