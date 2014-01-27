<?php

//require_once('mysql.php');

class rating {
    var $dbh;
    var $rating_names=array();
    var $rating_groups=array();
    
    var $default_value = 1;
    
    var $rules = array();
    

    function rating ( $rules, $dbh ){
        $this->rules = $rules;
        $this->dbh = $dbh;
        $this->rating_names = $this->get_rating_names();
    }
    
    function get_rule_value($name){
    	return isset($this->rules[$name]) ? $this->rules[$name] : $this->default_value;
    }
    
    function set_rule_value ($name,$value){
    	$this->rules[$name] = $value;
    }
    
    function set_rules($rules){
    	$this->rules = $rules;
    }

    function add_rating_value($item_id,$name,$additional_info=array()){
        
        $rating_id = $this->get_rating_id($name);
        
        $value = $this->get_rule_value($name);
        
        $value_setted = $this->get_rating_value($item_id,$name);
        
        if($value_setted == 0){
        	$query = "
        		INSERT INTO rating_values
        		(rating_id,item_id,value)
        		VALUES ('$rating_id','$item_id',$value)
        	";	
        }else{
        
        	$query = "
        		UPDATE rating_values
        		SET value = value + $value
        		WHERE item_id = '$item_id' AND rating_id = '$rating_id'
        	";
        }
        
        SQLQuery($query,$this->dbh);
        
        $this->add_history($rating_id,$item_id,$value,'add',$additional_info);    
    }
    
    function delete_rating_value($item_id,$name,$additional_info=array()){
        $rating_id = $this->get_rating_id($name);
        
        $value = $this->get_rule_value($name);
        
        $query = "
        	UPDATE rating_values
        	SET value = value - $value
        	WHERE item_id = '$item_id' AND rating_id = '$rating_id'
        ";
        
        
        SQLQuery($query,$this->dbh);
        
        $this->add_history($rating_id,$item_id,$value,'delete',$additional_info);            	
    }

    function add_rating_name($name){
        $fields=array(
        	"name"=>$name,
        );
        
        SQLInsert("ratings",$fields,$this->dbh);
        
        return SQLInsId($this->dbh);
    }

    function add_history($rating_id,$item_id,$value,$action,$additional_info=array()){
        $fields=array(
        	"rating_id" => $rating_id,
        	"item_id" => $item_id,
        	"time_add" => mktime(),
        	"action" => $action,
        	"value" => $value,
        );
        
        SQLInsert("rating_history",$fields,$this->dbh);
        
        $history_id = SQLInsId($this->dbh);
        
        add_to_log("[history_id $history_id][rating_id $rating_id][item_id $item_id][value $value]","rating_$action");
        
        return $history_id;       
    }

    function get_rating_value($item_id,$name){
		$rating_id = $this->get_rating_id($name);
    	
    	
    	$query="
			SELECT *
			FROM rating_values
			WHERE item_id = '$item_id' AND rating_id = '$rating_id'
			LIMIT 1
		";
    	
    	$row = SQLGet($query,$this->dbh);
    	
    	return isset( $row["value"] ) ? $row["value"] : 0;
    }

    function get_rating_total_by_name( $name ){
		$rating_id = $this->get_rating_id( $name );
    	
    	
    	$query="
			SELECT SUM(value) AS value
			FROM rating_values
			WHERE rating_id = '$rating_id'
		";
    	
    	$row = SQLGet($query,$this->dbh);
    	
    	return isset( $row["value"] ) ? $row["value"] : 0;
    }

    function get_rating_total_by_names( $rating_names=array() ){

        $ids = $this->get_ids_by_names($rating_names);
        $ids_s = $this->get_ids_string($ids);
        
    	$query="
			SELECT SUM(value) AS value
			FROM rating_values
			WHERE rating_id IN ($ids_s)
		";
    	
    	$row = SQLGet($query,$this->dbh);
    	
    	return isset( $row["value"] ) ? $row["value"] : 0;        
        
    }
    
    function get_ids_string($ids){
    	$ids_s = implode( ",", $ids );
    	
    	return $ids_s;
    }
    
    function get_ids_by_names($rating_names){
        $ids = array();
    	
    	foreach ($rating_names as $key=>$value){
        	$ids[] = $this->get_rating_id( $value );
        }
        
        return $ids;   	
    }

    function set_rating_group($name,$rating_names){
        $ids = get_ids_by_names($rating_names);
        
        $this->rating_groups[$name]=$ids;
    }

    function get_rating_by_group($item_id,$name){

        $ids_s = $this->get_ids_string($this->rating_groups[$name]);
        
    	$query="
			SELECT SUM(value) AS value
			FROM rating_values
			WHERE item_id = '$item_id' AND rating_id IN ($ids_s)
		";
    	
    	$row = SQLGet($query,$this->dbh);
    	
    	return isset( $row["value"] ) ? $row["value"] : 0;         
    }
    
 

    function get_rating_names(){
    	$query="
    		SELECT *
    		FROM ratings
    	";
    	
    	$rows = SQLGetRows($query,$this->dbh);
    	$rating_names = array();
    	
    	if(count($rows)==0) return $rating_names;
    	//print_r($rows);
    	foreach ($rows as $key=>$rating){
    		$rating_names[$rating["name"]]=$rating["id"];
    	}
    	
    	
        return $rating_names;
    }

    function get_rating_id($name){
        if(isset($this->rating_names[$name])) return $this->rating_names[$name];

        $new_id = $this->add_rating_name($name);
        $this->rating_names = $this->get_rating_names();
        return $new_id;    
    }

}

?>