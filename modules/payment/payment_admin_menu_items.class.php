<?php

require_once($GLOBALS['CLASSES_DIR'].'MenuItem.class.php');

class payment_admin_menu_items extends MenuItem{

    function payment_admin_menu_items(){
        $this->MenuItem();
    }

    function get_id(){
        return "payment";
    }

    function get_name(){
        return "Payment";
    }

    function get_module(){
        return "payment";
    }

    function init_menu(){
        $this->menu = array(
            'Payment'=>array(
                'id'=>'payment',
                'is_url'=>1,
            ),
        );
    }

    //PAGES
    function page_default($params){
        if($params['a_sid'] == 'payment') return $this->page_payment($params);
        $params['smarty']->assign('http_module_path',$GLOBALS['HTTP_PROJECT_PATH'].$params['module'].'/');
        $go = !empty($params['ago']) ? $params['ago'] : $params['a_sid'];
        $data = $params['smarty']->fetch($params['template_path'].$go.'.tpl');
        return $data;
    }
    
    function page_payment($params){
        $Payment = Registry::get('Payment');
        
        require_once($GLOBALS['CLASSES_DIR'].'Utils.class.php');
        $Utils = new Utils();
        $year = isset($_REQUEST['dateYear']) ? $_REQUEST['dateYear']: date('Y');
        $month = isset($_REQUEST['dateMonth']) ? $_REQUEST['dateMonth']: date('m');
        $day = isset($_REQUEST['dateDay']) ? $_REQUEST['dateDay']: date('d');
        $params['smarty']->assign('request_time',strtotime(sprintf("%04d-%02d-%02d",$year,$month,$day)));
        $dates = $Utils->get_month_days($year,$month,'desc');
        $params['smarty']->assign('dates',$dates);
        $params['smarty']->assign('Payment',$Payment);
        $go = !empty($params['ago']) ? $params['ago'] : 'payment';
        $data = $params['smarty']->fetch($params['template_path'].$go.'.tpl');
        return $data;
    }    

    //ACTIONS
}

?>