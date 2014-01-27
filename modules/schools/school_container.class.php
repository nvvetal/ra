<?php

class school_container extends ValidatorContainer {
	
	function school_container ($validator,$class){
		$this->ValidatorContainer($validator,$class);
	}
	
	function init_rules(){
		$this->rules = array(
			//ACTION add_school
			'add_school'=>array(
				'name'=>array(
					'validators'=>array(
						"is_not_empty"=>array(),
					),

					'print_name'=>"Name",	
				),
/*
				'email'=>array(
					'validators'=>array(
						"is_not_empty"=>array(),
					),

					'print_name'=>"Email",	
				),
				*/				
				'phone_1'=>array(
					'validators'=>array(
						"is_not_empty"=>array(),
					),

					'print_name'=>"School phone 1",	
				),	
				'address'=>array(
					'validators'=>array(
						"is_not_empty"=>array(),
					),

					'print_name'=>"Address",	
				),	
				'description'=>array(
					'validators'=>array(
						"is_not_empty"=>array(),
					),

					'print_name'=>"School description",	
				),	
				'city_id' => array(
					'validators'=>array(
						"is_not_empty"=>array(),
					),

					'print_name'=>"City",					
				),
			),

			'edit_school'=>array(
				'name'=>array(
					'validators'=>array(
						"is_not_empty"=>array(),
					),

					'print_name'=>"Name",	
				),
/*
				'email'=>array(
					'validators'=>array(
						"is_not_empty"=>array(),
					),

					'print_name'=>"Email",	
				),
				*/				
				'phone_1'=>array(
					'validators'=>array(
						"is_not_empty"=>array(),
					),

					'print_name'=>"School phone 1",	
				),	
				'address'=>array(
					'validators'=>array(
						"is_not_empty"=>array(),
					),

					'print_name'=>"Address",	
				),	
				'description'=>array(
					'validators'=>array(
						"is_not_empty"=>array(),
					),

					'print_name'=>"School description",	
				),					
				'city_id' => array(
					'validators'=>array(
						"is_not_empty"=>array(),
					),
					'print_name'=>"City",					
				),							
			
			),		
		);
	}
}

?>