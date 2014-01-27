<?php

class blog_firm {
	var $dbh; 
	
	function blog_firm ($dbh){

		$this->dbh = $dbh;
	}
	
	function add_blog($params){

		
		SQLInsert("blog_firm",$params,$this->dbh);
		
		return SQLInsId($this->dbh);
	}
	
	
}

?>