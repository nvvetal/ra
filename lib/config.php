<?php

error_reporting(E_ALL);
session_start();
ini_set('magic_quotes_runtime', 0);
ini_set( 'magic_quotes_gpc', 0 );
ini_set('post_max_size', '10M');
ini_set('upload_max_filesize', '10M');

$GLOBALS['LIB_ROOT'] =  dirname(__FILE__);
$project_root = dirname(dirname(__FILE__));
$GLOBALS['PROJECT_ROOT'] = $project_root;


if (substr(PHP_OS, 0, 3)=='WIN'){
    ini_set( "include_path", "./;".$GLOBALS['PROJECT_ROOT']."/;".$GLOBALS['PROJECT_ROOT']."/lib/" );}
else{
    ini_set( "include_path", "./:".$GLOBALS['PROJECT_ROOT']."/:".$GLOBALS['PROJECT_ROOT']."/lib/" );}



#CORE DIRS

$GLOBALS['CLASSES_DIR'] = $GLOBALS['PROJECT_ROOT']."/Classes/";                                                                                           
$GLOBALS['MODULES_DIR'] = $GLOBALS['PROJECT_ROOT']."/modules/";                                                                                                                                            
                                                                                                                                           
$GLOBALS['TEMPLATES_DIR'] = $GLOBALS['PROJECT_ROOT'].'/templates/';                                                                                       
$GLOBALS['BLOCKS_DIR'] = $GLOBALS['PROJECT_ROOT'].'/blocks/';                                                                                             
$GLOBALS['LANGUAGES_DIR'] = $GLOBALS['PROJECT_ROOT'].'/languages/';                                                                                       
                                                                                                                                           
                                                                                                                                           
$GLOBALS['UPLOAD_DIR'] = $GLOBALS['PROJECT_ROOT'].'/uploads/';                                                                                            
$GLOBALS['BACKUP_DIR'] = $GLOBALS['PROJECT_ROOT'].'/backups/';  
                                                                                        
$GLOBALS['LOG_DIR'] = $GLOBALS['PROJECT_ROOT'].'/log/';                                                                                                   
$GLOBALS['TMP_DIR'] = $GLOBALS['PROJECT_ROOT'].'/tmp/';                                                                                                   
                                                                                                  

#SMARTY

$GLOBALS['DEFAULT_TEMPLATE_NAME'] = 'simple';

$GLOBALS['SMARTY_DIR'] =  $GLOBALS['PROJECT_ROOT']."/Smarty/";                                                                                             

$GLOBALS['SMARTY_TEMPLATE_DIR'] = $GLOBALS['PROJECT_ROOT'].'/templates/'.$GLOBALS['DEFAULT_TEMPLATE_NAME'].'/';
$GLOBALS['SMARTY_COMPILE_DIR'] = $GLOBALS['PROJECT_ROOT'].'/templates_c/';
$GLOBALS['SMARTY_CONFIG_DIR'] = $GLOBALS['PROJECT_ROOT'].'/templates/'.$GLOBALS['DEFAULT_TEMPLATE_NAME'].'/configs/';
$GLOBALS['SMARTY_CACHE_DIR'] = $GLOBALS['PROJECT_ROOT'].'/templates/cache/';

                                                                                                                                           
$GLOBALS['SMARTY_MODULES_DIR'] = $GLOBALS['SMARTY_TEMPLATE_DIR']."modules/";



#IMAGES                                                                                                                                           
                                                                                                                                           
$GLOBALS['IMAGE_UPLOAD_ORIGINAL_PATH'] = $GLOBALS['PROJECT_ROOT'].'/img_store/portal/';                                                                       
$GLOBALS['PHOTO_UPLOAD_ORIGINAL_PATH'] = $GLOBALS['PROJECT_ROOT'].'/img_store/photo/';                                                                       
$GLOBALS['IMAGE_CACHE_PATH'] = $GLOBALS['PROJECT_ROOT'].'/cache/portal/images/';                                                                           
$GLOBALS['IMAGE_FORUM_AVATAR_PATH'] = $GLOBALS['PROJECT_ROOT'].'/images/forum/avatars/';
$GLOBALS['IMAGEMAGICK_PATH'] = '/usr/local/bin/';
$GLOBALS['MAX_UPLOAD_IMAGE_SIZE'] = 5120000;

$GLOBALS['I18N_CACHE_PATH'] = $GLOBALS['PROJECT_ROOT'].'/cache/portal/i18n/'; 

$image_rules = array(                                                                                                                      
  "upload"=>array(                                                                                                                   
    'size'=>$GLOBALS['MAX_UPLOAD_IMAGE_SIZE'],                                                                                                            
    'img_types'=>array(                                                                                                        
      'image/gif'=>'image/gif',                                                                                          
      'image/jpeg'=>'image/jpeg',                                                                                        
      'image/png'=>'image/png',                                                                                        
      'application/octet-stream'=>'application/octet-stream',
    ),                                                                                                                         
  ),                                                                                                                                 
);                                                                                                                                         


                                                                                              

#DB
$db_params['rakscom'] = array(                                                                                                             
        "server"=>'localhost',                                                                                                             
        "database"=>'rakscom',                                                                                                             
        "user"=>'root',                                                                                                                    
        "password"=>'',                                                                                                                    
);

#MODULES
$modules = array(
	'forum'=>array(
		'path'=>$GLOBALS['MODULES_DIR'].'forum/',
	),
);


#HTTP PATHS
$GLOBALS['HTTP_PROJECT_ROOT'] = 'localhost';
$GLOBALS['HTTP_IMAGES_PATH'] = $GLOBALS['HTTP_PROJECT_ROOT']."i/";

#DEBUG

$GLOBALS['DEBUG'] = 0;

if($_SERVER['HTTP_HOST'] == 'rakscom:8080') $_SERVER['HTTP_HOST'] = 'rakscom';
$SERVER_HOST = $_SERVER['HTTP_HOST'];
//echo $GLOBALS['LIB_ROOT'].'/config/'.$SERVER_HOST.'.php';

$GLOBALS['INCLUDED_HOST_CONFIG'] = $GLOBALS['LIB_ROOT'].'/config/'.$SERVER_HOST.'.php';
//echo $GLOBALS['INCLUDED_HOST_CONFIG'];



$is_host_config_included = -1; 
if(file_exists($GLOBALS['INCLUDED_HOST_CONFIG'])){
    require_once($GLOBALS['INCLUDED_HOST_CONFIG']);
    $is_host_config_included = 1;
}else{
    $is_host_config_included = 0;
}

$GLOBALS['XAJAX_PATH'] = $GLOBALS['LIB_ROOT'].'/xajax/'; 
$GLOBALS['XAJAX_JS_PATH'] = $GLOBALS['HTTP_PROJECT_ROOT'].'/xajax/'; 

$GLOBALS['HTTP_PROJECT_PATH'] = $GLOBALS['HTTP_PROJECT_ROOT'];
$GLOBALS['HTTP_FORUM_IMAGES_PATH'] = $GLOBALS['HTTP_PROJECT_ROOT']."forum/images/";

#Misc
require_once("misc.php");
set_error_handler("error_handler");

if($is_host_config_included == 0){
    add_to_log("[warn Host config '{$GLOBALS['INCLUDED_HOST_CONFIG']}' is not included!]",'warning');
}

#SQL
require_once("mysql.php");


#SMARTY
require_once($GLOBALS['SMARTY_DIR']."Smarty.class.php");
$smarty = new Smarty();
$smarty->template_dir = $GLOBALS['SMARTY_TEMPLATE_DIR'];
$smarty->compile_dir = $GLOBALS['SMARTY_COMPILE_DIR'];
$smarty->config_dir = $GLOBALS['SMARTY_CONFIG_DIR'];
$smarty->cache_dir = $GLOBALS['SMARTY_CACHE_DIR'];
$smarty->caching=false;
$smarty->assign("http_images_path",$GLOBALS['HTTP_IMAGES_PATH']);
$smarty->assign("http_css_path",$GLOBALS['HTTP_PROJECT_ROOT'].'css/');
$smarty->assign("http_images_static_path",$GLOBALS['HTTP_PROJECT_ROOT'].'images/');
$smarty->assign("http_project_path",$GLOBALS['HTTP_PROJECT_ROOT']);
$smarty->assign("MAX_UPLOAD_IMAGE_SIZE",$GLOBALS['MAX_UPLOAD_IMAGE_SIZE']);
$smarty->assign("MAX_UPLOAD_IMAGE_SIZE_READ_KB",$GLOBALS['MAX_UPLOAD_IMAGE_SIZE']/1024);
$smarty->assign("MAX_UPLOAD_IMAGE_SIZE_READ_MB",round($GLOBALS['MAX_UPLOAD_IMAGE_SIZE']/1024/1024,0));




if(!empty($module_name)){
	$smarty->assign("use_module_css",1);
	$smarty->assign("module_name",$module_name);
    $smarty->assign("http_module_path",$GLOBALS['HTTP_PROJECT_PATH'].$module_name.'/'); 
    $GLOBALS['SMARTY_MODULE_DIR'] = $GLOBALS['SMARTY_MODULES_DIR'].$module_name.'/'; 
                                                                
}else{
    $smarty->assign("use_module_css",0);
}



require_once($GLOBALS['CLASSES_DIR']."ClassLoader.class.php");
require_once('Zend/Loader.php');

#logic
require_once($GLOBALS['LIB_ROOT']."/bwls.php");

#user
require_once($GLOBALS['LIB_ROOT']."/lib_auth.php");

$ClassLoader = new ClassLoader();    
$smarty->assign("ClassLoader",$ClassLoader);
spl_autoload_register(array($ClassLoader, 'autoLoad'));
if(!empty($module_name)){
    Registry::set('module', $module_name);
}
$DBFactory = new DBFactory();
Registry::set('DBFactory', $DBFactory);
Registry::set('db_params', $db_params);
Registry::set('templator', $smarty);


$DBFactory->add_db_handle("rakscom",$db_params['rakscom']['server'],$db_params['rakscom']['database'],
    $db_params['rakscom']['user'],$db_params['rakscom']['password']);

$Config = new Config('config', $DBFactory->get_db_handle("rakscom"));
Registry::set('Config', $Config);
$smarty->assign("Config", $Config);
$smarty->assign("captcha", $GLOBALS['CAPTCHA']);

//$raks = new Raks($DBFactory->get_db_handle("rakscom"));

#EMAIL
$GLOBALS['NEED_ACTIVATION_TO_REGISTER'] = ($Config->get_param('register_activation') == 1) ? true : false; 

$Validator = new Validator();
$User = new User($DBFactory->get_db_handle("rakscom"));
Registry::set('User', $User);
$Session = new Session($DBFactory->get_db_handle("rakscom"));
$Images = new Images($DBFactory->get_db_handle('rakscom'),$GLOBALS['IMAGEMAGICK_PATH'], $image_rules);

$i18n = new i18n($GLOBALS['I18N_CACHE_PATH'],$DBFactory->get_db_handle("rakscom"));
if(!empty($module_name)){
    $i18n->set_module($module_name);
}

Registry::set('i18n', $i18n);
$lang = 'ru';
Registry::set('lang', $lang);
Registry::set('Images', $Images);
Registry::set('Session', $Session);

$Utils = new Utils();
$smarty->assign("Utils", $Utils);

$paymentConfig = array(
    'paymentPrices' =>  array(
        'UAH' => array(
            5   => 70,
            9   => 150,
            30  => 500,
        ),
    ),
    'payments'=>array(
        'liqpay'=> array(
            'result_url'            => $GLOBALS['HTTP_PROJECT_ROOT'].'?go=payment_result',
            'server_url'            => $GLOBALS['HTTP_PROJECT_ROOT'].'payment/processLiqpay.php',
            'merchant_id'           => 'i8430442379',
            'merchant_signature'    => 'awvOT6F7MyHouf4uyRwgM00fOcjJ',
            'version'               => '1.2',
        ),
    ),
);


$Payment = new Payment($paymentConfig,$DBFactory->get_db_handle("rakscom"));
$smarty->assign("Payment",$Payment);
Registry::set('Payment',$Payment);
$PhotosAuth = array('login' => 'vitaliy.grinchishin@gmail.com', 'password' => '5kw2ohzi', 'user_id' => '115980522578926623880');
Registry::set('PhotosAuth', $PhotosAuth);
$GiftMaxNewPeriod = 600;
Registry::set('GiftMaxNewPeriod', $GiftMaxNewPeriod);
$userId = isset($_REQUEST['s']) && $Session->get_value($_REQUEST['s'], 'user_id') ? $Session->get_value($_REQUEST['s'], 'user_id') : '';
if(!empty($userId)){
    $dir = $GLOBALS['PROJECT_ROOT']."/users/" . $userId . "/images/upload";
    if(!is_dir($dir)) mkdir($dir, 0755, true);
    $_SESSION['KCFINDER'] = array();
    $_SESSION['KCFINDER']['disabled'] = false;
    $_SESSION['KCFINDER']['uploadURL'] = "/users/" . $userId . "/images/upload";
    $_SESSION['KCFINDER']['uploadDir'] = "";
}

/**
 * @var $mailer Mail
 */
$mailer = new Mail($GLOBALS['mailParams']);
Registry::set('mailer', $mailer);
