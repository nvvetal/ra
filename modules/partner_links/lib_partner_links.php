<?php

function partner_links_actions($go,$action,$params){
    switch ($action){
	case "add_partner_link":

	    $l_params = array (
		"url"=>		$_REQUEST['url']	? $_REQUEST['url']:"",
		"name"=>	$_REQUEST['name']	? $_REQUEST['name']:"",
		"external_name"=>	$_REQUEST['external_name']	? $_REQUEST['external_name']:"",
		"external_codepage"=>	$_REQUEST['external_codepage']	? $_REQUEST['external_codepage']:"UTF-8",
		"description"=>	$_REQUEST['description']? $_REQUEST['description']:"",
		"type"=>	$_REQUEST['type']	? $_REQUEST['type']:"free",
		"free_viewed"=>	$_REQUEST['free_viewed']? $_REQUEST['free_viewed']:0,
		"pay_clicks"=>	$_REQUEST['pay_clicks']	? $_REQUEST['pay_clicks']:0,
		"pay_clicked"=>	$_REQUEST['pay_clicked']? $_REQUEST['pay_clicked']:0,
		"pay_views"=>	$_REQUEST['pay_views']? $_REQUEST['pay_views']:0,
		"pay_viewed"=>	$_REQUEST['pay_viewed']? $_REQUEST['pay_viewed']:0,
		"pay_percent"=>	$_REQUEST['pay_percent']? $_REQUEST['pay_percent']:1,
		"pay_percent_clicks"=>	$_REQUEST['pay_percent_clicks']? $_REQUEST['pay_percent_clicks']:0,
		"pay_percent_clicked"=>	$_REQUEST['pay_percent_clicked']? $_REQUEST['pay_percent_clicked']:0,
		"is_enabled"=>	$_REQUEST['is_enabled']? 1:0,
		

	    );

	    $l_params['pay_end'] = sprintf("%04d-%02d-%02d",$_REQUEST['pay_endYear'],$_REQUEST['pay_endMonth'],$_REQUEST['pay_endDay']);

            $l_params['added_by']=$params['Session']->get_value($params['s'],'user_id');
            $l_params['added_datetime']=time();

            require_once('partner_links_container.class.php');
            $partner_links_container_class = new partner_links_container($params['Validator'],$params['partner_links']);

            $partner_link_id = $partner_links_container_class->call_method("add_link",$l_params);

            if($partner_links_container_class->is_valid($partner_link_id) == false){

    		$params['smarty']->assign('errors',$partner_links_container_class->get_errors($partner_link_id));

                $go = "add_link";

                return $go;
    	    }	    


	    
	break;

	case "set_partner_link":
	    $l_params = array (
		"url"=>		$_REQUEST['url']	? $_REQUEST['url']:"",
		"name"=>	$_REQUEST['name']	? $_REQUEST['name']:"",
		"external_name"=>	$_REQUEST['external_name']	? $_REQUEST['external_name']:"",
		"external_codepage"=>	$_REQUEST['external_codepage']	? $_REQUEST['external_codepage']:"UTF-8",

		"description"=>	$_REQUEST['description']? $_REQUEST['description']:"",
		"type"=>	$_REQUEST['type']	? $_REQUEST['type']:"free",
		"free_viewed"=>	$_REQUEST['free_viewed']? $_REQUEST['free_viewed']:0,
		"pay_clicks"=>	$_REQUEST['pay_clicks']	? $_REQUEST['pay_clicks']:0,
		"pay_clicked"=>	$_REQUEST['pay_clicked']? $_REQUEST['pay_clicked']:0,
		"pay_views"=>	$_REQUEST['pay_views']? $_REQUEST['pay_views']:0,
		"pay_viewed"=>	$_REQUEST['pay_viewed']? $_REQUEST['pay_viewed']:0,
		"pay_percent"=>	$_REQUEST['pay_percent']? $_REQUEST['pay_percent']:1,
		"pay_percent_clicks"=>	$_REQUEST['pay_percent_clicks']? $_REQUEST['pay_percent_clicks']:0,
		"pay_percent_clicked"=>	$_REQUEST['pay_percent_clicked']? $_REQUEST['pay_percent_clicked']:0,
		"is_enabled"=>	$_REQUEST['is_enabled']? 1:0,

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
	break;

	case "delete_link":
	    $id = (isset($_REQUEST['id'])) ? intval($_REQUEST['id']) : 0 ;
	    $params['partner_links']->delete_link($id);
	break;

	case "up":
	case "down":
	    $id = (isset($_REQUEST['id'])) ? intval($_REQUEST['id']) : 0 ;
	    $params['partner_links']->move_link($id,$action);
	break;

	case "link_click":
	    $user_id = $params['Session']->get_value($params['s'],'user_id');

	    $stats_params = array(
		"s_datetime"=>time(),
		"s_user_id"=>$user_id,
		"s_referer"=>$_SERVER['HTTP_REFERER'],
		"s_type"=>"click",
		"s_ip"=>ip2long($_SERVER['REMOTE_ADDR']),
	    );

	    $id = (isset($_REQUEST['id'])) ? intval($_REQUEST['id']) : 0 ;
	    $params['partner_links']->set_stats_link_data($id,$stats_params);
	    $link = $params['partner_links']->get_link($id);

	    if($link === false ) return $go;

	    if($link['type'] == 'pay_clicks'){
		$params['partner_links']->change_link($id,array('pay_clicked'=>$link['pay_clicked']+1));
	    }

	    if($link['type'] == 'pay_percent'){
		$params['partner_links']->change_link(
		    $id,
		    array(
			'pay_percent_clicked'=>$link['pay_percent_clicked']+1,
			'pay_percent_clicks'=>$link['pay_percent_clicks']-1,

		    )
		);
	    }
		
	    add_to_log("[id $id][user_id $user_id][url {$link['url']}][referer ".$_SERVER['HTTTP_REFERER']."][ip {$_SERVER['REMOTE_ADDR']}]","partner_links_click");
	    header("Location: {$link['url']}");

	    exit;

	break;


	case "link_click_external":
	    $user_id = $params['Session']->get_value($params['s'],'user_id');

	    $stats_params = array(
		"s_datetime"=>time(),
		"s_user_id"=>$user_id,
		"s_referer"=>$_SERVER['HTTP_REFERER'],
		"s_type"=>"click",
		"s_ip"=>ip2long($_SERVER['REMOTE_ADDR']),
	    );

	    $id = (isset($_REQUEST['id'])) ? intval($_REQUEST['id']) : 0 ;
	    $params['partner_links']->set_stats_link_data($id,$stats_params);
	    $link = $params['partner_links']->get_link($id);

	    if($link === false ) return $go;

	    if($link['type'] == 'pay_percent'){
		$params['partner_links']->change_link(
		    $id,
		    array(
			'pay_percent_clicks'=>$link['pay_percent_clicks'] + $link['pay_percent'],
		    )
		);
	    }
		
	    add_to_log("[id $id][user_id $user_id][url {$link['url']}][referer ".$_SERVER['HTTTP_REFERER']."][ip {$_SERVER['REMOTE_ADDR']}]","partner_links_click_income");

	    //TODO: Here you can add some ads

	    header("Location: ".HTTP_PROJECT_PATH."forum");

	    exit;

	break;

	case "change_visible_name":
	    $visible_name = isset( $_REQUEST['visible_name'] ) ? $_REQUEST['visible_name'] : '';

	    $params['partner_links']->set_config_value('visible_name',$visible_name); 
	break;

    }

    return $go;

}

?>