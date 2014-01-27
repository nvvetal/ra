<?php

require_once($GLOBALS['CLASSES_DIR'].'MenuItem.class.php');

class partner_links_admin_menu_items extends MenuItem{

    function partner_links_admin_menu_items(){
	$this->MenuItem();
    }

    function get_id(){
	return "partner_links";
    }

    function get_name(){
	return "Partner Links";
    }

    function get_module(){
	return "partner_links";
    }

    function init_menu(){
	$this->menu = array(
	    'Partner Links'=>array(
		'id'=>'p_links',
		'is_url'=>1,
	    ),
	);
    }

    //PAGES
    function page_default($params){
	require_once($GLOBALS['MODULES_DIR'].$params['module'].'/partner_links.class.php');
	$partner_links = new partner_links($params['DBFactory']->get_db_handle("rakscom"));
	$params['smarty']->assign('partner_links',$partner_links);
	$params['smarty']->assign('http_module_path',$GLOBALS['HTTP_PROJECT_PATH'].$params['module'].'/');
    
	$go = !empty($params['ago']) ? $params['ago'] : $params['a_sid'];

	$data = $params['smarty']->fetch($params['template_path'].$go.'.tpl');
	return $data;
    }

    

    //ACTIONS
    function act_add_partner_link($params){
	    
	require_once($GLOBALS['MODULES_DIR'].$params['module'].'/partner_links.class.php');
	$params['partner_links'] = new partner_links($params['DBFactory']->get_db_handle("rakscom"));


           $l_params = array (
                "url"=>         $_REQUEST['url']        ? $_REQUEST['url']:"",
                "name"=>        $_REQUEST['name']       ? $_REQUEST['name']:"",
                "external_name"=>       $_REQUEST['external_name']      ? $_REQUEST['external_name']:"",
                "external_codepage"=>   $_REQUEST['external_codepage']  ? $_REQUEST['external_codepage']:"UTF-8",
                "description"=> $_REQUEST['description']? $_REQUEST['description']:"",
                "type"=>        $_REQUEST['type']       ? $_REQUEST['type']:"free",
                "free_viewed"=> $_REQUEST['free_viewed']? $_REQUEST['free_viewed']:0,
                "pay_clicks"=>  $_REQUEST['pay_clicks'] ? $_REQUEST['pay_clicks']:0,
                "pay_clicked"=> $_REQUEST['pay_clicked']? $_REQUEST['pay_clicked']:0,
                "pay_views"=>   $_REQUEST['pay_views']? $_REQUEST['pay_views']:0,
                "pay_viewed"=>  $_REQUEST['pay_viewed']? $_REQUEST['pay_viewed']:0,
                "pay_percent"=> $_REQUEST['pay_percent']? $_REQUEST['pay_percent']:1,
                "pay_percent_clicks"=>  $_REQUEST['pay_percent_clicks']? $_REQUEST['pay_percent_clicks']:0,
                "pay_percent_clicked"=> $_REQUEST['pay_percent_clicked']? $_REQUEST['pay_percent_clicked']:0,
                "is_enabled"=>  $_REQUEST['is_enabled']? 1:0,


            );

            $l_params['pay_end'] = sprintf("%04d-%02d-%02d",$_REQUEST['pay_endYear'],$_REQUEST['pay_endMonth'],$_REQUEST['pay_endDay']);

            $l_params['added_by']=$params['Session']->get_value($params['s'],'user_id');
            $l_params['added_datetime']=time();

            require_once($GLOBALS['MODULES_DIR'].$params['module'].'/partner_links_container.class.php');
            $partner_links_container_class = new partner_links_container($params['Validator'],$params['partner_links']);

            $partner_link_id = $partner_links_container_class->call_method("add_link",$l_params);

            if($partner_links_container_class->is_valid($partner_link_id) == false){

                $params['smarty']->assign('errors',$partner_links_container_class->get_errors($partner_link_id));

                $go = "add_link";

                return $go;
            }

	    return $params['ago'];
    }

    function act_set_partner_link($params){
	require_once($GLOBALS['MODULES_DIR'].$params['module'].'/partner_links.class.php');
	$params['partner_links'] = new partner_links($params['DBFactory']->get_db_handle("rakscom"));

            $l_params = array (
                "url"=>         $_REQUEST['url']        ? $_REQUEST['url']:"",
                "name"=>        $_REQUEST['name']       ? $_REQUEST['name']:"",
                "external_name"=>       $_REQUEST['external_name']      ? $_REQUEST['external_name']:"",
                "external_codepage"=>   $_REQUEST['external_codepage']  ? $_REQUEST['external_codepage']:"UTF-8",

                "description"=> $_REQUEST['description']? $_REQUEST['description']:"",
                "type"=>        $_REQUEST['type']       ? $_REQUEST['type']:"free",
                "free_viewed"=> $_REQUEST['free_viewed']? $_REQUEST['free_viewed']:0,
                "pay_clicks"=>  $_REQUEST['pay_clicks'] ? $_REQUEST['pay_clicks']:0,
                "pay_clicked"=> $_REQUEST['pay_clicked']? $_REQUEST['pay_clicked']:0,
                "pay_views"=>   $_REQUEST['pay_views']? $_REQUEST['pay_views']:0,
                "pay_viewed"=>  $_REQUEST['pay_viewed']? $_REQUEST['pay_viewed']:0,
                "pay_percent"=> $_REQUEST['pay_percent']? $_REQUEST['pay_percent']:1,
                "pay_percent_clicks"=>  $_REQUEST['pay_percent_clicks']? $_REQUEST['pay_percent_clicks']:0,
                "pay_percent_clicked"=> isset($_REQUEST['pay_percent_clicked'])? $_REQUEST['pay_percent_clicked']:0,
                "is_enabled"=>  $_REQUEST['is_enabled']? 1:0,

            );


            $l_params['pay_end'] = sprintf("%04d-%02d-%02d",$_REQUEST['pay_endYear'],$_REQUEST['pay_endMonth'],$_REQUEST['pay_endDay']);

            require_once('partner_links_container.class.php');
            $partner_links_container_class = new partner_links_container($params['Validator'],$params['partner_links']);

            $id = (isset($_REQUEST['id'])) ? intval($_REQUEST['id']) : 0 ;

            $res = $partner_links_container_class->call_method_by_id("change_link",$id,$l_params);

            if($partner_links_container_class->is_valid($res) == false){

                $params['smarty']->assign('errors',$partner_links_container_class->get_errors($res));

                $go = "edit_link";

                return $go;
            }

	    return $params['ago'];
    }

    function act_delete_link($params){
	    require_once($GLOBALS['MODULES_DIR'].$params['module'].'/partner_links.class.php');
	    $params['partner_links'] = new partner_links($params['DBFactory']->get_db_handle("rakscom"));

            $id = (isset($_REQUEST['id'])) ? intval($_REQUEST['id']) : 0 ;
            $params['partner_links']->delete_link($id);
	    return $params['ago'];

    }

    function act_up($params){
	    require_once($GLOBALS['MODULES_DIR'].$params['module'].'/partner_links.class.php');
	    $params['partner_links'] = new partner_links($params['DBFactory']->get_db_handle("rakscom"));

            $id = (isset($_REQUEST['id'])) ? intval($_REQUEST['id']) : 0 ;
            $params['partner_links']->move_link($id,'up');
	    return $params['ago'];

    }

    function act_down($params){
	    require_once($GLOBALS['MODULES_DIR'].$params['module'].'/partner_links.class.php');
	    $params['partner_links'] = new partner_links($params['DBFactory']->get_db_handle("rakscom"));

            $id = (isset($_REQUEST['id'])) ? intval($_REQUEST['id']) : 0 ;
            $params['partner_links']->move_link($id,'down');
	    return $params['ago'];

    }

    function act_change_visible_name($params){
	    require_once($GLOBALS['MODULES_DIR'].$params['module'].'/partner_links.class.php');
	    $params['partner_links'] = new partner_links($params['DBFactory']->get_db_handle("rakscom"));

            $visible_name = isset( $_REQUEST['visible_name'] ) ? $_REQUEST['visible_name'] : '';

            $params['partner_links']->set_config_value('visible_name',$visible_name);
	    return $params['ago'];

    }


}

?>