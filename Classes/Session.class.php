<?php

class Session{	
	var $dbh;
	var $sess_timeout;
	var $sess_length;	
	var $sess_values = array();
	
	function Session($dbh, $sess_timeout = 432000, $sess_length = 16){
		$this->dbh = $dbh;
		$this->sess_timeout = $sess_timeout;
		$this->sess_length = $sess_length;
	}
		
	function session_create($user_id,$remote_addr,$user_agent,$type='web'){
	    $oldSessionId = false;
	    if($user_id > 0) $oldSessionId = $this->find_active_user_session($user_id,$remote_addr,$user_agent,$type);
	    if($oldSessionId !== false) return $oldSessionId;
		$sess_id = substr(md5(mt_rand().microtime()),0,$this->sess_length-1);		
		$state = 'active';		
		$fields=array(
			'sess_id'=>$sess_id,
			'user_id'=>$user_id,
			'remote_addr'=>$remote_addr,
			'user_agent'=>$user_agent,
			'state'=>$state,
			'createdTime'=>time(),
			'updatedTime'=>time(),
			'expireTime'=>time() + $this->sess_timeout,
		);		
		SQLInsert('sessions',$fields,$this->dbh);		
		$this->init_values($sess_id,$fields,0);		
		return $sess_id;
	}
	
	function find_active_user_session($user_id,$remote_addr,$user_agent,$type='web'){
        $query = "
            SELECT sess_id
            FROM sessions
            WHERE user_id = ".SQLQuote($user_id)." AND state = 'active' 
                AND expireTime > UNIX_TIMESTAMP() AND remote_addr = ".SQLQuote($remote_addr)."
                AND user_agent = ".SQLQuote($user_agent)."
                AND type = ".SQLQuote($type)."
            ORDER BY updatedTime DESC
            LIMIT 1
        ";
        $data = SQLGet($query,$this->dbh);
        if(!isset($data['sess_id'])) return false;
        $sess_id = $data['sess_id'];
        $this->session_touch($sess_id);
        return $sess_id;
	}
	
	function find_inactive_sessions($limit=10){
	    $query = "
	       SELECT *
	       FROM sessions
	       WHERE state != 'active' OR expireTime < UNIX_TIMESTAMP()
	       ORDER BY expireTime ASC
	       LIMIT $limit
	    ";
	    return SQLGetRows($query,$this->dbh);
	}
	
	function session_touch($sess_id){		
		$fields=array(
			'updatedTime'=>time(),
			'expireTime'=>time() + $this->sess_timeout,
		);		
		SQLUpdate('sessions',$fields,"WHERE sess_id = ".SQLQuote($sess_id),$this->dbh);		
		$this->init_values($sess_id);
	}
	
	function is_session_active($sess_id,$remote_addr,$user_agent,$type='web'){
		$query="
			SELECT *
			FROM sessions
			WHERE sess_id = ".SQLQuote($sess_id)." AND type = ".SQLQuote($type)."
			LIMIT 1
		";		
		$session = SQLGet($query,$this->dbh);		
		if(!isset($session['sess_id'])) return false;		
		if($session['expireTime'] <= time()){			
			if($session['state'] == 'active') $this->close_session($sess_id,'expired');			
			return false;
		}		
		if($session['remote_addr'] != $remote_addr || $session['user_agent'] != $user_agent) return false;		
		return true;
	}
	
	function close_session($sess_id,$state){
		$fields=array(
			'state'=>$state,
		);		
		SQLUpdate('sessions',$fields,"WHERE sess_id=".SQLQuote($sess_id),$this->dbh);
	}
	
	function remove_session($sess_id){
	    $query = "
	       DELETE FROM sessions WHERE sess_id = ".SQLQuote($sess_id)."
	    ";
	    SQLQuery($query,$this->dbh);
	    $query = "
	       DELETE FROM sessions_data WHERE sess_id = ".SQLQuote($sess_id)."
	    ";
	     SQLQuery($query,$this->dbh);
	}
	
	function init_values($sess_id,$s_data=array(),$is_need_data=1){		
		$values = array();		
		if(is_array($s_data) && count($s_data)>0){
			$values = $s_data;
		}else{			
			$query="
				SELECT *
				FROM sessions
				WHERE sess_id = ".SQLQuote($sess_id)."
			";			
			$s_data = SQLGet($query,$this->dbh);			
			if($s_data !== false){
				foreach ($s_data as $key=>$value){				
					$values[$key]=$value;
				}
			}
		}
		if($is_need_data == 0) {
			$this->sess_values[$sess_id]=$values;
			return true;
		}		
		$query="
			SELECT *
			FROM sessions_data
			WHERE sess_id = ".SQLQuote($sess_id)."
		";	
		$rows = SQLGetRows($query,$this->dbh);		
		foreach ($rows as $key=>$row){			
			$values[$row['s_param']] = $row['s_value'];
		}
		$this->sess_values[$sess_id]=$values;		
	}
	
	function get_value($sess_id,$key){
		if(!isset($this->sess_values[$sess_id])){
			$this->init_values($sess_id);
		}
		return isset($this->sess_values[$sess_id][$key]) ? $this->sess_values[$sess_id][$key] : null;
	}
	
	function set_value($sess_id,$key,$value){
		if(!isset($this->sess_values[$sess_id])){
			$this->init_values($sess_id);
		}		
		
		switch ($key){
			case "user_id":
			case "updatedTime":
			case "expireTime":
			case "state":
			case "type":
			case "remote_addr":
			case "user_agent":
				$this->set_sess_values($sess_id,$key,$value);
			break;
			
			default:
				$this->set_sess_data($sess_id,$key,$value);
			break;
		}
		$this->sess_values[$sess_id][$key] = $value;
	}
	
	function set_sess_data($sess_id,$key,$value){
		$query = "
			REPLACE INTO sessions_data (sess_id,s_param,s_value) 
			VALUES (".SQLQuote($sess_id).",".SQLQuote($key).",".SQLQuote($value).")
		";		
		SQLQuery($query,$this->dbh);			
	}
	
	function get_sess_values($sess_id){
	    $this->init_values($sess_id);
	    return $this->sess_values[$sess_id];
	}
	
	function set_sess_values($sess_id,$key,$value){
		$query = "
			UPDATE sessions
			SET $key = ".SQLQuote($value)." 
			WHERE sess_id = ".SQLQuote($sess_id)."
		";		
		SQLQuery($query,$this->dbh);		
	}	
}
?>