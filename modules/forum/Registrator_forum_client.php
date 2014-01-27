<?php

if(!isset($_REQUEST['pass']) || $_REQUEST['pass'] != '435hjhdgdfl3'){
    exit;
}


$params = array(
    'user_data'=>array(
	"username"=>$_REQUEST['username'],
	"password"=>$_REQUEST['password'],
	"user_email"=>$_REQUEST['user_email'],
    ),
);

require_once('Registrator_forum_client.class.php');
$Registrator = new Registrator_forum_client();

echo $Registrator->register($params);



?>