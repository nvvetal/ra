<?php

class admin_menu{
    var $dbh;
    var $menu_dir;
    var $menu_classes = array();
    var $menu_items = array();

    function admin_menu($menu_dir,$dbh){
        $this->dbh = $dbh;
        $this->menu_dir = $menu_dir;
    }

    //searchin recursive [module_name]_admin_menu_item.class.php
    function parse_menu_classes($additional_dir = ''){
        $dir = $additional_dir != '' ? $additional_dir : $this->menu_dir;
        if (is_dir($dir) == false) return false;
        
        if ($dh = opendir($dir)) {
            while (($file = readdir($dh)) !== false) {
               
                if(@filetype($dir . $file) == 'dir' && $file != '.' && $file != '..'){
                   // echo $dir.'-'.$file;exit; 
                    $this->parse_menu_classes($dir.$file);
                }
                if(preg_match("/((\w+admin_menu_items).class.php)/i",$file,$m)){

                    $this->menu_classes[]=array(
                        'class_name'=>$m[2],
                        'class_file'=>$m[1],
                        'class_dir'=>$dir,
                    );
                }
            }
        }
        closedir($dh);
    }

    function prepare_menu($params,$main_id,$selected_id){
        foreach ($this->menu_classes as $key=>$menu_main_item){
            if(!file_exists($menu_main_item['class_dir'].'/'.$menu_main_item['class_file'])){
                add_to_log("[error file is not exists][class_name {$menu_main_item['class_name']}][class_file {$menu_main_item['class_file']}][class_dir {$menu_main_item['class_dir']}]","error_admin_menu");
                continue;
            }
            require_once($menu_main_item['class_dir'].'/'.$menu_main_item['class_file']);
            $menu = new $menu_main_item['class_name']();
            $menu_name = $menu->get_name();
            if(isset($this->menu_items[$menu_name])){
                add_to_log("[error menu name exists][name $menu_name][class_name {$menu_main_item['class_name']}][class_file {$menu_main_item['class_file']}][class_dir {$menu_main_item['class_dir']}]","error_admin_menu");
                continue;
            }
            $menu_selected_id = 0;
            if($main_id == $menu->get_id()){
                $menu_selected_id = $selected_id;
            }

            $this->menu_items[$menu_name]=array(
                'id'=>$menu->get_id(),
                'name'=>$menu_name,
                'class'=>$menu_main_item['class_dir'].'/'.$menu_main_item['class_file'],
                'menu_obj'=>$menu,
                'childs'=>$menu->generate_menu($params,$menu_selected_id),
            );
        }
    }

    function get_menu(&$params, $main_id, $selected_id){
        $this->parse_menu_classes();
        //print_r($this->menu_classes);exit;
        $this->prepare_menu($params,$main_id,$selected_id);

        return $this->menu_items;
    }

    function get_menu_obj_by_id($a_id){
        if(!is_array($this->menu_items) || count($this->menu_items) == 0) return false;

        foreach ($this->menu_items as $item){
            if($item['id'] == $a_id){
                return $item['menu_obj'];
            }
        }
        return false;
    }

    function page_dispatcher($params){
        $action_name = 'page_'.$params['a_sid'];
        $action_name_default = 'page_default';

        if(method_exists($params['menu_obj'],$action_name)){
            return $params['menu_obj']->$action_name($params);
        }elseif(method_exists($params['menu_obj'],$action_name_default)){
            return $params['menu_obj']->$action_name_default($params);
        }
        return false;
    }

    function event_dispatcher($params){
        $action_name = 'act_'.$params['action'];

        if(method_exists($params['menu_obj'],$action_name)){
            
            $ret = $params['menu_obj']->$action_name($params);
            $this->save_action_log($params,$ret);
            return $ret;
        }
        return $params['ago'];
    }
    
    function save_action_log($params,$ret){
        $data = array(
            'time_created'  => time(),
            'module'        => $params['module'],
            'action'        => $params['action'],
            'user_id'       => $params['Session']->get_value(@$_REQUEST['s'],'user_id'),
            'send_data'     => serialize($_REQUEST),
            'return_data'   => serialize($ret),
        );
        SQLInsert('admin_logs',$data,$this->dbh);
        add_to_log(prepare_array_to_log($data),'admin_log');
        
    }

}

?>