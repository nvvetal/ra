<?php

class Registrator_forum {
	var $schema;
	
	function Registrator_forum(){
		
	}
	
	function set_schema(){
		$this->schema=array(
			'username'=>'login',
			'password'=>'password',
			'user_email'=>'email',
		);
	}
	
	function register_forum($params){
		//print_r($params);
	    $url = $params['host']."/".$params['module_name']."/Registrator_forum_client.php?pass=435hjhdgdfl3&username=".urlencode($params['user_data']['username'])."&password=".urlencode($params['user_data']['password'])."&user_email=".urlencode($params['user_data']['user_email']);

	    $res = @file_get_contents($url);
	    if($res===false){
			add_to_log("[error can't connect][url $url]",'error_register_forum');
			return false;
	    }
	
	    if(empty($res)){
			add_to_log("[error can't add user][url $url][res $res]",'error_register_forum');
			return false;
	    }else{
			add_to_log("[forum_id $res][url $url]",'register_forum');
			return $res;
	    }

	    
	}
	
}

?>