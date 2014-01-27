<?php

class school_blog_container extends ValidatorContainer {
	
	function school_blog_container ($validator,$class){
		$this->ValidatorContainer($validator,$class);
	}
	
	function init_rules(){
		$this->rules = array(
			//ACTION add_school
			'add_data'=>array(
				'school_id'=>array(
					'validators'=>array(
						"is_not_empty"=>array(),
					),

					'print_name'=>"School ID",	
				),

				'author_id'=>array(
					'validators'=>array(
						"is_not_empty"=>array(),
					),

					'print_name'=>"Your ID",	
				),

				'text'=>array(
					'validators'=>array(
						"is_not_empty"=>array(),
					),

					'print_name'=>"Text",	
				),

							
			
			),
		);
	}
}

?>