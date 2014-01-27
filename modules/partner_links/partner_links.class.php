<?php

class partner_links {
    var $dbh;

    function partner_links ($dbh){
	$this->dbh = $dbh;
    }

    function add_link($params){
	$params['position'] = $this->get_next_position();

	SQLInsert("partner_links",$params,$this->dbh);

	return SQLInsId($this->dbh);
    }

    function change_link($id,$params){
	SQLUpdate("partner_links",$params,"WHERE id=".SQLQuote($id),$this->dbh);
    }

    function delete_link($id){
	$query = "
	    DELETE FROM partner_links
	    WHERE id =".SQLQuote($id)."
	";
	SQLQuery($query,$this->dbh);

	$this->reset_position();
    }

    function reset_position(){
	$links = $this->get_links(0);

	$i = 1;
	foreach ($links as $link_key=>$link){
	    $params['position'] = $i;
	    $this->change_link($link['id'],$params);
	    $i++;
	}
    }

    function get_link($id){
	$query = "
	    SELECT *
	    FROM partner_links
	    WHERE id = ".SQLQuote($id)."
	    LIMIT 1
	";

	return SQLGet($query,$this->dbh);
    }


    function get_links( $only_enabled = 1 ){
	$WHERE = "";

	if($only_enabled == 1){
	    $WHERE = "
		WHERE is_enabled = 1 AND (type='free' 
		    OR (type = 'pay' AND pay_end > NOW()) 
		    OR (type = 'pay_clicks' AND pay_clicks > pay_clicked) 
		    OR (type = 'pay_view' AND pay_views > pay_viewed)
		    OR (type = 'pay_percent' AND pay_percent_clicks >= 1)
		)
	    ";
	}
	

	$query = "
	    SELECT *
	    FROM partner_links
	    $WHERE 
	    ORDER BY position ASC
	";
	
	return SQLGetRows($query,$this->dbh);
    }

    function get_links_show($user_id){
	$links = $this->get_links();

	if(is_array($links) && count($links)>0){
	    foreach ($links as $key=>$link){
		if($link['type'] == 'pay_view'){
		    $params = array(
			'pay_viewed'=>$link['pay_viewed']+1,
		    );
		    $this->change_link($link['id'],$params);
		}
		
		if($link['type'] == 'free'){
		    $params = array(
			'free_viewed'=>$link['free_viewed']+1,
		    );
		    $this->change_link($link['id'],$params);
		}
		

		$params = array(
		    "s_datetime"=>time(),
		    "s_type"=>"view",
		    "s_user_id"=>$user_id,
		    "s_referer"=>$_SERVER['HTTP_REFERER'],
		    "s_ip"=>ip2long($_SERVER['REMOTE_ADDR']),
		);
		$this->set_stats_link_data($link['id'],$params);	
	    }
	}

	return $links;
    }

    function get_next_link( $position, $move_to='up' ){
	if($move_to == 'up' ){
	    $ord = "DESC";
	    $cmp = "<";
	}else{
	    $ord = "ASC";
	    $cmp = ">";
	    
	}

	$query = "
	    SELECT *
	    FROM partner_links
	    WHERE position $cmp $position
	    ORDER BY position $ord
	    LIMIT 1
	";

	return SQLGet($query,$this->dbh);

    }
    
    function move_link( $id, $move_to='up' ){
	$current_link = $this->get_link( $id );

	if($current_link === false) return false;
	$next_link = $this->get_next_link( $current_link['position'], $move_to);

	if($next_link === false) return false;
	$this->change_link($id,array('position'=>$next_link['position']));				
	$this->change_link($next_link['id'],array('position'=>$current_link['position']));				

	return true;

    }

    function set_stats_link_data($id,$params){
	$params['s_id']=$id;
	SQLInsert("partner_links_stats",$params,$this->dbh);
    }

    function get_next_position(){
	$query = "
	    SELECT MAX(position) as max
	    FROM partner_links
	";
	$row = SQLGet($query,$this->dbh);

	return ($row === false) ? 1 : $row['max'] + 1;
    }

    function get_config_value($name){

	require_once ($GLOBALS['CLASSES_DIR']."Config.class.php");

	$Config = new Config("partner_links_config",$this->dbh);

	return $Config->get_param($name);

    }

    function set_config_value($name,$value){
	require_once ($GLOBALS['CLASSES_DIR']."Config.class.php");

	$Config = new Config("partner_links_config",$this->dbh);

	$Config->set_param($name,$value);
    }
    
}


?>