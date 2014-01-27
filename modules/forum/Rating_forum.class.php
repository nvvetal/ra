<?php

class Rating_forum {
	
	var $server_pass = 'cxvlkjl34mn6';
	var $url;

	
	function Rating_forum( $url, $server_pass = ''){
		if(!empty($server_pass)) $this->server_pass;
		$this->url = $url;
	}
	
	function send_action( $action, $item_id, $type ){
		$url = $this->url."?pass=".$this->server_pass."&action=".urlencode($action)."&id=".urlencode($item_id)."&type=".urlencode($type);
		//echo $url;
		//exit;
		@file_get_contents($url);
	}
	
}

?>