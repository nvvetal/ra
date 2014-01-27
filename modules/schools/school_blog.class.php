<?php

require_once($GLOBALS['CLASSES_DIR']."TableData.class.php");

class school_blog extends TableData {
    
    function school_blog ($table_name,$dbh){
	$this->TableData($table_name,$dbh);
    }

    function get_blogs($school_id){
	$blogs = array();
	
	$query = "
	    SELECT *
	    FROM {$this->table_name}
	    WHERE school_id = ".SQLQuote($school_id)." AND pid = 0
	    ORDER BY created_date DESC
	";

	$rows = SQLGetRows($query,$this->dbh);

	if(!is_array($rows) || count($rows) == 0) return $blogs;

	$i = 0;
	foreach ($rows as $key=>$row){
	    $blogs['childs'][$i] = $row;
	    $blogs['childs'][$i]['childs'] = array();
	    $this->get_blog_child($row['id'],$blogs['childs'][$i]['childs']);
	    if(count($blogs['childs'][$i]['childs']) == 0) unset($blogs['childs'][$i]['childs']);
	    $i++;
	}

//	print_r($blogs);
	return $blogs;
    }    


    function get_blog_child($pid,&$blogs){
	$query = "
	    SELECT *
	    FROM {$this->table_name}
	    WHERE pid = ".SQLQuote($pid)."
	    ORDER BY created_date ASC
	";

	$rows = SQLGetRows($query,$this->dbh);
	if(!is_array($rows) || count($rows) == 0){
	    return ;
	}

	$i = 0;
	foreach ($rows as $key=>$row){
	    $blogs[$i] = $row;
	    $blogs[$i]['childs'] = array();
	    $this->get_blog_child($row['id'],$blogs[$i]['childs']);
	    if(count($blogs[$i]['childs']) == 0) unset($blogs[$i]['childs']);
	    $i++;
	}

	
    }

    function get_blog_message($id){
	
	$message = $this->get_data($id);
	return $message;
    }

    function get_all_messages($page=1,$per_page=30){
	if(empty($page))$page=1;
	if(empty($per_page))$per_page=30;
	$per_page = intval($per_page);
	$begin = ($page-1) * $per_page;
	$query = "
	    SELECT sb.*
	    FROM {$this->table_name} AS sb
	    ORDER BY sb.id DESC
	    LIMIT $begin,$per_page
	";

	return SQLGetRows($query,$this->dbh);
    }

    function get_all_messages_pages($per_page=30){
	if(empty($page))$page=1;
	if(empty($per_page))$per_page=30;

	$per_page = intval($per_page);
	$query = "
	    SELECT COUNT(id) as cnt
	    FROM {$this->table_name}
	";
	$row = SQLGet($query,$this->dbh);
	return isset($row['cnt']) ? ceil($row['cnt'])/$per_page : 0;
    }

    
}


?>