<?php

class partner_links_container extends ValidatorContainer {
	
	function partner_links_container ($validator,$class){
		$this->ValidatorContainer($validator,$class);
	}
	
	function init_rules(){
		$this->rules = array(
			//ACTION add_school
			'add_link'=>array(
				'url'=>array(
					'validators'=>array(
						"is_not_empty"=>array(),
					),

					'print_name'=>"Url",	
				),

				'name'=>array(
					'validators'=>array(
						"is_not_empty"=>array(),
					),

					'print_name'=>"Name",	
				),
							
			
			),

			'change_link'=>array(
				'url'=>array(
					'validators'=>array(
						"is_not_empty"=>array(),
					),

					'print_name'=>"Url",	
				),

				'name'=>array(
					'validators'=>array(
						"is_not_empty"=>array(),
					),

					'print_name'=>"Name",	
				),
							
			
			),		
		);
	}
}

?>