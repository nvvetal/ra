<?php

class i18n_container extends ValidatorContainer {
	
	function i18n_container ($validator,$class){
		$this->ValidatorContainer($validator,$class);
	}
	
	function init_rules(){
		$this->rules = array(
			//ACTION add_school
			'i18n_save_key'=>array(
				'value'=>array(
					'validators'=>array(
						"is_not_empty"=>array(),
					),

					'print_name'=>"Translate",
				),
			),

		);
	}
}

?>