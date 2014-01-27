<?php

require_once($GLOBALS['CLASSES_DIR'].'MenuItem.class.php');

class mailer_admin_menu_items extends MenuItem{

    function mailer_admin_menu_items(){
	$this->MenuItem();
    }

    function get_id(){
	return "mailer";
    }

    function get_name(){
	return "Mailer";
    }

    function get_module(){
	return "mailer";
    }

    function init_menu(){
	$this->menu = array(
	    'Advertise'=>array(
		'id'=>'advertise',
		'is_url'=>1,
	    ),
	);
    }


    //CALLBACKS

}

?>