<?php

class blog_firm_container extends ValidatorContainer {
	
	function blog_firm_container ($validator,$class){
		$this->ValidatorContainer($validator,$class);
	}
	
	function init_rules(){
		$this->rules = array(
			
			'add_blog'=>array(
				'post_text'=>array(
					'validators'=>array(
						"is_not_empty"=>array(),
					),

					'print_name'=>"Blog Text",	
				),
				
				'firm_id'=>array(
					'validators'=>array(
						"is_not_empty"=>array(),
						"is_numeric"=>array(),
					),					
					'print_name'=>'Firm ID',
				),
				
				
				
			),


		);
	}
}

?>