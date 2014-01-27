<?php

$db_params['rakscom'] = array(                                                                                                             
        "server"=>'localhost',                                                                                                             
        "database"=>'rakscom',                                                                                                             
        "user"=>'root',                                                                                                                    
        "password"=>'',                                                                                                                    
);   
$db_params['forum']=array(
  	"server"=>'localhost', 
	"database"=>'forum',
	"user"=>'root',
	"password"=>'',
);
$GLOBALS['HTTP_PROJECT_ROOT'] = 'http://rakscom/';
$GLOBALS['HTTP_IMAGES_PATH'] = $GLOBALS['HTTP_PROJECT_ROOT']."i/";
$GLOBALS['IMAGEMAGICK_PATH'] = "/usr/bin/";

$GLOBALS['CAPTCHA'] = array(
    'public'    => '6LdGt8kSAAAAAErFDLTmu5bJd9XpQtx7FjjrU7t8',
    'private'   => '6LdGt8kSAAAAALXA8cG77QeFSfsiBAWkTNXAoo-j',
);
?>