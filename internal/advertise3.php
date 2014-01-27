<?php
//error_reporting(E_ALL);
ini_set('memory_limit', '100M');
$advertise_company_id = 'adv38';

require_once('../lib/config.php');
require_once(CLASSES_DIR."DBFactory.class.php");

require_once(SMARTY_DIR."Smarty.class.php");
#SMARTY
$smarty = new Smarty();
$smarty->template_dir = SMARTY_TEMPLATE_DIR;
$smarty->compile_dir = SMARTY_COMPILE_DIR;
$smarty->config_dir = SMARTY_CONFIG_DIR;
$smarty->cache_dir = SMARTY_CACHE_DIR;
$smarty->caching=false;

require_once(MODULES_DIR.'mailer/class.phpmailer.php');

$mail = new PHPMailer();

$mail->SetLanguage('en',MODULES_DIR."mailer/language/");


$mail->IsMail();
$mail->CharSet = 'UTF-8';
$mail->ContentType ="text/html";
//$mail->ContentType ="multipart/mixed";


$DBFactory = new DBFactory();

$DBFactory->add_db_handle("rakscom",$db_params['rakscom']['server'],$db_params['rakscom']['database'],
    $db_params['rakscom']['user'],$db_params['rakscom']['password']);
    
$DBFactory->add_db_handle("forum",$db_params['forum']['server'],$db_params['forum']['database'],
    $db_params['forum']['user'],$db_params['forum']['password']);
        

$query = "
	SELECT *
	FROM advertise
	WHERE a_type = '$advertise_company_id'
";   

$ausers=SQLGetRows($query,$DBFactory->get_db_handle('rakscom'));

$WHERE = '';
if(count($ausers)>0){
	
	foreach ($ausers as $key=>$auser){
		$WHERE .= SQLQuote($auser['a_value']).",";
	}
	
	$WHERE = "WHERE user_email NOT IN (".substr($WHERE,0,strlen($WHERE)-1).")";
	
}
/*
$query = "
	SELECT *,user_email as email,username as login
	FROM phpbb_users
	$WHERE
	LIMIT 10
"; 
*/

$query = "
	SELECT *,user_email as email,username as login
	FROM phpbb_users
"; 


$users = array(
	"0"=>array(
		'login'=>'nvvetal',
		'email'=>'nv-vetal@rambler.ru',
	),

	"1"=>array(
		'login'=>'khalisy',
		'email'=>'khalisy@mail.ru',
	),	
	"2"=>array(
		'login'=>'nvvetal2',
		'email'=>'nvvetal@jumbuck.com.ua',
	),
	"3"=>array(
		'login'=>'nvveta3',
		'email'=>'nvvetal@ukr.net',
	),
	

);

$users=SQLGetRows($query,$DBFactory->get_db_handle('forum'));


$mail_html_body = $smarty->fetch(SMARTY_MODULES_DIR.'mailer/advertise23.tpl');
//$mail_subj = $smarty->fetch(SMARTY_MODULES_DIR.'mailer/advertise_subject.tpl');
//echo $mail_html_body;

$cnt = 0;
foreach ($users as $key=>$user){
	if(search_email($ausers,$user['email']))continue;
	$cnt ++;
	if($cnt > 5) exit;
    echo $user['email']."<br/>";
	$mail->From = "admin@raks.com.ua";
	//$mail->message_type = 'alt_attachments';
	$mail->FromName = "RAKS.COM.UA - танец живота и индийский танец";
	

	$smarty->assign('user',$user);

	$mail->AddAddress($user['email'],$user['login']);

	$mail->Body = $mail_html_body;

	//echo $mail_html_body."<br/>";
	
	$err = '';	

//	$mail->AddAttachment(PROJECT_ROOT."/images/mailer/International_Championship.doc",'International_Championship.doc','base64','application/msword');

	if($mail->IsError())$err.="|".$mail->ErrorInfo;	
	
/*
	$mail->AddAttachment(PROJECT_ROOT."/images/mailer/AIDA.ppt",'AIDA.ppt','base64','application/vnd.ms-powerpoint');
*/
	if($mail->IsError())$err.="|".$mail->ErrorInfo;	
	//if($mail->IsError())$err.="|".$mail->ErrorInfo;	
	$mail->Subject = "VI Фестиваль ориентального танца «Украина Восточная-2011»";

//	$mail->AddEmbeddedImage(PROJECT_ROOT."/images/mailer/plakat_OV_small.jpg",'plakat_OV_small','plakat_OV_small.jpg','base64','image/jpeg');
/*
	$mail->AddEmbeddedImage(PROJECT_ROOT."/images/mailer/sahhara_miss_bellydance_A3_05.jpg",'sahhara','sahhara_miss_bellydance_A3_05.jpg','base64','image/jpeg');
	$mail->AddEmbeddedImage(PROJECT_ROOT."/images/mailer/vip_2010_2.jpg",'vip','vip_2010_2.jpg','base64','image/jpeg');
*/
	if($mail->IsError())$err.="|".$mail->ErrorInfo;

	/*
	$mail->AddEmbeddedImage(PROJECT_ROOT."/images/mailer/elf/elf.jpg",'elf','elf.jpg','base64','image/jpeg');
	$mail->AddAttachment(PROJECT_ROOT."/images/mailer/elf/Master_class.docx",'Master_class.docx','base64','application/msword');
	$mail->AddAttachment(PROJECT_ROOT."/images/mailer/elf/Pologenie.doc",'Pologenie.doc','base64','application/msword');
	*/
	if($mail->IsError())$err.="|".$mail->ErrorInfo;	
	
	$fileds = array(
		"a_time"=>time(),
		"a_type"=>$advertise_company_id,
		"a_value"=>$user['email'],
	);
	if(!$mail->Send()){
		$err = "|".$mail->ErrorInfo;
		
		
	}

	SQLInsert("advertise",$fileds,$DBFactory->get_db_handle('rakscom'));

	add_to_log("[email {$user['email']}][login {$user['login']}][err $err]",'mailer');
	
    // Clear all addresses and attachments for next loop
    $mail->ClearAddresses();
    $mail->ClearAttachments();

	//exit;
}


function search_email($ausers,$email){
	$is_found = false;
	if(count($ausers)>0){

		foreach ($ausers as $key=>$auser){
			if($auser['a_value'] == $email) {
				echo $auser['a_value']."- $email <br/>";
				return true;
			}
		}


	}

	return $is_found;

}


?>