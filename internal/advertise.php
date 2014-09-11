<?php
//exit;
//error_reporting(E_ALL);
ini_set('memory_limit', '200M');
$advertise_company_id = 'adv235';

require_once('../lib/config.php');
require_once($GLOBALS['CLASSES_DIR']."DBFactory.class.php");

require_once($GLOBALS['SMARTY_DIR']."Smarty.class.php");
#SMARTY
$smarty = new Smarty();
$smarty->template_dir = $GLOBALS['SMARTY_TEMPLATE_DIR'];
$smarty->compile_dir = $GLOBALS['SMARTY_COMPILE_DIR'];
$smarty->config_dir = $GLOBALS['SMARTY_CONFIG_DIR'];
$smarty->cache_dir = $GLOBALS['SMARTY_CACHE_DIR'];
$smarty->caching=false;

require_once($GLOBALS['MODULES_DIR'].'mailer/class.phpmailer.php');

$mail = new PHPMailer();

$mail->SetLanguage('en',$GLOBALS['MODULES_DIR']."mailer/language/");


$mail->IsSMTP();
$mail->CharSet = 'UTF-8';
$mail->ContentType ="text/html";

$mail->Host       = $GLOBALS['mailParams']['host']; // SMTP server example
$mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
$mail->SMTPAuth   = true;                  // enable SMTP authentication
$mail->Port       = $GLOBALS['mailParams']['port'];                    // set the SMTP port for the GMAIL server
$mail->Username   = $GLOBALS['mailParams']['username']; // SMTP account username example
$mail->Password   = $GLOBALS['mailParams']['password'];        // SMTP account password example

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
        'email'=>'vitaliy.grinchishin@gmail.com',
    ),

    "1"=>array(
        'login'=>'khalisy',
        'email'=>'khalisy@mail.ru',
    ),
);

//$users=SQLGetRows($query,$DBFactory->get_db_handle('forum'));


$mail_html_body = $smarty->fetch($GLOBALS['SMARTY_MODULES_DIR'].'mailer/advertise80.tpl');
//$mail_subj = $smarty->fetch(SMARTY_MODULES_DIR.'mailer/advertise_subject.tpl');
//echo $mail_html_body;

$cnt = 0;
foreach ($users as $key=>$user){
    if(search_email($advertise_company_id, $user['email'])) continue;
    $cnt ++;
    if($cnt > 5) exit;
    $sent = @unserialize(file_get_contents($GLOBALS['PROJECT_ROOT'].'/cache/portal/mail/sent_'.$advertise_company_id));
    if(!is_array($sent)) $sent = array();
    $sent[$user['email']] = $user['email'];
    file_put_contents($GLOBALS['PROJECT_ROOT'].'/cache/portal/mail/sent_'.$advertise_company_id, serialize($sent));

    echo $user['email']."<br/>";
    $mail->From = "admin@raks.com.ua";
    //$mail->message_type = 'alt_attachments';
    $mail->FromName = "RAKS.COM.UA - танец живота и индийский танец";


    $smarty->assign('user',$user);

    $mail->AddAddress($user['email'],$user['login']);

    $mail->Body = $mail_html_body;

    //echo $mail_html_body."<br/>";

    $err = '';

//examples:
    //$mail->AddAttachment(PROJECT_ROOT."/images/mailer/nefertiti/7_Festival.rar",'7_Festival.rar','base64','application/x-rar-compressed');
    //$mail->AddAttachment(PROJECT_ROOT."/images/mailer/sudak2013/01_bd_sudak_2013_programma_festivala.doc",'01_bd_sudak_2013_programma_festivala.doc','base64','application/msword');
    //$mail->AddAttachment(PROJECT_ROOT."/images/mailer/sudak2013/02_2013_turnir_pravila_samie_novie.doc",'02_2013_turnir_pravila_samie_novie.doc','base64','application/msword');
    //$mail->AddAttachment(PROJECT_ROOT."/images/mailer/sudak2013/03_bd_sudak_2013_dopolnenie_k_pologeniyu_o_festivale.doc",'03_bd_sudak_2013_dopolnenie_k_pologeniyu_o_festivale.doc','base64','application/msword');
    //$mail->AddAttachment(PROJECT_ROOT."/images/mailer/sudak2013/04_bd_sudak_2013_deti_spisok_kompoziciy_dlya_orkestra.doc",'04_bd_sudak_2013_deti_spisok_kompoziciy_dlya_orkestra.doc','base64','application/msword');
    //$mail->AddAttachment(PROJECT_ROOT."/images/mailer/sudak2013/05_bd_sudak_2013_spisok_kompoziciy_dlya_orkestra.doc",'05_bd_sudak_2013_spisok_kompoziciy_dlya_orkestra.doc','base64','application/msword');
    //$mail->AddAttachment($GLOBALS['PROJECT_ROOT']."/images/mailer/second/POLOZHENIE_festival.doc",'POLOZHENIE_festival.doc','base64','application/msword');
    //$mail->AddAttachment(PROJECT_ROOT."/images/mailer/oriental/Spisok_nominaciy_Oriental_Dance_2011.xls",'Spisok_nominaciy_Oriental_Dance_2011.xls','base64','application/vnd.ms-excel');
    //$mail->AddAttachment(PROJECT_ROOT."/images/mailer/AIDA.ppt",'AIDA.ppt','base64','application/vnd.ms-powerpoint');
    $mail->AddEmbeddedImage($GLOBALS['PROJECT_ROOT']."/images/mailer/afisha2/afisha.jpg",'afisha','afisha.jpg','base64','image/jpeg');
    //$mail->AddEmbeddedImage($GLOBALS['PROJECT_ROOT']."/images/mailer/second/novyy-3.jpg",'novyy3','novyy-3.jpg','base64','image/jpeg');
    //$mail->AddEmbeddedImage($GLOBALS['PROJECT_ROOT']."/images/mailer/second/novyy-11.jpg",'novyy11','novyy-11.jpg','base64','image/jpeg');
    //$mail->AddEmbeddedImage(PROJECT_ROOT."/images/mailer/det/logo200.gif",'logo','logo200.gif','base64','image/gif');

    //$mail->AddAttachment(PROJECT_ROOT."/images/mailer/karavan/Karavan_2013_polniy.doc",'Karavan_2013_polniy.doc','base64','application/msword');
    //$mail->AddAttachment(PROJECT_ROOT."/images/mailer/karavan/Kategorii_dlya_registracii2013.doc",'Kategorii_dlya_registracii2013.doc','base64','application/msword');


    if($mail->IsError())$err.="|".$mail->ErrorInfo;

    if($mail->IsError())$err.="|".$mail->ErrorInfo;
    //if($mail->IsError())$err.="|".$mail->ErrorInfo;
    $mail->Subject = 'Фестиваль восточного танца "Шамс Эль Маср"';

    if($mail->IsError())$err.="|".$mail->ErrorInfo;

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


function search_email($advertise_company_id, $email){
    $sent = @unserialize(file_get_contents($GLOBALS['PROJECT_ROOT'].'/cache/portal/mail/sent_'.$advertise_company_id));
    if(!is_array($sent)) return false;
    return isset($sent[$email]) ? true : false;
}


?>