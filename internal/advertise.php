<?php
//exit;
//error_reporting(E_ALL);
ini_set('memory_limit', '500M');
$advertise_company_id = 'adv510';
require_once('verifyEmail.php');
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

$mail = new PHPMailer(true);

$mail->SetLanguage('en',$GLOBALS['MODULES_DIR']."mailer/language/");


$mail->IsSMTP();
$mail->CharSet = 'UTF-8';
$mail->ContentType ="text/html";

$mail->Host       = $GLOBALS['mailParams2']['host']; // SMTP server example
$mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
$mail->SMTPAuth   = true;                  // enable SMTP authentication
$mail->Port       = $GLOBALS['mailParams2']['port'];                    // set the SMTP port for the GMAIL server
$mail->Username   = $GLOBALS['mailParams2']['username']; // SMTP account username example
$mail->Password   = $GLOBALS['mailParams2']['password'];        // SMTP account password example

//$mail->ContentType ="multipart/mixed";


$DBFactory = new DBFactory();

$DBFactory->add_db_handle("rakscom",$db_params['rakscom']['server'],$db_params['rakscom']['database'],
    $db_params['rakscom']['user'],$db_params['rakscom']['password']);

$DBFactory->add_db_handle("forum",$db_params['forum']['server'],$db_params['forum']['database'],
    $db_params['forum']['user'],$db_params['forum']['password']);


$query = "
	SELECT *,user_email as email,username as login
	FROM phpbb_users
	WHERE user_email <> ''

";

//        WHERE user_regdate > ".strtotime('-2 year')." AND user_email NOT LIKE '%@i.ua' AND user_email NOT LIKE '%@mail.ru' AND  user_email NOT LIKE '%inbox.ru' AND  user_email NOT LIKE '%bigmir.net' AND  user_email NOT LIKE '%@bk.ru' AND  user_email NOT LIKE '%@mail.ua'

//        WHERE user_email NOT LIKE '%ukr.net' AND user_email NOT LIKE '%ua.fm' AND user_email NOT LIKE '%mail.ru' AND  user_email NOT LIKE '%inbox.ru'

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

//$users=SQLGetRows($query, $DBFactory->get_db_handle('forum'));

$isStarted = isCampaignStarted($advertise_company_id, $DBFactory->get_db_handle('rakscom'));
if(!$isStarted){
    fillCampaign($advertise_company_id, $users, $DBFactory->get_db_handle('rakscom'));
    add_to_log("[action filling campaign][campaign $advertise_company_id]", 'mailer');
    exit;
}

$users = getCampaignRows($advertise_company_id, 5,  $DBFactory->get_db_handle('rakscom'));

$mail_html_body = $smarty->fetch($GLOBALS['SMARTY_MODULES_DIR'].'mailer/advertise90.tpl');
//$mail_subj = $smarty->fetch(SMARTY_MODULES_DIR.'mailer/advertise_subject.tpl');
//echo $mail_html_body;

$cnt = 0;
foreach ($users as $key=>$user){
    $sent = @unserialize(file_get_contents($GLOBALS['PROJECT_ROOT'].'/cache/portal/mail/sent_'.$advertise_company_id));
    if(!is_array($sent)) $sent = array();
    $sent[$user['email']] = $user['email'];
    file_put_contents($GLOBALS['PROJECT_ROOT'].'/cache/portal/mail/sent_'.$advertise_company_id, serialize($sent));

    echo $user['email']."<br/>";
    $mail->From = "admin@raks.com.ua";
    //$mail->message_type = 'alt_attachments';
    $mail->FromName = "RAKS.COM.UA - танец живота и индийский танец";
    $mail->Sender  = "admin@raks.com.ua";
    $mail->addReplyTo("admin@raks.com.ua", "admin@raks.com.ua");

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
    //$mail->AddEmbeddedImage($GLOBALS['PROJECT_ROOT']."/images/mailer/queen/queen.jpg",'queen','queen.jpg','base64','image/jpeg');
    //$mail->AddAttachment($GLOBALS['PROJECT_ROOT']."/images/mailer/vostok2/invitation.doc",'приглашение.doc','base64','application/msword');
    //$mail->AddAttachment($GLOBALS['PROJECT_ROOT']."/images/mailer/superdance2015/Zayavka-Odessa.doc",'Zayavka-Odessa.doc','base64','application/msword');
    //$mail->AddAttachment($GLOBALS['PROJECT_ROOT']."/images/mailer/superdance2015/Polozhenie-Pervenstvo-2015.doc",'Polozhenie-Pervenstvo-2015.doc','base64','application/msword');
    //$mail->AddAttachment(PROJECT_ROOT."/images/mailer/sudak2013/05_bd_sudak_2013_spisok_kompoziciy_dlya_orkestra.doc",'05_bd_sudak_2013_spisok_kompoziciy_dlya_orkestra.doc','base64','application/msword');
    //$mail->AddAttachment($GLOBALS['PROJECT_ROOT']."/images/mailer/second/POLOZHENIE_festival.doc",'POLOZHENIE_festival.doc','base64','application/msword');
    //$mail->AddAttachment(PROJECT_ROOT."/images/mailer/oriental/Spisok_nominaciy_Oriental_Dance_2011.xls",'Spisok_nominaciy_Oriental_Dance_2011.xls','base64','application/vnd.ms-excel');
    //$mail->AddAttachment(PROJECT_ROOT."/images/mailer/AIDA.ppt",'AIDA.ppt','base64','application/vnd.ms-powerpoint');
    //$mail->AddEmbeddedImage($GLOBALS['PROJECT_ROOT']."/images/mailer/ternopil/plakat.jpg","plakat", 'plakat.jpg','base64','image/jpeg');

    //$mail->AddEmbeddedImage($GLOBALS['PROJECT_ROOT']."/images/mailer/superdance2015/unnamed.png",'unnamed','unnamed.png','base64','image/png');
    //$mail->AddEmbeddedImage($GLOBALS['PROJECT_ROOT']."/images/mailer/superdance2015/unnamed2.jpg",'unnamed2','unnamed2.jpg','base64','image/jpeg');
    //$mail->AddEmbeddedImage($GLOBALS['PROJECT_ROOT']."/images/mailer/superdance2015/unnamed3.jpg",'unnamed3','unnamed3.jpg','base64','image/jpeg');
    //$mail->AddEmbeddedImage($GLOBALS['PROJECT_ROOT']."/images/mailer/second/novyy-11.jpg",'novyy11','novyy-11.jpg','base64','image/jpeg');
    //$mail->AddEmbeddedImage(PROJECT_ROOT."/images/mailer/det/logo200.gif",'logo','logo200.gif','base64','image/gif');

    $mail->AddAttachment($GLOBALS['PROJECT_ROOT']."/images/mailer/orient2/plogenie.doc", 'Положение на 14-15 мая.doc', 'base64', 'application/msword');
    $mail->AddAttachment($GLOBALS['PROJECT_ROOT']."/images/mailer/orient2/reg.xls",'Регистрационная форма.xls','base64','application/vnd.ms-excel');
    $mail->AddEmbeddedImage($GLOBALS['PROJECT_ROOT']."/images/mailer/orient2/img.jpg",'img','img.jpg','base64','image/jpeg');
    //$mail->AddAttachment($GLOBALS['PROJECT_ROOT']."/images/mailer/ternopil/Polozhenie_konkursa_vostok_Ternopol_19-20_12_2015.doc",'Polozhenie_konkursa_vostok_Ternopol_19-20_12_2015.doc','base64','application/msword');


    $mail->Subject = 'Oriental dance - FESTIVAL 2016';

    $fileds = array(
        "a_time"=>time(),
        "a_type"=>$advertise_company_id,
        "a_value"=>$user['email'],
    );
 try{

    if(preg_match('/rambler\.ru/i', $user['email'])){
        $mail->Send();
    }else{
     $verify = verifyEmail($user['email'], "admin@raks.com.ua", true);
     if($verify[0] == 'valid') {
         $mail->Send();
     }else{
        throw new \Exception($verify[1]);
     }
    }

} catch (phpmailerException $e) {
     $err .= $e->errorMessage(); //Pretty error messages from PHPMailer
} catch (\Exception $e) {
     $err .= $e->getMessage(); //Boring error messages from anything else!
}

    //SQLInsert("advertise",$fileds,$DBFactory->get_db_handle('rakscom'));

    add_to_log("[email {$user['email']}][login {$user['login']}][err $err]",'mailer');

    if(!empty($err)){
        setCampaignFailed($user['id'], $err, $DBFactory->get_db_handle('rakscom'));
    }else{
        setCampaignSent($user['id'], $DBFactory->get_db_handle('rakscom'));
    }
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


function fillCampaign($campaign, $users, $dbh)
{
    foreach($users as $user){
        $fields = array(
            'campaign'  => $campaign,
            'email'     => $user['email'],
            'login'     => $user['login'],
            'status'    => 'new',
        );

        SQLInsert('mail', $fields, $dbh);
    }
}


function isCampaignStarted($campaign, $dbh)
{
    $q = 'SELECT COUNT(*) as cnt FROM mail WHERE campaign = '.SQLQuote($campaign);
    $res = SQLGet($q, $dbh);
    return isset($res['cnt']) ? $res['cnt'] > 0: false;
}

function getCampaignRows($campaign, $cnt, $dbh)
{
    $q = 'SELECT * FROM mail WHERE campaign = '.SQLQuote($campaign). ' AND `status` = "new" LIMIT '.$cnt;
    return SQLGetRows($q, $dbh);
}

function setCampaignSent($id, $dbh)
{
    $fields = array(
        'status' => 'sent'
    );
    SQLUpdate('mail', $fields, "WHERE id =".SQLQuote($id), $dbh);
}

function setCampaignFailed($id, $message, $dbh)
{
    $fields = array(
        'status'    => 'failed',
        'data'      => json_encode($message),
    );
    SQLUpdate('mail', $fields, "WHERE id =".SQLQuote($id), $dbh);
}
