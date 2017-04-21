<?php

class Registrator {
	
	var $modules;
	
	function __construct($modules){
		$this->modules = $modules;
		
	}
	
	function register_user($user_data){
		if(empty($this->modules)){
			return true; 
		}
		
		$classes = array();
		
		$results=array();
		
		foreach ($this->modules as $key=>$module){
			$class = 'Registrator_'.$key;
			
			$class_file = $module['path'].$class.'.class.php';
			if(!file_exists($class_file)){
				add_to_log("[module $key][file $class_file][error class is not existing!]",'error_registrator');
			}
			
			require_once($class_file);
			
			$classes[$class] = new $class();
				
			$function = 'register_'.$key;
			//echo $function;
			if(method_exists($classes[$class],$function)){
				
				$classes[$class]->set_schema();
				$schema = $classes[$class]->schema;
				
				$new_user_data = $this->prepare_data($user_data,$schema,$key);
				
				if($new_user_data === false) break;
				
				$params = array(
					'module'=>$module,
					'module_name'=>$key,
					'host'=>$GLOBALS['HTTP_PROJECT_ROOT'],
					'user_data'=>$new_user_data,
				);
				
				$res = $classes[$class]->$function($params);
				
				$results[$key]=$res;
				
				add_to_log("[module $key][function $function][res $res]",'registrator');
				
				
				
			}else {
				add_to_log("[module $key][function $function][error function is not existing!]",'error_registrator');
				
			}
			
			
			return $results;
		}
	}
	
	function prepare_data($user_data,$schema,$module){
		$new_user_data = array();
		
		if(!is_array($schema) || count($schema)==0) return false;
		//var_dump($user_data,"-----",$schema,"-----",$module);
		
		
		foreach ($schema as $key=>$param){
			if(!isset($user_data[$param])){
				add_to_log("[module $module][param $param][error param is not existing!]",'error_registrator');
				return false;
			}
			
			$new_user_data[$key] = $user_data[$param];
		}
		
		return $new_user_data;
	}

}