<?php

class View
{
    private $moduleParams = array();
    private $moduleName;
    private $goName = 'go';
    private $errorPermissionTpl = 'access_denied';
        
    public function __construct($moduleName, $moduleParams = array()){
        $this->moduleName = $moduleName;
        $this->moduleParams = $moduleParams;        
    }
    
    public function setGoName($name){
        $this->goName = $name;
    }
    
    public function getGoName(){
        return $this->goName;
    }    
    
    public function viewContent($go){
//      $haveAccess = $this->checkPermission($go);
//      if($haveAccess == false) $go = $this->errorPermissionTpl;
        //$UserMapper = Registry::get('UserMapper');
        add_to_log("[action view][module ".$this->moduleName."][go ".$go."]","sitemap");
        echo $this->_fetchContent($go);
        exit;         
    }
    
    private function checkPermission($go){
        $permissionRuleFile = $GLOBALS['MODULES_DIR'].$this->moduleName."/".$this->moduleName.'.permissions.class.php';
        $permissionClassName = $this->moduleName."_permissions";
        if(!file_exists($permissionRuleFile)) return true;
        require_once($permissionRuleFile);
        $permissionClass = new $permissionClassName(array(),false);
        if(!method_exists($permissionClass,'get_page_access')) return true;
        $rules = $permissionClass->get_page_access();
        if(!isset($rules[$go])) return true;
        $permissionCb = $rules[$go]['permission'];
        $access = $permissionClass->$permissionCb();
        return $access;
    } 
    
    private function _fetchContent($go){
        $contentData = $this->_viewFetch($go);
        $templateProcessor = Registry::get('templator');
        $path = $this->getParam('templatesPath');
        $data = '';
        try{
            $filePath = $path.$go.'.tpl';
            $realFilePath = $templateProcessor->template_dir.$filePath;
            if(!is_readable($realFilePath)) throw new Exception('Cannot fetch page '.$realFilePath);
            if(count($contentData) > 0){
                foreach ($contentData as $key=>$value){
                    $templateProcessor->assign($key,$value);
                }
            }
            $data = $templateProcessor->fetch($filePath);
        }catch(Exception $e){
            exception_handler($e);
        }
        return $data;
    }    
    
    
    public function setParam($name,$value){
        $this->moduleParams[$name] = $value;
    }
    
    public function getParam($name){
        $value = false;
        try {
            if(!isset($this->moduleParams[$name])) 
                throw new Exception("Module ".$this->moduleName." haven't object parameter $name");
            $value = $this->moduleParams[$name];           
        }catch(Exception $e){
            exception_handler($e);
        }        
        return $value;
    } 
    
    
    private function _viewFetch($go){
        $params = array();
        try {
            $view = $this->_normalizeViewName($go);
            $fileName = $GLOBALS['MODULES_DIR'].$this->moduleName."/views/view.".$view.'.php';
            if(!is_readable($fileName)) throw new Exception('Cannot find view file '.$fileName);
            require_once($fileName);
            $viewName = $this->moduleName.'View'.$view;
            if(!function_exists($viewName)) throw new Exception('Cannot find vie function '.$viewName.' in '.$fileName);
            $params = $viewName($this);
        }catch(Exception $e){
            exception_handler($e);
        }
        return $params;
    }    
    
    private function _normalizeViewName($name){
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