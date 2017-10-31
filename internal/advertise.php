<?php
//exit;
//error_reporting(E_ALL);
ini_set('memory_limit', '500M');
//$advertise_company_id = 'adv541';

$advertise_company_id = 'adv596';
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
$mail->SMTPAuth   = false;                  // enable SMTP authentication
$mail->Port       = $GLOBALS['mailParams2']['port'];                    // set the SMTP port for the GMAIL server
//$mail->Username   = $GLOBALS['mailParams2']['username']; // SMTP account username example
//$mail->Password   = $GLOBALS['mailParams2']['password'];        // SMTP account password example

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

$users = getCampaignRows($advertise_company_id, 10,  $DBFactory->get_db_handle('rakscom'));


$mail_html_body = $smarty->fetch($GLOBALS['SMARTY_MODULES_DIR'].'mailer/advertise108.tpl');
//$mail_subj = $smarty->fetch(SMARTY_MODULES_DIR.'mailer/advertise_subject.tpl');

$cnt = 0;
foreach ($users as $key=>$user){
    $sent = @unserialize(file_get_contents($GLOBALS['PROJECT_ROOT'].'/cache/portal/mail/sent_'.$advertise_company_id));
    if(!is_array($sent)) $sent = array();
    $sent[$user['email']] = $user['email'];
    file_put_contents($GLOBALS['PROJECT_ROOT'].'/cache/portal/mail/sent_'.$advertise_company_id, serialize($sent));

    echo $user['email']."<br/>";
    $mail->From = "admin@marketing.raks.com.ua";
    //$mail->message_type = 'alt_attachments';
    $mail->FromName = "RAKS.COM.UA - танец живота и индийский танец";
    $mail->Sender  = "admin@marketing.raks.com.ua";
    $mail->addReplyTo("admin@marketing.raks.com.ua", "admin@marketing.raks.com.ua");

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
    //$mail->AddEmbeddedImage($GLOBALS['PROJECT_ROOT']."/images/mailer/zoloto/may2017.jpg",'may2017','may2017.jpg','base64','image/jpeg');
    //$mail->AddEmbeddedImage($GLOBALS['PROJECT_ROOT']."/images/mailer/zoloto/all_include.jpg",'all_include','all_include.jpg','base64','image/jpeg');
    //$mail->AddAttachment($GLOBALS['PROJECT_ROOT']."/images/mailer/nine/1.doc",'Polozhenie_konkursa_vostok_Ternopol_29-30.04.2017.doc','base64','application/msword');
    //$mail->AddAttachment($GLOBALS['PROJECT_ROOT']."/images/mailer/zoloto/pologenie.doc",'Положение.doc','base64','application/msword');
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
/*
    $mail->AddEmbeddedImage($GLOBALS['PROJECT_ROOT']."/images/mailer/gold_east/afisha2.gif",'img','afisha2.gif','base64','image/gif');
    $mail->AddAttachment($GLOBALS['PROJECT_ROOT']."/images/mailer/gold_east/pologenie.doc", 'Положение.doc', 'base64', 'application/msword');
    $mail->AddAttachment($GLOBALS['PROJECT_ROOT']."/images/mailer/gold_east/borisenko.gif", 'borisenko.gif', 'base64', 'image/gif');
    $mail->AddAttachment($GLOBALS['PROJECT_ROOT']."/images/mailer/gold_east/gold_kubok.gif", 'gold_kubok.gif', 'base64', 'image/gif');
    $mail->AddAttachment($GLOBALS['PROJECT_ROOT']."/images/mailer/gold_east/happy_days.gif", 'happy_days.gif', 'base64', 'image/gif');
    $mail->AddAttachment($GLOBALS['PROJECT_ROOT']."/images/mailer/gold_east/jakovuk.gif", 'jakovuk.gif', 'base64', 'image/gif');
    $mail->AddAttachment($GLOBALS['PROJECT_ROOT']."/images/mailer/gold_east/professionals.gif", 'professionals.gif', 'base64', 'image/gif');
    $mail->AddAttachment($GLOBALS['PROJECT_ROOT']."/images/mailer/gold_east/session.gif", 'session.gif', 'base64', 'image/gif');
    $mail->AddAttachment($GLOBALS['PROJECT_ROOT']."/images/mailer/gold_east/sovmestniy.gif", 'sovmestniy.gif', 'base64', 'image/gif');
    $mail->AddAttachment($GLOBALS['PROJECT_ROOT']."/images/mailer/gold_east/strebkova.gif", 'strebkova.gif', 'base64', 'image/gif');
    $mail->AddAttachment($GLOBALS['PROJECT_ROOT']."/images/mailer/gold_east/young_star.gif", 'young_star.gif', 'base64', 'image/gif');
*/
//
    //$mail->AddAttachment($GLOBALS['PROJECT_ROOT']."/images/mailer/orient2/reg.xls",'Регистрационная форма.xls','base64','application/vnd.ms-excel');


    //$mail->AddAttachment($GLOBALS['PROJECT_ROOT']."/images/mailer/express/Express.jpg", 'borisenko.gif', 'base64', 'image/gif');
/*
    $mail->AddAttachment($GLOBALS['PROJECT_ROOT']."/images/mailer/sud/pologenie.docx", 'ПОЛОЖЕНИЕ МАКТУБ-2017.docx', 'base64', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document');
    $mail->AddAttachment($GLOBALS['PROJECT_ROOT']."/images/mailer/sud/songs.docx", 'songs_Orchestra Saafa Farid.docx', 'base64', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document');
    $mail->AddEmbeddedImage($GLOBALS['PROJECT_ROOT']."/images/mailer/sud/logo.jpg",'logo','logo.jpg','base64','image/jpeg');
    $mail->AddEmbeddedImage($GLOBALS['PROJECT_ROOT']."/images/mailer/sud/who.jpg",'who','who.jpg','base64','image/jpeg');
    $mail->AddEmbeddedImage($GLOBALS['PROJECT_ROOT']."/images/mailer/sud/plan.jpg",'plan','plan.jpg','base64','image/jpeg');
*/

//    $mail->AddAttachment($GLOBALS['PROJECT_ROOT']."/images/mailer/faym/Polozhenie_festivalya_Osenniy_El-Fayum_2016_Obschee_33__33__33.doc",'положение.doc','base64','application/msword');
//    $mail->AddEmbeddedImage($GLOBALS['PROJECT_ROOT']."/images/mailer/super/Fetisova.jpg",'fetisova','Fetisova.jpg','base64','image/jpeg');

    //$mail->AddEmbeddedImage($GLOBALS['PROJECT_ROOT']."/images/mailer/kha/afisha_sudi-gr.jpg",'img','sudi.jpg','base64','image/jpeg');
    //$mail->AddEmbeddedImage($GLOBALS['PROJECT_ROOT']."/images/mailer/kha/afisha-mk.jpg",'img2','afisha.jpg','base64','image/jpeg');
    //$mail->AddEmbeddedImage($GLOBALS['PROJECT_ROOT']."/images/mailer/kha/arabic.jpg",'img3','arabic.jpg','base64','image/jpeg');
    //$mail->AddEmbeddedImage($GLOBALS['PROJECT_ROOT']."/images/mailer/junior/costumes.jpg",'logo','costumes.jpg','base64','image/jpeg');
//    $mail->AddAttachment($GLOBALS['PROJECT_ROOT']."/images/mailer/oriental2017/pologenie.pdf", 'Положение Запорожье (06ver10) Ориенталь 2-3 дек.pdf', 'base64', 'application/pdf.');
    $mail->AddEmbeddedImage($GLOBALS['PROJECT_ROOT']."/images/mailer/star/judges.jpg",'judges','judges.jpg','base64','image/jpeg');
    $mail->AddEmbeddedImage($GLOBALS['PROJECT_ROOT']."/images/mailer/star/mk.jpg",'mk','mk.jpg','base64','image/jpeg');
    $mail->AddEmbeddedImage($GLOBALS['PROJECT_ROOT']."/images/mailer/star/queen.jpg",'queen','queen.jpg','base64','image/jpeg');
    $mail->AddAttachment($GLOBALS['PROJECT_ROOT']."/images/mailer/star/pologenie.doc", 'Положение Звезда Востока 12.11.2017.doc', 'base64', 'application/msword');

    $mail->Subject = '11-12 ноября Кубок Восточной Украины "Звезда Востока"';
    //$mail->Subject = 'Фестиваль восточного танца "Шамс эль Маср" 1-2.10.16 Киев';

    $fileds = array(
        "a_time"=>time(),
        "a_type"=>$advertise_company_id,
        "a_value"=>$user['email'],
    );
 try{

    if(preg_match('/rambler\.ru/i', $user['email'])){
        $mail->Send();
    }else{
     $verify = verifyEmail($user['email'], "admin@marketing.raks.com.ua", true);
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
    $query = "
	    SELECT email
	    FROM mail
	    WHERE status <> 'sent' AND (campaign = 'adv541' )
    ";

    $rows = SQLGetRows($query, $dbh);

    $banned = array();
    if(count($rows) > 0) {
        foreach ($rows as $row) {
            $banned[$row['email']] = $row['email'];
        }
    }

    foreach($users as $user){
        if(isset($banned[$user['email']])) continue;
        if(preg_match("/\.\@/i",  $user['email'])) continue;

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
