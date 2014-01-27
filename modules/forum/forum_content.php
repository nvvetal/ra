<?php
$module_name = "forum";
require_once("../../lib/config.php");


$DBFactory->add_db_handle("forum",$db_params['forum']['server'],$db_params['forum']['database'],
    $db_params['forum']['user'],$db_params['forum']['password']);
    
require_once('forum_parser.class.php');

$forumParser = new forum_parser($DBFactory->get_db_handle('forum'));


$smarty->assign('forumParser',$forumParser);


$smarty->display("modules/$module_name/last_messages.tpl");                                                                                      
                                                                                                                                           
require_once($GLOBALS['LIB_ROOT'].'/debug.php'); 

?>