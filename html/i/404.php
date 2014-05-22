<?php
//exit;
set_time_limit(2);

$src = @$_SERVER['REQUEST_URI'];
//var_dump($_SERVER);
if( $src == '' ) exit;

require_once("../../lib/config.php");
// i/560/3b4f6b1720e106927523/9_100_100.jpg


#Images                                                                                                                                    
require_once($GLOBALS['CLASSES_DIR']."Images.class.php"); 
#DBFactory
require_once($GLOBALS['CLASSES_DIR']."DBFactory.class.php"); 


$DBFactory = new DBFactory();                                                                                                              
                                                                                                                                           
$DBFactory->add_db_handle("rakscom",$db_params['rakscom']['server'],$db_params['rakscom']['database'],                                     
    $db_params['rakscom']['user'],$db_params['rakscom']['password']); 

$Images = new Images($DBFactory->get_db_handle('rakscom'),$GLOBALS['IMAGEMAGICK_PATH'],$image_rules); 

if(preg_match("/attachment\/real\/(\d+)\.(\w{3})$/", $src, $match)){
    $dbhRaks = $DBFactory->get_db_handle('rakscom');
    require_once($GLOBALS['CLASSES_DIR']."/Dropbox.class.php");
    require_once($GLOBALS['CLASSES_DIR']."/DropboxAccount.class.php");
    require_once($GLOBALS['CLASSES_DIR']."/DropboxFiles.class.php");
    require_once($GLOBALS['LIB_ROOT']."/CurlWrapper.php");
    $curl = new CurlWrapper();
    $dropbox = new Dropbox($curl);
    $dropboxAccount = new DropboxAccount($dbhRaks);
    $dropboxFiles = new DropboxFiles($dropbox, $dropboxAccount, $curl, $dbhRaks);
    $dropboxFiles->showFile($match[1]);
    exit;
}

if(preg_match("/(\w{3})\/(\w+)\/(\d+)_(\d{2,4})_(\d{2,4})\.(\w{3})$/",$src,$match)){
	//print_r($match);
	
	$path_s = $match[1];
	$path_b = $match[2];
	$ID = $match[3];
	$w = $match[4];
	$h = $match[5];
	$ext = $match[6];
	
	//checking permission

	$data = $Images->get_image_data($GLOBALS['IMAGE_UPLOAD_ORIGINAL_PATH'],$path_s,$path_b);
	//var_dump($data,$path_s,$path_b);
	if($data === false || $data['approve_state'] == 2 || $data['ID'] != $ID) exit;
	
	$origExt = $Images->get_image_extension_by_type($data['img_type']);
	if($origExt == 'none') $origExt = 'png';
	
	$cache_filename = $GLOBALS['IMAGE_CACHE_PATH']."$path_s/$path_b/$ID"."_".$w."_".$h.".$ext";


	$original_filename = $GLOBALS['IMAGE_UPLOAD_ORIGINAL_PATH']."$path_s/$path_b/$path_b.".$origExt;
	//echo $original_filename;
	
	
	if(file_exists($cache_filename)){
		
		$i_type = $Images->get_type_by_extension($ext);
		$Images->show_image($cache_filename, $i_type);
		
		exit;
	}
	
	$Images->prepare_images_path($GLOBALS['IMAGE_CACHE_PATH']."$path_s/");
	$Images->prepare_images_path($GLOBALS['IMAGE_CACHE_PATH']."$path_s/$path_b/");
	$Images->cache_image($original_filename,$cache_filename,$w,$h);
	
	$i_type = $Images->get_type_by_extension($ext);
	$Images->show_image($cache_filename,$i_type);	
	exit;
	
}

if(preg_match("/(\w{3})\/(\w+)\/maxh_(\d+)_(\d{2,4})\.(\w{3})$/",$src,$match)){
    //print_r($match);
    
    $path_s = $match[1];
    $path_b = $match[2];
    $ID = $match[3];
    $h = $match[4];
    $ext = $match[5];
    
    //checking permission

    $data = $Images->get_image_data($GLOBALS['IMAGE_UPLOAD_ORIGINAL_PATH'],$path_s,$path_b);
    //var_dump($data,$path_s,$path_b);
    if($data === false || $data['approve_state'] == 2 || $data['ID'] != $ID) exit;
    
    $cache_filename = $GLOBALS['IMAGE_CACHE_PATH']."$path_s/$path_b/$ID"."_maxh_".$h.".$ext";
	$origExt = $Images->get_image_extension_by_type($data['img_type']);
	if($origExt == 'none') $origExt = 'png';
    $original_filename = $GLOBALS['IMAGE_UPLOAD_ORIGINAL_PATH']."$path_s/$path_b/$path_b.".$origExt;
    //echo $original_filename;
    
    
    if(file_exists($cache_filename)){
        
        $i_type = $Images->get_type_by_extension($ext);
        $Images->show_image($cache_filename,$i_type);
        
        exit;
    }
    
    $Images->prepare_images_path($GLOBALS['IMAGE_CACHE_PATH']."$path_s/");
    $Images->prepare_images_path($GLOBALS['IMAGE_CACHE_PATH']."$path_s/$path_b/");
    $Images->cache_image_main_h($original_filename,$cache_filename,$h);
    
    $i_type = $Images->get_type_by_extension($ext);
    $Images->show_image($cache_filename,$i_type);   
    exit;
    
}

if(preg_match("/(\w{3})\/(\w+)\/scenter_(\d+)_(\d{2,4})\.(\w{3})$/",$src,$match)){
    //print_r($match);
    
    $path_s = $match[1];
    $path_b = $match[2];
    $ID = $match[3];
    $width = $match[4];
    $ext = $match[5];
    
    //checking permission

    $data = $Images->get_image_data($GLOBALS['IMAGE_UPLOAD_ORIGINAL_PATH'],$path_s,$path_b);
    //var_dump($data,$path_s,$path_b);
    if($data === false || $data['approve_state'] == 2 || $data['ID'] != $ID) exit;
    
    $cache_filename = $GLOBALS['IMAGE_CACHE_PATH']."$path_s/$path_b/$ID"."_scenter_".$width.".$ext";
	$origExt = $Images->get_image_extension_by_type($data['img_type']);
	if($origExt == 'none') $origExt = 'png';
    $original_filename = $GLOBALS['IMAGE_UPLOAD_ORIGINAL_PATH']."$path_s/$path_b/$path_b.".$origExt;
    //echo $original_filename;
    
    
    if(file_exists($cache_filename)){
        
        $i_type = $Images->get_type_by_extension($ext);
        $Images->show_image($cache_filename,$i_type);
        
        exit;
    }
    
    $Images->prepare_images_path($GLOBALS['IMAGE_CACHE_PATH']."$path_s/");
    $Images->prepare_images_path($GLOBALS['IMAGE_CACHE_PATH']."$path_s/$path_b/");
    $Images->cache_image_center_square($original_filename,$cache_filename,$width);
    
    $i_type = $Images->get_type_by_extension($ext);
    $Images->show_image($cache_filename,$i_type);   
    exit;
    
}



add_to_log("[src $src]", "error_image");
