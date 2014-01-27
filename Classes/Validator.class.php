<?php

class Validator {
	
	/*
	
	$validate_rules = array(
		'param'=>array(
			// possible check params
			'validators'=>array(
				"some name"=>array(
				
					//function_checker params	
					"params"=>array(
						'param1'=>'param1 rule value',
						'param2'=>'param2 rule value',
					),
					'error_code'=>'some error code, on which getting 
						error message from default or defined messages',
				),
			),
			'default'=>'some default value',
			'print_name'=>'some web print name of param if error, 
				default is `param`',
			//errors will show only if not set `default`

			
			
		),
	);
	
	*/
	
	var $validate_rules = array();
	var $validate_params = array();
	var $error_messages = array(
		'is_not_empty' => array(
			"message" => "[name] is empty! Please set some value!",
			"code" => "1",
		),
        'is_char_min' => array(
            "message" => "[name] is small!",
            "code" => "1",      
        ),
	);
	
	var $validate_options = array(
		'end_on_one_error' => 0,
		'error_write_to_log' => 1,
		'error_code_prefix' => '',
	);
	
	var $checked_error_params=array();
	
	
	function Validator($error_messages=array()){
		if(is_array($error_messages) && count($error_messages)>0){
			$this->error_messages = $error_messages;
		}
	}
	
	function set_error_code_prefix($prefix){
		$this->validate_options['error_code_prefix'] = $prefix;
	}
	
	function set_error_write_to_log ($is_write){
		$this->validate_options['error_write_to_log'] = ($is_write == true) ? 1 : 0;
	}
	
	function set_end_on_one_error ($is_end){
		$this->validate_options['end_on_one_error'] = ($is_end == true) ? 1 : 0;
	}	
	
	function validate($validate_params,$validate_rules){
		$this->validate_rules = $validate_rules;
		$this->validate_params = $validate_params;
		$this->checked_error_params = array();
		
		return $this->check_values();
	}
	
	function check_values(){
		foreach ($this->validate_params as $param=>$value){
			if(isset($this->validate_rules[$param])){
				
				foreach ($this->validate_rules[$param]['validators'] as $validator=>$validator_params){
				
					if(!method_exists($this,"check_".$validator)){
						add_to_log("Method check_".$validator."is not existing!",'error_validator');
						return false;
						
					}
					
					$is_valid = call_user_func(array($this, "check_".$validator), array('value'=>$value,'params'=>isset($validator_params['params']) ?$validator_params['params'] : '' ));
					//print_r($hmm);
				
					if(!$is_valid){
					
						if(!isset($this->validate_rules[$param]['default'])){
							$this->checked_error_params[$param]=array(
								'message'=>$this->prepare_error_message($param,$validator,@$validator_params['params'],$this->validate_rules[$param]),
								'code'=>(isset($validator_params['error_code'])) ? $validator_params['error_code']: $this->validate_options['error_code_prefix'].$this->error_messages[$validator]['code'],
							);
							
							if(empty($this->checked_error_params[$param]['code'])){
								$this->checked_error_params[$param]['code'] = 'e_'.$validator;
							}
						}else{
							$this->validate_params[$param] = $this->validate_rules[$param]['default'];
						}
					
						if($this->validate_options['end_on_one_error'] == 1) {
							return array('errors'=>$this->checked_error_params,'e_cnt'=>1,'params'=>$this->validate_params);
						}else{
							break;
						}
					}
				
				}
			}
		}
		
		return array('errors'=>$this->checked_error_params,'e_cnt'=>count($this->checked_error_params),'params'=>$this->validate_params);
	}
	
	
	function prepare_error_message($name,$validator_name,$validator_params,$rule){
		$message = $this->get_callback_message_template($validator_name);
		//print_r($rule);
		$name = (isset($rule['print_name'])) ? $rule['print_name'] : $name;
		
		$message = str_replace("[name]",$name,$message);
		
		if(is_array($validator_params)){
			foreach ($validator_params as $key=>$value){
				$message = str_replace("[$key]",$key,$message);
				$message = str_replace("[$key"."_value]",$value,$message);
			}
		}
		
		return $message;
		
	}
	
	function get_callback_message_template($callback){
		if(!is_array($this->error_messages[$callback]['message']) && !isset($this->error_messages[$callback]['message'])){
			return "[name] is not valid to $callback!";
		}
		
		return $this->error_messages[$callback]['message'];
	}
	
	
	//************************ CHECKERS ********************
	
	function check_is_not_empty($params){
		return !empty($params['value']);
	}
	
	function check_is_numeric($params){
		return is_numeric($params['value']);
	}

	function check_is_numeric_if_not_empty($params){
		if(empty($params['value'])) return true;
		
		return is_numeric($params['value']);
	}	
	
	
	function check_is_min_max($params){
		//print_r($params);
		if($params['value'] >= $params['params']['min'] && $params['value'] <= $params['params']['max']) return true;
		
		return false;
	}
	
	function check_in_array($params){
		return in_array($params['value'],$params['params']['array']);
	}
	
	function check_is_dns($params){
		
		if(preg_match("/^([A-z0-9]+)$/",$params['value'],$s)){
			
			return true;	
		}else{
			return false;
		}
		
		
	}
	
	function check_is_char_min($params){

		if(strlen($params['value']) >= $params['params']['min']) return true;
		
		return false;		
	}
	
	function check_is_char_max($params){

		if(strlen($params['value']) <= $params['params']['max']) return true;
		
		return false;		
	}	
	
	function check_is_email($params){
		//TODO!!!!
		/*
		if(strpos($params['value'],'@')!==false){
			return true;
		}
		*/
		if(preg_match('/^[A-z0-9][\w.-]*@[A-z0-9][\w\-\.]+\.[A-z0-9]{2,6}$/',$params['value'])){
		    return true;
		}
		return false;
		
	}
}

?>