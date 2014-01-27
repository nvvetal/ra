<?php

class i18n {

    var $dbh;
    var $module_name = 'i18n_default';
    var $data_dir = '';
    var $translates = false;

    function i18n($data_dir,$dbh){
        $this->dbh = $dbh;
        $this->data_dir = $data_dir;
    }

    function set_module($module_name){
        if(preg_match("/([A-z0-9_]+)/i",$module_name,$match)){
            $this->module_name = 'i18n_'.$match[0];
        }else{
            $this->module_name = 'i18n_default';
        }
    }

    function save_translates($translates,$module){
        require_once($GLOBALS['CLASSES_DIR']."CacheFile.class.php");
        $cache = new CacheFile($this->data_dir);
        $cache->set_file_data($translates,$module,60,'i18n');
    }

    function get_translates($module){
       
        $query = "
	       SELECT *
	       FROM $module
	    ";
        $rows = SQLGetRows($query,$this->dbh);
        if($rows === false || !is_array($rows)) return false;
        $translates = array();
        foreach ($rows as $key=>$data){
            $translates[$data['lang']][$data['name']] = $data['value'];
        }
        return $translates;
    }

    function get_translates_by_lang($lang,$search="*",$search_type="name",$type="all",$page=0,$per_page=30){
        $page = intval($page);
        $per_page = ($per_page < 1) ? 30 : $per_page;
        $cur_page = $page * $per_page;
        if(empty($search) || $search == '*'){
            $search = "%";
        }else{
            $search = str_replace('*','%',$search)."%";
        }
        $and_type = "";
        if($type == "not_translated"){
            $and_type = "AND value LIKE ".SQLQuote('[%]');
        }
        if(!in_array($search_type,array('name','value'))) $search_type = 'name';
        if($search_type == 'value') $search = '%'.$search;

        $query = "
	       SELECT *
	       FROM {$this->module_name}
	       WHERE lang = ".SQLQuote($lang)." AND $search_type LIKE ".SQLQuote($search)." $and_type
	       LIMIT $cur_page,$per_page
	    ";

        return SQLGetRows($query,$this->dbh);
    }

    function get_translates_by_lang_pages($lang,$search="*",$search_type="name",$type="all",$per_page=30){
        $per_page = ($per_page < 1) ? 30 : $per_page;
        if(empty($search) || $search == '*'){
            $search = "%";
        }else{
            $search = str_replace('*','%',$search)."%";
        }
        $and_type = "";
        if($type == "not_translated"){
            $and_type = "AND value LIKE ".SQLQuote('[%]');
        }

        if(!in_array($search_type,array('name','value'))) $search_type = 'name';
        if($search_type == 'value') $search = '%'.$search;

        $query = "
	       SELECT COUNT(*) AS cnt
	       FROM {$this->module_name}
	       WHERE lang = ".SQLQuote($lang)." AND $search_type LIKE ".SQLQuote($search)." $and_type
	       ORDER BY name ASC
	    ";
        $data = SQLGet($query,$this->dbh);
        if($data === false) return false;

        return ceil($data['cnt'] / $per_page);
    }


    function cache_translates($module){
     
        $data = $this->get_translates($module);
        $this->save_translates($data,$module);
        $this->translates[$module] = $data;
        return $data;
    }

    function get_translate($lang,$key,$module=''){
        if(!empty($module)) {
            $module = 'i18n_'.$module;            
        }else{
            $module = $this->module_name;
        }
        if(is_array($this->translates[$module])){
            $data = $this->translates[$module];
        }else{
            require_once($GLOBALS['CLASSES_DIR']."CacheFile.class.php");
            $cache = new CacheFile($this->data_dir);
            $data = $cache->get_file_data($module);
        }
        if($data === false || !is_array($data)){
            $data = $this->cache_translates($module);
        }

        if(!isset($data[$lang][$key])){
            $this->add_translate($module,$lang,$key,"[$key]");
            $data = $this->cache_translates($module);
        }
        return $data[$lang][$key];
    }
    
    

    function get_translate_by_id($id){
        $query = "
	       SELECT *
	       FROM {$this->module_name}
	       WHERE id = ".SQLQuote($id)."
	    ";
        $data = SQLGet($query,$this->dbh);
        if($data === false || !is_array($data)) return false;
        return $data;
    }

    function add_translate($module_name,$lang,$name,$value){
        $fields = array(
            'lang'=>$lang,
            'name'=>$name,
            'value'=>$value,
        );
        SQLInsert($module_name,$fields,$this->dbh);
        return SQLInsId($this->dbh);
    }

    function save_translate($id,$params){
        
        SQLUpdate($this->module_name,$params,"WHERE id=".SQLQuote($id),$this->dbh);
        $this->cache_translates($this->module_name);
    }
    
    function save_translate_by_name($name,$params){
        
        SQLUpdate($this->module_name,$params,"WHERE name=".SQLQuote($name),$this->dbh);
        $this->cache_translates($this->module_name);
    }    

    function delete_translate($id){
       $query = "
	       DELETE FROM {$this->module_name}
	       WHERE id = ".SQLQuote($id)."
	   ";
       SQLQuery($query,$this->dbh);
       $this->cache_translates($this->module_name);
    }

}

?>