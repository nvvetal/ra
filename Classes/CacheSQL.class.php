<?php

require_once('Cache.class.php');

class CacheSQL extends Cache{
	var $dbh;

	function CacheSQL($cache_dir,$dbh){
		$this->dbh = $dbh;
		$this->cache_dir = $cache_dir;

	}


	function SQLRowCached($query,$tag,$ttl,$family_tag=''){
		$cache_name = $tag.'.csql';
		
		
		if(!$this->is_cache_expired($ttl,$cache_name)){
			return $this->get_cache($cache_name);
		}

		$tr = SQLGet($query, $this->dbh);


		$this->set_cache($tr,$cache_name);
		$this->save_family($family_tag,$cache_name);
		return $tr;
	}


	function SQLRowsCached($query,$tag,$ttl,$family_tag=''){
		$cache_name = $tag.'.csql';
		
		if(!$this->is_cache_expired($ttl,$cache_name)){
			return $this->get_cache($cache_name);
		}

		$tr = SQLGetRows($query, $this->dbh);

		$this->set_cache($tr,$cache_name);
		$this->save_family($family_tag,$cache_name);
		return $tr;
	}


}

?>