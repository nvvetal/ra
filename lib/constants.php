<?php

$GLOBALS['SMARTY_DIR'] = $GLOBALS['PROJECT_ROOT']."/Smarty/";
$GLOBALS['CLASSES_DIR'] = $GLOBALS['PROJECT_ROOT']."/Classes/";
$GLOBALS['MODULES_DIR'] = $GLOBALS['PROJECT_ROOT']."/modules/";


$GLOBALS['OVERLIB'] = 'overlib/overlib.js';

$GLOBALS['TEMPLATES_DIR'] = $GLOBALS['PROJECT_ROOT'].'/templates/';
$GLOBALS['BLOCKS_DIR'] = $GLOBALS['PROJECT_ROOT'].'/blocks/';
$GLOBALS['LANGUAGES_DIR'] = $GLOBALS['PROJECT_ROOT'].'/languages/';


$GLOBALS['UPLOAD_DIR'] = $GLOBALS['PROJECT_ROOT'].'/uploads/';
$GLOBALS['BACKUP_DIR'] = $GLOBALS['PROJECT_ROOT'].'/backups/';
$GLOBALS['LOG_DIR'] = $GLOBALS['PROJECT_ROOT'].'/log/';
$GLOBALS['TMP_DIR'] = $GLOBALS['PROJECT_ROOT'].'/tmp/';


$image_rules = array(
	"upload"=>array(
		'size'=>500000,
		'img_types'=>array(
			'image/gif'=>'image/gif',
			'image/jpeg'=>'image/jpeg',
		),
	),
);

$GLOBALS['IMAGE_UPLOAD_ORIGINAL_PATH'] = $GLOBALS['PROJECT_ROOT'].'/images/portal/';
$GLOBALS['IMAGE_CACHE_PATH'] = $GLOBALS['PROJECT_ROOT'].'/cache/portal/images/';
$GLOBALS['IMAGEMAGICK_PATH'] = '';

?>