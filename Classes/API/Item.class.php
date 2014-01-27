<?php
require_once('Cache.class.php');

class API_Item {
    protected $_itemData  = NULL;
    protected $_isDelete  = true;
    protected $_itemTable = NULL;
    protected $_cache     = NULL;
    protected $_dbh       = NULL;

    protected $_objects   = array();

    public function __construct($dbh){
        $this->_dbh     = $dbh;
    }

    protected function _initCache($itemId)
    {
        if(!is_null($this->_cache)) return true;
        $this->_cache = new API_Cache('API_Item_'.$this->_itemTable.'_'.$itemId);
        return true;
    }

    public function __get($name)
    {
        if(!is_null($this->_itemData) && array_key_exists($name, $this->_itemData))
            return $this->_itemData[$name];
        return NULL;
    }

    public function __set($name, $value)
    {
        if($name == 'data') $this->_save($value);
        $data = array(
            $name => $value,
        );
        $this->_save($data);
    }

    public function findById($itemId)
    {
        $this->_initCache($itemId);
        $data = $this->_cache->getData();
        if(!is_null($data)) {
            $this->_itemData = $data;
            return true;
        }
        $q = "
            SELECT *
            FROM ".$this->_itemTable."
            WHERE id = ".SQLQuote($itemId)."
            LIMIT 1
        ";
        $data = SQLGet($q, $this->_dbh);
        if($data !== false) {
            $this->_cache->setData($data);
            $this->_itemData = $data;
            return true;
        }
        return false;
    }

    public function findByParam($param, $value)
    {

        $q = "
            SELECT *
            FROM ".$this->_itemTable."
            WHERE `$param` = ".SQLQuote($value)."
            LIMIT 1
        ";
        $data = SQLGet($q, $this->_dbh);
        if($data !== false) {
            $this->_initCache($data['id']);
            $this->_cache->setData($data);
            $this->_itemData = $data;
            return true;
        }
        return false;
    }

    private function _save($data)
    {
        //TODO: validation
        if(is_null($this->_itemData)) return array('ok' => false);
        $saved = SQLUpdate($this->_itemTable, $data, "WHERE id = ".SQLQuote($this->id), $this->_dbh);
        if($saved > 0) $this->_cache->setPartData($data);
        return array('ok' => true);
    }

    public function create($data)
    {
        //TODO: validation
        $itemId = SQLInsert($this->_itemTable, $data, $this->_dbh);
        $this->findById($itemId);
        return array('ok' => true, 'id' => $itemId);
    }

    public function delete()
    {
        if(is_null($this->_itemData)) return array('ok' => false);
        if(!$this->_isDelete) {
            $this->is_deleted = "Y";
            return array('ok' => true);
        }
        $q = "DELETE FROM ".$this->_itemTable." WHERE id = ".SQLQuote($this->id);
        SQLQuery($q, $this->_dbh);
        return array('ok' => true);
    }

    public function restore()
    {
        if(is_null($this->_itemData) || !$this->_isDelete) return array('ok' => false);
        $this->is_deleted = "N";
        return array('ok' => true);
    }

    public function getTableName()
    {
        return $this->_itemTable;
    }

    public function assignObj($key, $obj)
    {
        //var_dump($this->_objects[$key]);
        $this->_objects[$key] = $obj;
    }

    public function getObj($key)
    {

        return isset($this->_objects[$key]) ? $this->_objects[$key] : false;
    }
}

?>