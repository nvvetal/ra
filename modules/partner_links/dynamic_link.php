<?php

require_once('config.php');



#Include

require_once("lib_partner_links.php");

#logic
require_once($GLOBALS['LIB_ROOT']."/bwls.php");

#user
require_once($GLOBALS['LIB_ROOT']."/lib_auth.php");
require_once($GLOBALS['CLASSES_DIR']."User.class.php");
require_once($GLOBALS['CLASSES_DIR']."Session.class.php");

require_once($GLOBALS['CLASSES_DIR']."Geo.class.php");

require_once('partner_links.class.php');


$go = 'external_link';

$s = isset($_REQUEST['s']) ? $_REQUEST['s'] : '';

sess_auth(&$s,&$Session);

user_auth(&$s,&$User,&$Session);


$partner_links = new partner_links($DBFactory->get_db_handle('rakscom'));


$params['partner_links'] = &$partner_links;
$params['Validator'] = $Validator;
$params['User'] = &$User;
$params['Session'] = &$Session;
$params['smarty'] = &$smarty;
$params['modules'] = $modules;
$params['s'] = $s;
$params['DBFactory'] = &$DBFactory;
$params['Images'] = &$Images;



$smarty->assign('s',$s);
$smarty->assign('partner_links',$partner_links);
$smarty->assign('Session',&$Session);
$smarty->assign('User',&$User);
$smarty->assign('Images',&$Images);

$smarty->assign('user_id',$Session->get_value($s,'user_id'));

$content = $smarty->fetch("modules/$module_name/".$go.'.tpl');

$link_id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;

$link = $partner_links->get_link($link_id);

if($link !== false){
    echo iconv('UTF-8',$link['external_codepage'],$content);
}

//require_once(LIB_ROOT.'/debug.php');


?>