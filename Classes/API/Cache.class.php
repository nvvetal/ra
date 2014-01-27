<?php

class API_Cache 
{
    private $_cacheId = NULL;
    public function __construct($name)
    {
        $this->_cacheId = $name;
    }
    
    public function setData($data)
    {
        if(is_null($this->_cacheId)) return false;
        Registry::set($this->_cacheId, $data);
        return true;
    }
    
    public function setPart($name, $value)
    {
        $isExists       = Registry::isRegistered($this->_cacheId);
        if(!$isExists) return false;
        $data           = Registry::get($this->_cacheId);
        $data[$name]    = $value;
        return $this->setData($data);
    }
    
    public function setPartData($data)
    {
        $isExists       = Registry::isRegistered($this->_cacheId);
        if(!$isExists) return false;
        $dataFull       = Registry::get($this->_cacheId);
        foreach ($data as $key=>$value){
            $dataFull[$key] = $value;
        }
        return $this->setData($dataFull);
    }    
    
    public function getData()
    {
        $isExists       = Registry::isRegistered($this->_cacheId);
        if(!$isExists) return NULL;
        return Registry::get($this->_cacheId);
    }
}

?>