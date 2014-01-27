<?php


class TableData{

    var $dbh;
    var $table_name;

    function TableData($table_name,$dbh){
	$this->dbh = $dbh;
	$this->table_name = $table_name;
    }


    function prepare_uniq_params($uniq_params){
	$where = 'WHERE ';
	if(is_array($uniq_params)){
	

	    foreach ($uniq_params as $name=>$value){
		$where .= "($name=".SQLQuote($value).") AND ";
	    }

	    $where = substr($where,0,strlen($where)-5);
    
	}else{
	    $where .= "id=".SQLQuote($uniq_params);
	}

	return $where;

    }

    function prepare_order_params($order_params){
	if(!is_array($order_params) || count($order_params) == 0) return '';

	$order = "ORDER BY ";

	foreach ($order_params as $key=>$value){
	    $order .= "$key $value,";	    
	}

	$order = substr($order,0,strlen($order)-1);

	return $order;
    }


    function add_data($params){
	SQLInsert($this->table_name,$params,$this->dbh);

	return SQLInsId($this->dbh);
    }

    function set_data($uniq_params,$params,$type='update'){

	$where = $this->prepare_uniq_params($uniq_params);

	if($type == 'update'){
	    return SQLUpdate($this->table_name,$params,$where,$this->dbh);
	}
    }

    function get_data($uniq_params,$order_params=array(),$type='one',$limit="1",$params=array()){
	$where = $this->prepare_uniq_params($uniq_params);
	$order = $this->prepare_order_params($order_params);

	$query = "
	    SELECT *
	    FROM ".$this->table_name."
	    $where
	    $order
	    LIMIT $limit
	";

	if($type == 'one'){
	    $row = SQLGet($query,$this->dbh);

	    return $row;

	}else{
	    $rows = SQLGetRows($query,$this->dbh);

	    return $rows;
	}

    }

    function delete_data($uniq_params){
	$where = $this->prepare_uniq_params($uniq_params); 

	$query="DELETE FROM ".$this->table_name." $where";

	return SQLQuery($query,$this->dbh);
    }

}


?>