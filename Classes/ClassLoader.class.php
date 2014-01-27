<?php

class ClassLoader {
    
    function loadModuleClass($className,$moduleName){
        $module_name = $moduleName;
        $path = $GLOBALS['MODULES_DIR'].$moduleName.'/';
        if(file_exists($path.'loadModels.php')){
            require_once($path.'loadModels.php');
        }
        $classFile = $path.$className.'.class.php';
        if(!file_exists($classFile)) return false;
        require_once($classFile);
        $DBFactory = Registry::get('DBFactory');
        if($moduleName == 'forum'){
            $class = new $className($DBFactory->get_db_handle('forum'));
        }else{
             $class = new $className($DBFactory->get_db_handle('rakscom'));
        }
        return $class;        
    }
    
    public function autoLoad($class){
        if(class_exists($class,false)) return true;
        //try autoload classes
        $isLoad = $this->_autoLoadClassesClass($class);
        if($isLoad) return $isLoad;             

        $isLoad = $this->_autoLoadAPI($class);
        if($isLoad) return $isLoad;
        //try autoload module classes 
        $isLoad = $this->_autoLoadModuleClass($class);
        if($isLoad) return $isLoad;               
    }
    
    private function _autoLoadClassesClass($class){
        $file = $GLOBALS['CLASSES_DIR'].$class.'.class.php';
        if(!is_readable($file)) return false;   
        require_once($file);
        return true;        
    }
    
    private function _autoLoadModuleClass($class)
    {
        if(!Registry::isRegistered('module')) return false;
        $module = Registry::get('module');
        if(empty($module)) return false;
        $file = $GLOBALS['MODULES_DIR'].$module.'/'.$class.'.class.php';
        if(!is_readable($file)) return false;        
        require_once($file);
        return true;
    }
    
    private function _autoLoadAPI($class)
    {
        if(substr($class, 0, 3) != "API") return false;
        $file = $GLOBALS['CLASSES_DIR'].'API/'.substr($class, 4).'.class.php';
        if(!is_readable($file)) return false;   
        require_once($file);
        return true;         
    }

    
    private function _normalizeModuleName($name){
        if(!preg_match("/_/i",$name)) return ucfirst($name);
        $data = explode("_",$name);
        $newName = '';
        foreach ($data as $val){
            $newName .= ucfirst($val);
        }
        return $newName;
    }         
    
}


?>