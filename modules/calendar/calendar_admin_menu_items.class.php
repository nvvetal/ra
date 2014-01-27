<?php

require_once($GLOBALS['CLASSES_DIR'].'MenuItem.class.php');

class calendar_admin_menu_items extends MenuItem{

    function calendar_admin_menu_items(){
        $this->MenuItem();
    }

    function get_id(){
        return "calendar";
    }

    function get_name(){
        return "Calendar";
    }

    function get_module(){
        return "calendar";
    }

    function init_menu(){
        $this->menu = array(
            'Calendars Not Approved'=>array(
                'id'=>'calendars_not',
                'is_url'=>1,
            ),        
            'Calendars'=>array(
                'id'=>'calendars',
                'is_url'=>1,
            ),
            'Calendar Categories'=>array(
                'id'=>'calendar_categories',
                'is_url'=>1,
            ),            
        );
    }


    //PAGES
    function page_default($params){
        require_once($GLOBALS['MODULES_DIR'].$params['module'].'/calendar.class.php');
        require_once($GLOBALS['MODULES_DIR'].$params['module'].'/calendar_forum.class.php');
        $params['calendar'] = new calendar($params['DBFactory']->get_db_handle("rakscom"));
        $params['calendar_forum'] = new calendar_forum();
        $params['smarty']->assign('calendar',$params['calendar']);
        $params['smarty']->assign('calendar_forum',$params['calendar_forum']);
        $go = !empty($params['ago']) ? $params['ago'] : $params['a_sid'];
        $data = $params['smarty']->fetch($params['template_path'].$go.'.tpl');
        return $data;
    }    
    
    //CALLBACKS
    function act_calendar_category_add($params){
        require_once($GLOBALS['MODULES_DIR'].$params['module'].'/calendar.class.php');
        $calendar = new calendar($params['DBFactory']->get_db_handle("rakscom"));
        
        $name = isset($_REQUEST['name']) ? $_REQUEST['name'] : '';
        $forum_id = isset($_REQUEST['forum_id']) ? $_REQUEST['forum_id'] : '';
        if(empty($name)){
            $params['smarty']->assign('errors',array(array("message"=>"Name is empty!")));
            $go = "calendar_category_add";
            return $go;            
        }
        $isExists = $calendar->is_category_name_exists(0,$name);
        if($isExists){
            $params['smarty']->assign('errors',array(array("message"=>"Calendar category exists!")));
            $go = "calendar_category_add";
            return $go;                                
        }
        $c_params = array(
            'name'=>$name,
            'forum_id'  => $forum_id,            
        );
        $category_id = $calendar->add_category($c_params);
        $_REQUEST['category_id'] = $category_id;
        $go = "calendar_category_edit";
        return $go;        
    }
    
    function act_calendar_category_edit($params){
        require_once($GLOBALS['MODULES_DIR'].$params['module'].'/calendar.class.php');
       
        $calendar = new calendar($params['DBFactory']->get_db_handle("rakscom"));
        
        $category_id = isset($_REQUEST['category_id']) ? $_REQUEST['category_id'] : '';
        $name = isset($_REQUEST['name']) ? $_REQUEST['name'] : '';
        $forum_id = isset($_REQUEST['forum_id']) ? $_REQUEST['forum_id'] : '';

        if(empty($name)){
            $params['smarty']->assign('errors',array(array("message"=>"Name is empty!")));
            $go = "calendar_category_edit";
            return $go;            
        }
        $isExists = $calendar->is_category_name_exists($category_id,$name);
        if($isExists){
            $params['smarty']->assign('errors',array(array("message"=>"Other calendar category exists with this name!")));
            $go = "calendar_category_edit";
            return $go;                                
        }
        $c_params = array(
            'name'      => $name,
            'forum_id'  => $forum_id,
        );
        $calendar->set_category($category_id,$c_params);
        $go = "calendar_category_edit";
        return $go;        
    }  
    
    function act_calendar_category_delete($params){
        require_once($GLOBALS['MODULES_DIR'].$params['module'].'/calendar.class.php');
        $calendar = new calendar($params['DBFactory']->get_db_handle("rakscom"));        
        $category_id = isset($_REQUEST['category_id']) ? $_REQUEST['category_id'] : '';
        $calendar->delete_category($category_id);
        $go = "calendar_categories";
        return $go;
    }

    function act_calendar_approve($params){
        require_once($GLOBALS['MODULES_DIR'].$params['module'].'/calendar.class.php');
        $calendar = new calendar($params['DBFactory']->get_db_handle("rakscom"));        
        $calendar_id = isset($_REQUEST['calendar_id']) ? $_REQUEST['calendar_id'] : '';
        $calendar->approve_calendar($calendar_id);
        
        $fromUserId = $params['Session']->get_value(@$_REQUEST['s'],'user_id');
        $i18n = Registry::get('i18n');
        $subject = $i18n->get_translate(Registry::get('lang'),'Calendar approved message subject','calendar');
        $params['smarty']->assign('calendar_id',$calendar_id);
        $message = $params['smarty']->fetch('modules/calendar/admin/calendar_approved_message.tpl');
        $mParams = array(
            'fromUserId' => $fromUserId,
            'toUserId' => $calendar_data['creator_id'],
            'subject' => $subject,
            'message' => $message,
        );
        require_once($GLOBALS['CLASSES_DIR'].'Messaging.class.php');
        $Messaging = new Messaging();        
        $Messaging->sendMessage($mParams);
        
        return $params['ago'];                
    }             

    function act_calendar_disable($params){
        require_once($GLOBALS['MODULES_DIR'].$params['module'].'/calendar.class.php');
        $calendar = new calendar($params['DBFactory']->get_db_handle("rakscom"));        
        $calendar_id = isset($_REQUEST['calendar_id']) ? intval($_REQUEST['calendar_id']) : '';
        $reason = isset($_REQUEST['reason']) ? $_REQUEST['reason'] : '';
        $calendar_data = $calendar->get_calendar($calendar_id);        
        $calendar->disable_calendar($calendar_id);        

        $fromUserId = $params['Session']->get_value(@$_REQUEST['s'],'user_id');
        $i18n = Registry::get('i18n');
        $subject = $i18n->get_translate(Registry::get('lang'),'Calendar disabled message subject','calendar');
        $params['smarty']->assign('reason',$reason);
        $params['smarty']->assign('calendar_id',$calendar_id);
        $message = $params['smarty']->fetch('modules/calendar/admin/calendar_disabled_message.tpl');
        $mParams = array(
            'fromUserId' => $fromUserId,
            'toUserId' => $calendar_data['creator_id'],
            'subject' => $subject,
            'message' => $message,
        );
        require_once($GLOBALS['CLASSES_DIR'].'Messaging.class.php');
        $Messaging = new Messaging();        
        $Messaging->sendMessage($mParams);        
        return $params['ago'];                   
    }
    
    function act_calendar_delete($params){
        require_once($GLOBALS['MODULES_DIR'].$params['module'].'/calendar.class.php');
        $calendar = new calendar($params['DBFactory']->get_db_handle("rakscom"));
        
        $calendar_id = isset($_REQUEST['calendar_id']) ? $_REQUEST['calendar_id'] : '';

        $calendar_data = $calendar->get_calendar($calendar_id);
        require_once($GLOBALS['MODULES_DIR'].$params['module'].'/calendar_forum.class.php');
        $calendarForum = new calendar_forum();
        $topicId = $calendar_data['forum_topic_id'];
        $calendarForum->deleteTopic($topicId);
        $calendar->delete_calendar($calendar_id);
        
        return $params['ago'];                
    }            
    
}

?>