<?php

class ActionProcessor {
    private $moduleParams = array();
    private $moduleName;
    private $goName = 'go';
    private $actionName = 'action';
    private $errorPermissionTpl = 'access_denied';
    private $defaultGo = 'index';
    
    public function __construct(  $moduleName, $moduleParams = array() ){    
        $this->moduleName = $moduleName;
        $this->moduleParams = $moduleParams;
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
    
    public function setParam($name,$value){
        $this->moduleParams[$name] = $value;
    }
    
    public function setGoName($name){
        $this->goName = $name;
    }
    
    public function getGoName(){
        return $this->goName;
    }
    
    public function setActionName($name){
        $this->actionName = $name;
    }
    
    public function setDefaultGo($value){
        $this->defaultGo = $value;
    }
    
    private function checkPermission($tpl){
        $permissionRuleFile = $GLOBALS['MODULES_DIR'].$this->moduleName."/".$this->moduleName.'.permissions.class.php';
        $permissionClassName = $this->moduleName."_permissions";
        if(!file_exists($permissionRuleFile)) return true;
        require_once($permissionRuleFile);
        $permissionClass = new $permissionClassName(array(),false);
        if(!method_exists($permissionClass,'get_action_access')) return true;
        $rules = $permissionClass->get_action_access();
        //print_r($rules);exit;
        if(!isset($rules[$tpl])) return true;
        $permissionCb = $rules[$tpl]['permission'];
        $access = $permissionClass->$permissionCb();
        return $access;
    }
    
    private function _processActions(){
        $go = isset( $_REQUEST[$this->goName] ) ? $_REQUEST[$this->goName] : $this->defaultGo;
        $action = isset( $_REQUEST[$this->actionName] ) ? $_REQUEST[$this->actionName] : '';
        $action = $this->_normalizeActionName($action);
        //check permission
        /*
        $haveAccess = $this->checkPermission($go);
        if($haveAccess == false) $go = $this->errorPermissionTpl;
        */
        if( empty($action) /*|| $haveAccess == false */) return array('redirect'=>false,'go'=>$go);
        $actionNode = $GLOBALS['MODULES_DIR'].$this->moduleName."/actions/act.".$action.'.php';
        $cbActionNode = $this->moduleName."Action".ucfirst($action);
        $redirectData = '';
        $this->setParam($this->getGoName(),$go);
        
        try{
            if(!file_exists($actionNode)) 
               throw new Exception("Module ".$this->moduleName." haven't action node ".$actionNode);
            require_once($actionNode);
            if(!function_exists($cbActionNode))
               throw new Exception("Module ".$this->moduleName." haven't function ".$cbActionNode." in ".$actionNode); 
            $actionData = call_user_func($cbActionNode, $this);
            if($actionData['ok'] == false) {
                $go = isset($actionData['go']) ? $actionData['go'] : $go;
                //throw new Exception("Module ".$this->moduleName." function ".$cbActionNode." error: ".$actionData['error']); 
                return array('redirect'=>false,'go'=>$go);
            }
            
            return array('redirect'=>true,'redirectParams'=>$actionData['urlParams']);           
        }catch(Exception $e){
            exception_handler($e);
            return array('redirect'=>false,'go'=>$go);
        }
        
    }
    
    private function _fetchContent($go){
        $templateProcessor = $this->getParam('templator');
        $path = $this->getParam('templatesPath');
        $data = '';
        try{
            $data = $templateProcessor->fetch($path.$go.'.tpl');
        }catch(Exception $e){
            exception_handler($e);
        }
        return $data;
    }
    
    public function showContent(){
        $res = $this->_processActions();
        
        if( $res['redirect'] == false ){    
            $View = new View($this->moduleName,$this->moduleParams);
            $View->setGoName($this->getGoName());
            $View->setParam('templatesPath',$this->getParam('templatesPath'));
            $View->viewContent($res['go']);          
        }
        $urlParams = array();
        if(count($res['redirectParams']) > 0){
            foreach ($res['redirectParams'] as $key=>$value){
                $urlParams[] = "$key=$value";
            }
        }
        $redirectUrl = $GLOBALS['HTTP_PROJECT_ROOT'].$this->moduleName.'/index.php?'.implode('&',$urlParams);
        add_to_log("[action redirect][module ".$this->moduleName."][go ".$res[$this->getGoName()]."][url $redirectUrl]","sitemap");
        header("Location: $redirectUrl");
        exit;
    }
    
    private function _normalizeActionName($name){
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