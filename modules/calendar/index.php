<?php

require_once('calendar.common.php');

sess_auth($s, $Session);                                                                                                                  
                                                                                                                                           
user_auth($s, $User, $Session);

$go = bwls($go, $action, $params);                                                                                                      
                                                                                                                                           
$go = calendar_actions($go, $action, $params); 



$smarty->display("modules/$module_name/".$go.'.tpl');                                                                                      
                                                                                                                                           
require_once($GLOBALS['LIB_ROOT'].'/debug.php'); 

?>