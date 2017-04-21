<?php

class ValidatorContainer {
	
	var $rules;
	var $validator;
	var $class;
	
	var $result_error_name="v_errors";
	var $error_name="errors";
	
	function ValidatorContainer($validator,$class=''){
		$this->validator = $validator;
		$this->class = $class;
		if(method_exists($this,'init_rules'))$this->init_rules();
	}
	
	function add_rule($action,$data){
		$this->rules[$action]=$data;
	}
	
	function get_rule ($name){
		if(!isset($this->rules[$name]) || !is_array($this->rules[$name])) return array();
		
		return $this->rules[$name];
	}
	
	function set_rules($rules){
		$this->rules = $rules;
	}
	
	function check_params($action,$validate_params){
		$validate_rules = $this->get_rule($action);
		
		//var_dump($validate_rules,$validate_params);
		
		return $this->validator->validate($validate_params,$validate_rules);
	}
	
	function validate_params($action,$params){
		if(count($params) == 0) return false;
		
		$result = $this->check_params($action,$params);
		
		if(@$result['e_cnt']>0) return array('v_errors'=>$result);
		
		return true;		
	}
	
	function call_method($action,$params=array()){
		
		if(count($params) == 0) return $this->call_simple_method($action);
		
		$result = $this->check_params($action,$params);
		
		if(@$result['e_cnt']>0) return array('v_errors'=>$result);
		
		$params = $result['params'];
		
		return $this->class->$action($params);
	}
	
	function call_method_by_id($action,$id,$params=array()){
		
		if(count($params) == 0) return $this->call_simple_method_by_id($action,$id);
		
		$result = $this->check_params($action,$params);
		
		if(@$result['e_cnt']>0) return array($this->result_error_name=>$result);
		
		$params = $result['params'];
		
		return $this->class->$action($id,$params);		
	}
	
	
	// get_simple_methodXXXXX using for call methods, which not need params
	function call_simple_method($action){
		return $this->class->$action();
	}
	
	function call_simple_method_by_id($action,$id){
		return $this->class->$action($id);
	}	
	
	
	function is_valid($result){
		if(is_array($result) && isset($result[$this->result_error_name])){
			//echo $result[$this->result_error_name];
			return false;
		}
		
		return true;
	}
	
	function get_errors($result){
		if(isset($result[$this->result_error_name][$this->error_name])){
			return $result[$this->result_error_name][$this->error_name];
		}
		
		return array();		
	}
	
	
	
}