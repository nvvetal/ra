<?php

class calendar_container extends ValidatorContainer {
	
	function calendar_container ($validator,$class){
		$this->ValidatorContainer($validator,$class);
	}
	
	function init_rules(){
		$this->rules = array(
			//ACTION add_calendar
			'add_calendar'=>array(
				'city_id'=>array(
					'validators'=>array(
						"is_not_empty"=>array(),
					),

					'print_name'=>"City",	
				),
				'category_id'=>array(
					'validators'=>array(
						"is_not_empty"=>array(),
					),

					'print_name'=>"Category",	
				),
				'name'=>array(
					'validators'=>array(
						"is_not_empty"=>array(),
					),

					'print_name'=>"Name",	
				),
				
				'small_info'=>array(
					'validators'=>array(
						"is_not_empty"=>array(),
					),

					'print_name'=>"Small info",	
				),

				'full_info'=>array(
					'validators'=>array(
						"is_not_empty"=>array(),
					),

					'print_name'=>"Full info",	
				),
				'organizator_name'=>array(
					'validators'=>array(
						"is_not_empty"=>array(),
					),

					'print_name'=>"Organizator full name",	
				),

				'address'=>array(
					'validators'=>array(
						"is_not_empty"=>array(),
					),

					'print_name'=>"Address",	
				),	
			),


			//ACTION set_calendar
			'set_calendar'=>array(
				'city_id'=>array(
					'validators'=>array(
						"is_not_empty"=>array(),
					),

					'print_name'=>"City",	
				),
				'category_id'=>array(
					'validators'=>array(
						"is_not_empty"=>array(),
					),

					'print_name'=>"Category",	
				),
				'name'=>array(
					'validators'=>array(
						"is_not_empty"=>array(),
					),

					'print_name'=>"Name",	
				),
				'small_info'=>array(
					'validators'=>array(
						"is_not_empty"=>array(),
					),

					'print_name'=>"Small info",	
				),

				'full_info'=>array(
					'validators'=>array(
						"is_not_empty"=>array(),
					),

					'print_name'=>"Full info",	
				),
				'organizator_name'=>array(
					'validators'=>array(
						"is_not_empty"=>array(),
					),

					'print_name'=>"Organizator full name",	
				),

				'address'=>array(
					'validators'=>array(
						"is_not_empty"=>array(),
					),

					'print_name'=>"Address",	
				),	
			),

		);
	}
}

?>