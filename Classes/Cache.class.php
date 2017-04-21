<?php
class Cache {
    var $cache_dir = '';

    function __construct($cache_dir){
		$this->cache_dir = $cache_dir;
    }

    function set_cache($data,$fname){

    	umask(0);
    	$f = fopen($this->cache_dir.$fname, 'w');
    	flock($f, LOCK_EX);
    	fwrite($f, serialize($data));
    	flock($f, LOCK_UN);
    	fclose($f);


    	return true;
    }

    function get_cache($fname){
    	if(strlen($fc=@file_get_contents($this->cache_dir.$fname))>16) {
    		return unserialize($fc);
    	};

    	return false;
    }

    function save_family($family_name,$fname){
    	if(empty($family_name)) return false;

    	$family_data = $this->read_family_data($this->cache_dir.$family_name);

    	
    	$family_data[$this->cache_dir.$fname] = time();
    	
    	umask(0);
    	$f = fopen($this->cache_dir.$family_name.".cfam", 'w');
    	flock($f, LOCK_EX);
    	fwrite($f, serialize($family_data));
    	flock($f, LOCK_UN);
    	fclose($f);

    	return true;

    }

    function read_family_data($family_name){
	if(!file_exists($family_name.'.cfam')) return false;
    	if(strlen($fc=file_get_contents($family_name.'.cfam'))>16) {
    		return unserialize($fc);
    	};
    	return false;
    }

    function delete_family($family_name){
    	//echo $this->cache_dir.$family_name;
    	$family_data = $this->read_family_data($this->cache_dir.$family_name);

    	if($family_data !== false){
    		foreach ($family_data as $file_name=>$time){
    			unlink($file_name);
    		}

    		unlink($this->cache_dir.$family_name.'.cfam');
    		return true;
    	}

    	return false;
    }
    
    function is_cache_expired($ttl,$filename){
		$ft = @filemtime($this->cache_dir.$filename)*1;
		if( time() < $ft+$ttl ) {
			return false;
		};

		return true;	
    }

}


?>