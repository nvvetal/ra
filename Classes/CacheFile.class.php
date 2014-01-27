<?php

require_once($GLOBALS['CLASSES_DIR']."Cache.class.php");

class CacheFile extends Cache{
	
	function CacheFile($cache_dir){
		$this->cache_dir = $cache_dir;
	}
	
	function is_file_actual($tag,$ttl){
		$cache_name = $tag.'.cfile';
		
		if($this->is_cache_expired($ttl,$cache_name)){
			return false;
		}
		
		return true;
		
	}
	
	function set_file_data($data,$tag,$ttl,$family_tag=''){
		$cache_name = $tag.'.cfile';

		$this->set_cache($data,$cache_name);
		$this->save_family($family_tag,$cache_name);
	}
	
	
	function get_file_data($tag){
		$cache_name = $tag.'.cfile';
		
		return $this->get_cache($cache_name);	
	}
	
}



?>