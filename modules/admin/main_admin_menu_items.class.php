<?php

require_once($GLOBALS['CLASSES_DIR'].'MenuItem.class.php');

class main_admin_menu_items extends MenuItem{

    function main_admin_menu_items(){
        $this->MenuItem();
    }

    function get_id(){
        return "main";
    }

    function get_name(){
        return "Main";
    }

    function get_module(){
        return "admin";
    }

    function init_menu(){
        $this->menu = array(
            'Main Page' => array(
                'id'    => 'main_page',
                'is_url'    => 1,
            ),
            'Partners Page' => array(
                'id'    => 'partners_page',
                'is_url'    => 1,
            ),
            'Users'=>array(
                'id'=>'users_all',
                'is_url'=>1,
            ),
            'Config'=>array(
                'id'=>'main_config',
                'is_url'=>1,
            ),            
            'Translate'=>array(
                'id'=>'translate',
                'childs'=>array(
                    'I18N'=>array(
                        'id'=>'i18n',
                        'type'=>'function',
                        'method'=>'get_i18n_tables',
                        'is_url'=>1,
                        'url_params'=>array(
                            'menu_item_id'=>'id',
                            'menu_item_name'=>'name',
                        ),
                    ),
                ),
            ),
            'Cities'=>array(
                'id'=>'city',
                'is_url'=>1,
            ),
            'Log'=>array(
                'id'=>'log',
                'is_url'=>1,
            ),            
            'Admin Menu Order'=>array(
                'id'=>'admin_menu_order',
                'is_url'=>1,
            ),
        );
    }

    //CALLBACKS
    function cb_get_image_types($params){
        return array(
            '0'=>array(
                'id'=>'user',
                'name'=>'User (5)',
            ),
            '1'=>array(
                'id'=>'school',
                'name'=>'School (2)',
            ),
            '2'=>array(
                'id'=>'calendar',
                'name'=>'Calendar (0)',
            ),
        );
    }

    function cb_get_i18n_tables($params){
        $dbh = Registry::get('DBFactory')->get_db_handle("rakscom");
        $query = "
	       SHOW tables
	       LIKE 'i18n_%'
        ";
        $rows = SQLGetRows($query,$dbh);
        
        if(!is_array($rows) || count($rows) == 0) return array();
        foreach ($rows as $key=>$row){
            $row['name'] = isset($row["Tables_in_rakscom (i18n_%)"]) ? $row["Tables_in_rakscom (i18n_%)"] : $row["Tables_in_raks_portal (i18n_%)"];
            $name = substr($row['name'],strlen('i18n_'),strlen($row['name'])-strlen('i18n_'));
            $rows[$key]['id'] = $name;
            $rows[$key]['name'] = $name;
        }
        //var_dump($rows);
        return $rows;
    }


    //PAGES

    function page_default($params){
        if(preg_match("/^i18n\_/i",$params['a_sid'])) return $this->page_i18n($params);
        if($params['a_sid'] == 'log') return $this->page_log($params);
        $go = !empty($params['ago']) ? $params['ago'] : $params['a_sid'];
        $data = $params['smarty']->fetch($params['template_path'].$go.'.tpl');
        return $data;
    }

    function page_i18n($params){
        require_once($GLOBALS['CLASSES_DIR'].'i18n.class.php');
        $params['i18n_admin'] = new i18n($GLOBALS['I18N_CACHE_PATH'],$params['DBFactory']->get_db_handle("rakscom"));
        if(preg_match("/^i18n\_([A-z0-9]+)/i",$params['a_sid'],$m)){
            $module = $m[1];
        }else{
            $module = "default";
        }
        $params['i18n_admin']->set_module($module);
        $params['smarty']->assign('i18n_admin',$params['i18n_admin']);
        $params['smarty']->assign('i18n_module',$module);

        $go = !empty($params['ago']) ? $params['ago'] : 'i18n';
        $data = $params['smarty']->fetch($params['template_path'].$go.'.tpl');
        return $data;
    }
    
    function page_log($params){
        require_once('lib_admin.php');
        $year = isset($_REQUEST['dateYear']) ? $_REQUEST['dateYear']: date('Y');
        $month = isset($_REQUEST['dateMonth']) ? $_REQUEST['dateMonth']: date('m');
        $day = isset($_REQUEST['dateDay']) ? $_REQUEST['dateDay']: date('d');
        $logs = get_admin_logs($year,$month,$day);
        $params['smarty']->assign('logs',$logs);
        $params['smarty']->assign('request_time',strtotime(sprintf("%04d-%02d-%02d",$year,$month,$day)));

        $go = !empty($params['ago']) ? $params['ago'] : 'log';
        $data = $params['smarty']->fetch($params['template_path'].$go.'.tpl');
        return $data;
    }

    //ACTIONS

    function act_user_save($params){
        require_once($GLOBALS['CLASSES_DIR']."User_container.class.php");
        $user_container_class = new User_container($params['Validator'],$params['User']);
        $p_params = array(
            'p_sex' => @$_REQUEST['p_sex'],
            'p_first_name' => @$_REQUEST['p_first_name'],
            'p_last_name' => @$_REQUEST['p_last_name'],
            'p_from_location' => @$_REQUEST['p_from_location'],
            'p_birthday' => sprintf("%04d-%02d-%02d",@$_REQUEST['p_birthday_Year'],@$_REQUEST['p_birthday_Month'],@$_REQUEST['p_birthday_Day']),
            'p_profession' => @$_REQUEST['p_profession'],
            'p_hobby' => @$_REQUEST['p_hobby'],
            'p_url' => @$_REQUEST['p_url'],
            'p_icq' => @$_REQUEST['p_icq'],
            'p_skype' => @$_REQUEST['p_skype'],
            'email' => @$_REQUEST['email'],
            'state' => @$_REQUEST['state'],
            'type' => @$_REQUEST['type'],
        );

        $user_id = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : '';

        if(empty($user_id) || !is_numeric($user_id)){
            $params['smarty']->assign('errors',array(array('message'=>'Unknown user!')));
            return $params['ago'];
        }

        if(is_uploaded_file($_FILES['p_avatar_file']['tmp_name'])) {
            $i_ret = $params['Images']->upload_image($_FILES['p_avatar_file'],$GLOBALS['IMAGE_UPLOAD_ORIGINAL_PATH'],'upload');
            if($i_ret['res'] == true ){
                $params['Images']->assign_image($i_ret['ID'],$user_id,'user');
                $params['User']->set_value($user_id,'image_id',$i_ret['ID']);
            }else{
                $params['smarty']->assign('errors',array(array("message"=>"Cannot upload image - not valid!")));
            }
        }
        $v_result = $user_container_class->validate_params("my_profile_save",$p_params);
        if($user_container_class->is_valid($v_result)){
            $params['User']->set_values($user_id,$p_params);
        }else{
            $params['smarty']->assign('errors',$user_container_class->get_errors($v_result));
        }

        return $params['ago'];
    }

    function act_user_delete($params){
        $user_id = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : '';
        $params['User']->delete_user($user_id);

        return $params['ago'];
    }

    function act_i18n_save_key($params){
        require_once($GLOBALS['CLASSES_DIR'].'i18n.class.php');
        $params['i18n_admin'] = new i18n($GLOBALS['I18N_CACHE_PATH'],$params['DBFactory']->get_db_handle("rakscom"));
        if(preg_match("/^i18n\_([A-z0-9]+)/i",$params['a_sid'],$m)){
            $module = $m[1];
        }else{
            $module = "default";
        }
        $params['i18n_admin']->set_module($module);

        require_once($GLOBALS['MODULES_DIR'].$params['module'].'/i18n_container.class.php');
        $i18n_container_class = new i18n_container($params['Validator'],$params['i18n_admin']);
        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';

        $s_params = array(
            'value'=>(isset($_REQUEST['value'])) ? $_REQUEST['value'] : '',
        );
        //var_dump($_REQUEST['value']);exit;
        $res = $i18n_container_class->call_method_by_id("save_translate",$id,$s_params);
        if($i18n_container_class->is_valid($res) == false){
            $params['smarty']->assign('errors',$i18n_container_class->get_errors($res));
            $go = "i18n_edit_key";
            return $go;
        }

        return $params['ago'];
    }

    function act_set_partners_page($params)
    {
        require_once($GLOBALS['CLASSES_DIR'].'i18n.class.php');
        $params['i18n_admin'] = new i18n($GLOBALS['I18N_CACHE_PATH'],$params['DBFactory']->get_db_handle("rakscom"));
        $module = "default";
        $params['i18n_admin']->set_module($module);
        require_once($GLOBALS['MODULES_DIR'].$params['module'].'/i18n_container.class.php');
        $i18n_container_class = new i18n_container($params['Validator'],$params['i18n_admin']);
        $_REQUEST['partners_page_content'] = str_replace('<img src="../i/', '<img src="'.$GLOBALS['HTTP_IMAGES_PATH'], stripslashes($_REQUEST['partners_page_content']));
        $s_params = array(
            'value'=>(isset($_REQUEST['partners_page_content'])) ? $_REQUEST['partners_page_content'] : '',
        );
        $res = $i18n_container_class->call_method_by_id("save_translate_by_name", 'Partners Page Content', $s_params);
        return $params['ago'];
    }


    function act_set_main_page($params)
    {
        require_once($GLOBALS['CLASSES_DIR'].'i18n.class.php');
        $params['i18n_admin'] = new i18n($GLOBALS['I18N_CACHE_PATH'],$params['DBFactory']->get_db_handle("rakscom"));
        $module = "default";
        $params['i18n_admin']->set_module($module);
        require_once($GLOBALS['MODULES_DIR'].$params['module'].'/i18n_container.class.php');
        $i18n_container_class = new i18n_container($params['Validator'],$params['i18n_admin']);
	    $_REQUEST['main_page_content'] = str_replace('<img src="../i/', '<img src="'.$GLOBALS['HTTP_IMAGES_PATH'], stripslashes($_REQUEST['main_page_content']));
        $s_params = array(
            'value'=>(isset($_REQUEST['main_page_content'])) ? $_REQUEST['main_page_content'] : '',
        );        
        $res = $i18n_container_class->call_method_by_id("save_translate_by_name", 'Main Page Content', $s_params);
        return $params['ago'];               
    }

    function act_i18n_delete($params){
        require_once($GLOBALS['CLASSES_DIR'].'i18n.class.php');
        $params['i18n_admin'] = new i18n($GLOBALS['I18N_CACHE_PATH'],$params['DBFactory']->get_db_handle("rakscom"));
        if(preg_match("/^i18n\_([A-z0-9]+)/i",$params['a_sid'],$m)){
            $module = $m[1];
        }else{
            $module = "default";
        }
        $params['i18n_admin']->set_module($module);
        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';
        $params['i18n_admin']->delete_translate($id);
        return $params['ago'];
    }
    
    function act_country_add($params){
        require_once($GLOBALS['CLASSES_DIR'].'Geo.class.php');
        $Geo = new Geo($params['DBFactory']->get_db_handle("rakscom"));
        
        $name = isset($_REQUEST['name']) ? $_REQUEST['name'] : '';
        $short_name = isset($_REQUEST['short_name']) ? $_REQUEST['short_name'] : '';
        
        if(empty($name) || empty($short_name)){
            $params['smarty']->assign('errors',array(array("message"=>"Name is empty!")));
            $go = "country_add";
            return $go;            
        }
        $isExists = $Geo->is_country_name_exists(0,$name,$short_name);
        if($isExists){
            $params['smarty']->assign('errors',array(array("message"=>"Country exists!")));
            $go = "country_add";
            return $go;                                
        }
        $c_params = array(
            'name'=>$name,
            'short_name'=>$short_name,
        );
        $country_id = $Geo->add_country($c_params);
        $_REQUEST['country_id'] = $country_id;
        $go = "country_edit";
        return $go;        
    }
    
    function act_country_edit($params){
        require_once($GLOBALS['CLASSES_DIR'].'Geo.class.php');
        $Geo = new Geo($params['DBFactory']->get_db_handle("rakscom"));
        
        $country_id = isset($_REQUEST['country_id']) ? $_REQUEST['country_id'] : '';
        $name = isset($_REQUEST['name']) ? $_REQUEST['name'] : '';
        $short_name = isset($_REQUEST['short_name']) ? $_REQUEST['short_name'] : '';
        
        if(empty($name) || empty($short_name)){
            $params['smarty']->assign('errors',array(array("message"=>"Name is empty!")));
            $go = "country_edit";
            return $go;            
        }
        $isExists = $Geo->is_country_name_exists($country_id,$name,$short_name);
        if($isExists){
            $params['smarty']->assign('errors',array(array("message"=>"Other country exists with this name!")));
            $go = "country_edit";
            return $go;                                
        }
        $c_params = array(
            'name'=>$name,
            'short_name'=>$short_name,
        );
        $country_id = $Geo->set_country($country_id,$c_params);
        $go = "country_edit";
        return $go;        
    }  
    
    function act_country_delete($params){
        require_once($GLOBALS['CLASSES_DIR'].'Geo.class.php');
        $Geo = new Geo($params['DBFactory']->get_db_handle("rakscom"));
        
        $country_id = isset($_REQUEST['country_id']) ? $_REQUEST['country_id'] : '';

        $Geo->delete_country($country_id);
        $go = "city";
        return $go;                 
    }
    
    function act_city_add($params){
        require_once($GLOBALS['CLASSES_DIR'].'Geo.class.php');
        $Geo = new Geo($params['DBFactory']->get_db_handle("rakscom"));
        
        $name = isset($_REQUEST['name']) ? $_REQUEST['name'] : '';
        $country_id = isset($_REQUEST['country_id']) ? $_REQUEST['country_id'] : '';
        $subdivision_id = isset($_REQUEST['subdivision_id']) ? $_REQUEST['subdivision_id'] : '';

        if(empty($subdivision_id)){
            $params['smarty']->assign('errors',array(array("message"=>"Please select subdivision!")));
            $go = "city_add";
            return $go;              
        }        
        
        if(empty($name)){
            $params['smarty']->assign('errors',array(array("message"=>"Name is empty!")));
            $go = "city_add";
            return $go;            
        }       
        
        $isExists = $Geo->is_city_name_exists(0,$country_id,$name);
        if($isExists){
            $params['smarty']->assign('errors',array(array("message"=>"City exists!")));
            $go = "city_add";
            return $go;                                
        }
        $c_params = array(
            'name'=>$name,
            'country_id'=>$country_id,
            'subdivision_id'=>$subdivision_id,
        );
        $city_id = $Geo->add_city($c_params);
        $_REQUEST['city_id'] = $city_id;
        $go = "city_edit";
        return $go;        
    }   
    
    function act_city_edit($params){
        require_once($GLOBALS['CLASSES_DIR'].'Geo.class.php');
        $Geo = new Geo($params['DBFactory']->get_db_handle("rakscom"));
        $city_id = isset($_REQUEST['city_id']) ? $_REQUEST['city_id'] : '';
        $country_id = isset($_REQUEST['country_id']) ? $_REQUEST['country_id'] : '';
        $subdivision_id = isset($_REQUEST['subdivision_id']) ? $_REQUEST['subdivision_id'] : '';
        $name = isset($_REQUEST['name']) ? $_REQUEST['name'] : '';
        
        if(empty($subdivision_id)){
            $params['smarty']->assign('errors',array(array("message"=>"Please select subdivision!")));
            $go = "city_edit";
            return $go;              
        }
        
        if(empty($name)){
            $params['smarty']->assign('errors',array(array("message"=>"Name is empty!")));
            $go = "city_edit";
            return $go;            
        }
        $isExists = $Geo->is_city_name_exists($city_id,$country_id,$name);
        if($isExists){
            $params['smarty']->assign('errors',array(array("message"=>"Other city exists with this name!")));
            $go = "city_edit";
            return $go;                                
        }
        $c_params = array(
            'name'=>$name,
            'country_id'=>$country_id,
            'subdivision_id'=>$subdivision_id,
        );
        $country_id = $Geo->set_city($city_id,$c_params);
        $go = "city_edit";
        return $go;        
    } 

    function act_city_delete($params){
        require_once($GLOBALS['CLASSES_DIR'].'Geo.class.php');
        $Geo = new Geo($params['DBFactory']->get_db_handle("rakscom"));
        
        $city_id = isset($_REQUEST['city_id']) ? $_REQUEST['city_id'] : '';

        $Geo->delete_city($city_id);
        $go = "city";
        return $go;                 
    }      
    
    function act_country_subdivision_add($params){
        require_once($GLOBALS['CLASSES_DIR'].'Geo.class.php');
        $Geo = new Geo($params['DBFactory']->get_db_handle("rakscom"));
        
        $name = isset($_REQUEST['name']) ? $_REQUEST['name'] : '';
        $country_id = isset($_REQUEST['country_id']) ? $_REQUEST['country_id'] : '';

        if(empty($country_id)){
            $params['smarty']->assign('errors',array(array("message"=>"Please select country!")));
            $go = "country_subdivision_add";
            return $go;              
        }        
        
        if(empty($name)){
            $params['smarty']->assign('errors',array(array("message"=>"Name is empty!")));
            $go = "country_subdivision_add";
            return $go;            
        }       
        
        $isExists = $Geo->is_subdivision_name_exists(0,$country_id,$name);
        if($isExists){
            $params['smarty']->assign('errors',array(array("message"=>"Subdivision exists!")));
            $go = "country_subdivision_add";
            return $go;                                
        }
        $s_params = array(
            'name'=>$name,
            'country_id'=>$country_id,
        );
        $subdivision_id = $Geo->add_subdivision($s_params);
        $_REQUEST['subdivision_id'] = $subdivision_id;
        $go = "country_subdivision_edit";
        return $go;        
    }   
    
    function act_country_subdivision_edit($params){
        require_once($GLOBALS['CLASSES_DIR'].'Geo.class.php');
        $Geo = new Geo($params['DBFactory']->get_db_handle("rakscom"));
        $country_id = isset($_REQUEST['country_id']) ? $_REQUEST['country_id'] : '';
        $subdivision_id = isset($_REQUEST['subdivision_id']) ? $_REQUEST['subdivision_id'] : '';
        $name = isset($_REQUEST['name']) ? $_REQUEST['name'] : '';
        
        if(empty($subdivision_id)){
            $params['smarty']->assign('errors',array(array("message"=>"Please select subdivision!")));
            $go = "country_subdivision_edit";
            return $go;              
        }
        
        if(empty($name)){
            $params['smarty']->assign('errors',array(array("message"=>"Name is empty!")));
            $go = "country_subdivision_edit";
            return $go;            
        }
        $isExists = $Geo->is_subdivision_name_exists($subdivision_id,$country_id,$name);
        if($isExists){
            $params['smarty']->assign('errors',array(array("message"=>"Subdivision exists!")));
            $go = "country_subdivision_edit";
            return $go;                                
        }
        $s_params = array(
            'name'=>$name,
            'country_id'=>$country_id,
        );
        $country_id = $Geo->set_subdivision($subdivision_id,$s_params);
        $go = "country_subdivision_edit";
        return $go;        
    } 

    function act_country_subdivision_delete($params){
        require_once($GLOBALS['CLASSES_DIR'].'Geo.class.php');
        $Geo = new Geo($params['DBFactory']->get_db_handle("rakscom"));
        
        $subdivision_id = isset($_REQUEST['subdivision_id']) ? $_REQUEST['subdivision_id'] : '';

        $Geo->delete_subdivision($subdivision_id);
        $go = "city";
        return $go;                 
    }

    function act_set_config($params){
        $configData = isset($_REQUEST['config']) ? $_REQUEST['config'] : '';
        if(!is_array($configData) || count($configData) == 0) return $params['ago'];
        $Config = Registry::get('Config');
        foreach ($configData as $name=>$value){
            $Config->set_param($name,$value);
        }
        return $params['ago'];               
    } 
	
    function act_set_main_page_photos($params)
    {
        $Images = Registry::get('Images');
        $res = $Images->upload_image($_FILES['file'], $GLOBALS['IMAGE_UPLOAD_ORIGINAL_PATH'], 'upload');
        //add_to_log(var_export($res,true),'1');
		if($res != true) {
			 die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
		}
		$Images->assign_image($res['ID'], 0, 'main_page');	
		$url = $GLOBALS['HTTP_IMAGES_PATH'].$Images->get_image_url_center_square($res['ID'], 300, 'jpg');
		die('{"jsonrpc" : "2.0", "result" : null, "id" : "id", "photoUrl" : "'.$url.'"}');
    }	      
     
}

?>