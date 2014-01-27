<?php

require_once('config.php');

require_once("blog_firm_bl.php");

require_once("blog_firm.class.php");
require_once("blog_firm_container.class.php");

$blog_firm_class = new blog_firm( $DBFactory->get_db_handle("rakscom") );

$container_class = new blog_firm_container(&$Validator,&$blog_firm_class);
//print_r($container_class);

$go = (!empty($_REQUEST["go"])) ? $_REQUEST["go"] : 'index';

$go = blog_firm_bl ( $go, $container_class, $smarty );

$smarty->display($GLOBALS['SMARTY_MODULE_DIR'].$go.".tpl");

?>