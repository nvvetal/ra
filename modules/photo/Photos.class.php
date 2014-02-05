<?php

class Photos extends API_List 
{
    protected $_itemObjName = 'Photo';
    
    public function byOwner($ownerType, $ownerId, $albumId, $order = 'DESC', $page = 1, $perPage = 0)
    {
        $cnt = 0;
        if($page < 1) $page = 1;
        if($perPage > 0){            
            $q = "
                SELECT COUNT(*) as cnt
                FROM ".$this->_tableName."
                WHERE owner_type = ".SQLQuote($ownerType)." AND owner_id = ".$ownerId." AND album_id = ".SQLQuote($albumId)."
            ";
            $data = SQLGet($q, $this->_dbh);
            $cnt = isset($data['cnt']) ? $data['cnt'] : 0;
        }          
        $q = "
            SELECT *
            FROM ".$this->_tableName."
            WHERE owner_type = ".SQLQuote($ownerType)." AND owner_id = ".$ownerId." AND album_id = ".SQLQuote($albumId)."
            ORDER BY created_time ".$order."
        ";
        if($perPage > 0){
            $q .= "LIMIT ".(($page-1)*$perPage).",".$perPage; 
        }        
        $total = array(
            'cnt'   => $cnt,
            'pages' => $perPage > 0 ? ceil($cnt / $perPage) : 0,
            'items' => array(),
        );        
        $items = SQLGetRows($q, $this->_dbh);
        if(count($items) == 0) return $total;
        foreach ($items as $item)
        {
            $itemObj = new $this->_itemObjName($this->_dbh);
            $itemObj->findById($item['id']);
            $total['items'][] = $itemObj;
        }
        return $total;
    }

    public function byOwnerGroupedLine($order = 'DESC', $page = 0, $perPage = 0, $perOneUser = 0)
    {
        $cnt = 0;
        if($page < 1) $page = 1;
        if($perPage > 0){
            $q = "
                SELECT COUNT(*) as cnt
                FROM ".$this->_tableName."
            ";
            $data = SQLGet($q, $this->_dbh);
            $cnt = isset($data['cnt']) ? $data['cnt'] : 0;
        }
        $q = "
            SELECT *
            FROM ".$this->_tableName."
            ORDER BY created_time ".$order."
        ";
        if($perPage > 0){
//            $q .= "LIMIT ".(($page-1)*$perPage).",".$perPage;
        }
        $items = SQLGetRows($q, $this->_dbh);
        $total = array(
            'cnt'   => $cnt,
            'items' => array(),
            //'pages' => $perPage > 0 ? ceil($cnt / $perPage) : 0,
            'pages' => 0,
        );
        if(count($items) == 0) return $total;
        if($cnt == 0) $total['cnt'] = count($items);
        $prevOwner = array(
            'ownerId'   => 0,
            'ownerType' => 0,
        );
        $ownerCnt = 0;
        foreach ($items as $item)
        {
            if($prevOwner['ownerId'] <> $item['owner_id']
                || $prevOwner['ownerType'] <> $item['owner_type'])
            {
                $prevOwner['ownerId']   = $item['owner_id'];
                $prevOwner['ownerType'] = $item['owner_type'];
                $ownerCnt++;
            }
            if($perOneUser > 0 && isset($total['items'][$ownerCnt][0]) && count( $total['items'][$ownerCnt]) >= $perOneUser+1) continue;
            $itemObj = new $this->_itemObjName($this->_dbh);
            $itemObj->findById($item['id']);
            $total['items'][$ownerCnt][] = $itemObj;
        }
        $itemsCnt = 0;
        foreach($total['items'] as $items){
            $itemsCnt += count($items);
        }
        $total['pages'] = $perPage > 0 ? ceil($itemsCnt / $perPage) : 0;
        return $total;
    }
    
    public function getRandomPhoto()
    {
        $itemObj = false;
        try {
            $q = "
                SELECT *
                FROM ".$this->_tableName."
                ORDER BY RAND()
                LIMIT 1 
            ";
            $data = SQLGet($q, $this->_dbh);
            if(!is_array($data)) return false;
            $itemObj = new $this->_itemObjName($this->_dbh);
            $itemObj->findById($data['id']);        
        }catch(Exception $e){
            exception_handler($e);
        }
        return $itemObj;
    }
    
    public function getMaxRatedPhoto()
    {
        $itemObj = false;
        try {
            $q = "
                SELECT p.*
                FROM ".$this->_tableName." as p, rates_agr as r
                WHERE p.id = r.rateToId AND r.rateToType = 'photo'
                ORDER BY r.rateAvg DESC, r.ratePoints DESC
                LIMIT 1 
            ";
            $data = SQLGet($q, $this->_dbh);
            if(!is_array($data)) return false;
            $itemObj = new $this->_itemObjName($this->_dbh);
            $itemObj->findById($data['id']);        
        }catch(Exception $e){
            exception_handler($e);
        }
        return $itemObj;        
    }
    
    public function getPhotoOfDay()
    {
        $itemObj = false;
        $beginDate  = date('Y-m-d H:i:s', strtotime('-1 day'));
        $endDate    = date('Y-m-d H:i:s');
        try {
            $q = "
                SELECT p.*, SUM(r.ratePoints) as s
                FROM ".$this->_tableName." as p, rates as r
                WHERE p.id = r.rateToId AND r.rateToType = 'photo' 
                    AND FROM_UNIXTIME(r.rateTime) BETWEEN '$beginDate' AND '$endDate'
                GROUP BY r.rateToId
                ORDER BY s DESC
                LIMIT 1 
            ";
            $data = SQLGet($q, $this->_dbh);
            if(!is_array($data)) return false;
            $itemObj = new $this->_itemObjName($this->_dbh);
            $itemObj->findById($data['id']);        
        }catch(Exception $e){
            exception_handler($e);
        }
        return $itemObj;        
    }    
}

?>