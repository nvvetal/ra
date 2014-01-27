<?php

class Registrator_forum_client {

    function Registrator_forum_client(){
    }

    function register($params){
	//TODO:
    	$path_to_module = dirname(__FILE__);


		define('IN_PHPBB',true); 
        define('PHPBB_INSTALLED',true); 
        global $phpbb_root_path; 
        $phpbb_root_path = $path_to_module.'/'; 
        global $phpEx; 
        $phpEx = 'php'; 
                 
        global $user, $auth, $template, $cache, $db,$config; 
 
        require_once('common.php'); 
        require_once('includes/auth/auth_apache.php'); 
        require_once('includes/functions_user.php'); 
                 
        $phpbb_user_data = user_row_apache($params['user_data']["username"], $params['user_data']["password"]); 
                 
        $phpbb_user_data['user_email']=$params['user_data']['user_email']; 
                 
        return user_add($phpbb_user_data);	
    }


}

?>