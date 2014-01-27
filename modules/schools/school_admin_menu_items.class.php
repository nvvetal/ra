<?php

require_once($GLOBALS['CLASSES_DIR'].'MenuItem.class.php');

class school_admin_menu_items extends MenuItem{

    function sachool_admin_menu_items(){
	$this->MenuItem();
    }

    function get_id(){
	return "school";
    }

    function get_name(){
	return "School";
    }

    function get_module(){
	return "schools";
    }

    function init_menu(){
        $this->menu = array(
            'Schools'=>array(
                'id'=>'schools',
                'is_url'=>1,
            ),
            'School Messages'=>array(
                'id'=>'school_messages',
                'childs'=>array(
                    'All messages'=>array(
                        'id'=>'school_messages_all',
                        'is_url'=>1,
                    ),
                    'Deleted Messages'=>array(
                        'id'=>'school_messages_deleted',
                        'is_url'=>1,
                    ),
                ),
            ),
        );
    }

    //PAGES
    function page_default($params){
        require_once($GLOBALS['MODULES_DIR'].$params['module'].'/school.class.php');
        $params['school'] = new school($params['DBFactory']->get_db_handle("rakscom"));
        $params['smarty']->assign('http_module_path',$GLOBALS['HTTP_PROJECT_PATH'].$params['module'].'/');
        $params['smarty']->assign('school',$params['school']);
        $go = !empty($params['ago']) ? $params['ago'] : $params['a_sid'];
        $data = $params['smarty']->fetch($params['template_path'].$go.'.tpl');
        return $data;
    }

    function page_school_messages_all($params){
        require_once($GLOBALS['MODULES_DIR'].$params['module'].'/school.class.php');
        $params['school'] = new school($params['DBFactory']->get_db_handle("rakscom"));
        $params['smarty']->assign('http_module_path',$GLOBALS['HTTP_PROJECT_PATH'].$params['module'].'/');
        $params['smarty']->assign('school',$params['school']);
        require_once($GLOBALS['MODULES_DIR'].$params['module'].'/school_blog.class.php');
        $params['school_blog'] = new school_blog('school_blog',$params['DBFactory']->get_db_handle("rakscom"));
        $params['smarty']->assign('school_blog',$params['school_blog']);
        $go = !empty($params['ago']) ? $params['ago'] : $params['a_sid'];
        $data = $params['smarty']->fetch($params['template_path'].$go.'.tpl');
        return $data;
    }
    //ACTIONS
    function act_edit_school($params){
        require_once($GLOBALS['MODULES_DIR'].$params['module'].'/school.class.php');
        $params['school'] = new school($params['DBFactory']->get_db_handle("rakscom"));
        $school_id = isset($_REQUEST['school_id'])?$_REQUEST['school_id']:"";
        $school = $params['school']->get_school($school_id);
        $user_id = $school['owner_id'];
        $s_params = array(
            "name"=>isset($_REQUEST['name'])?$_REQUEST['name']:"",
            "city_id"=>isset($_REQUEST['city_id'])?$_REQUEST['city_id']:"",
            "url"=>isset($_REQUEST['url'])?$_REQUEST['url']:"",
            "email"=>isset($_REQUEST['email'])?$_REQUEST['email']:"",
            "icq"=>isset($_REQUEST['icq'])?$_REQUEST['icq']:"",
            "skype"=>isset($_REQUEST['skype'])?$_REQUEST['skype']:"",
            "phone_1"=>isset($_REQUEST['phone_1'])?$_REQUEST['phone_1']:"",
            "phone_2"=>isset($_REQUEST['phone_2'])?$_REQUEST['phone_2']:"",
            "address"=>isset($_REQUEST['address'])?$_REQUEST['address']:"",
            "description"=>isset($_REQUEST['description'])?$_REQUEST['description']:"",
            "last_updated_date"=>time(),
        );

    	require_once($GLOBALS['MODULES_DIR'].$params['module'].'/school_container.class.php');
        $school_container_class = new school_container($params['Validator'],$params['school']);
        $res = $school_container_class->call_method_by_id("edit_school",$school_id,$s_params);
        if($school_container_class->is_valid($res) == false){
            $params['smarty']->assign('errors',$school_container_class->get_errors($res));
            $go = "edit_school";
            return $go;
        }
        if(is_uploaded_file($_FILES['school_image_file']['tmp_name'])) {
            $i_ret = $params['Images']->upload_image($_FILES['school_image_file'],$GLOBALS['IMAGE_UPLOAD_ORIGINAL_PATH'],'upload');
            if($i_ret['res'] == true ){
        	   $params['Images']->assign_image($i_ret['ID'],$school_id,'school');
        	   $params['school']->edit_school($school_id,array('image_id'=>$i_ret['ID']));
            }
	   }
	   return $params['ago'];
    }

    function act_delete_school($params){
        $school_id = isset($_REQUEST['school_id'])?$_REQUEST['school_id']:"";
        require_once($GLOBALS['MODULES_DIR'].$params['module'].'/school.class.php');
        $params['school'] = new school($params['DBFactory']->get_db_handle("rakscom"));
        $school = $params['school']->get_school($school_id);
        $params['school']->delete_school($school_id);
    }

    function act_enable_school($params){
        require_once($GLOBALS['MODULES_DIR'].$params['module'].'/school.class.php');
        $params['school'] = new school($params['DBFactory']->get_db_handle("rakscom"));
        $school_id = isset($_REQUEST['school_id'])?$_REQUEST['school_id']:"";
        
        $schoolData = $params['school']->get_school($school_id);
        $fromUserId = $params['Session']->get_value(@$_REQUEST['s'],'user_id');
        $i18n = Registry::get('i18n');
        $subject = $i18n->get_translate(Registry::get('lang'),'School enabled message subject','schools');
        $params['smarty']->assign('school_id',$school_id);
        $message = $params['smarty']->fetch('modules/schools/admin/school_approved_message.tpl');
        $mParams = array(
            'fromUserId' => $fromUserId,
            'toUserId' => $schoolData['owner_id'],
            'subject' => $subject,
            'message' => $message,
        );
        require_once($GLOBALS['CLASSES_DIR'].'Messaging.class.php');
        $Messaging = new Messaging();        
        $Messaging->sendMessage($mParams);        
        
        $params['school']->approve_school($school_id, 1);
    }


    function act_disable_school($params){
        require_once($GLOBALS['MODULES_DIR'].$params['module'].'/school.class.php');
        $params['school'] = new school($params['DBFactory']->get_db_handle("rakscom"));
        $school_id = isset($_REQUEST['school_id'])?$_REQUEST['school_id']:"";
        $reason = isset($_REQUEST['reason'])?$_REQUEST['reason']:"";
        $params['school']->approve_school($school_id, 0);
        $schoolData = $params['school']->get_school($school_id);
        $fromUserId = $params['Session']->get_value(@$_REQUEST['s'],'user_id');
        $i18n = Registry::get('i18n');
        $subject = $i18n->get_translate(Registry::get('lang'),'School disabled message subject','schools');
        $params['smarty']->assign('school_id',$school_id);
        $params['smarty']->assign('reason',$reason);
        $message = $params['smarty']->fetch('modules/schools/admin/school_disabled_message.tpl');
        $mParams = array(
            'fromUserId' => $fromUserId,
            'toUserId' => $schoolData['owner_id'],
            'subject' => $subject,
            'message' => $message,
        );
        require_once($GLOBALS['CLASSES_DIR'].'Messaging.class.php');
        $Messaging = new Messaging();        
        $Messaging->sendMessage($mParams);            
        
    }

    function act_school_top($params){
        require_once($GLOBALS['MODULES_DIR'].$params['module'].'/school.class.php');
        $params['school'] = new school($params['DBFactory']->get_db_handle("rakscom"));
        $school_id = isset($_REQUEST['school_id']) ? $_REQUEST['school_id'] : "";
        $params['school']->set_top($school_id);
    }
	
    function act_school_vip($params){
        require_once($GLOBALS['MODULES_DIR'].$params['module'].'/school.class.php');
        $params['school'] = new school($params['DBFactory']->get_db_handle("rakscom"));
        $school_id = isset($_REQUEST['school_id']) ? $_REQUEST['school_id'] : "";
        $params['school']->set_vip($school_id);
    }
	
}

?>