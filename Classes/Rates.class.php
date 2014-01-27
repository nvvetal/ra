<?php

class Rates extends API_List
{
    protected $_itemObjName = 'Rate';
    
    public function getLastRateByFrom($rateToId, $rateToType, $rateFromId, $rateFromType)
    {
        $itemObj = false;
        try {
            $q = "
                SELECT *
                FROM ".$this->_tableName."
                WHERE rateToId = ".SQLQuote($rateToId)." AND rateToType = ".SQLQuote($rateToType)."
                    AND rateFromId = ".SQLQuote($rateFromId)." AND rateFromType = ".SQLQuote($rateFromType)."
                ORDER BY rateTime DESC
                LIMIT 1
            ";
            $item = SQLGet($q, $this->_dbh);
            if(!is_array($item)) return $itemObj;
            $itemObj = new $this->_itemObjName($this->_dbh);
            $itemObj->findById($item['id']);        
        }catch (Exception $e){
            exception_handler($e);
        }
        return $itemObj;
    }
    
}

?>