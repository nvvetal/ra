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

    public function byOwnerGroupedLine($order = 'DESC', $page = 1, $perPage = 10, $perOneUser = 3)
    {
        $cnt = 0;
        if($page < 1) $page = 1;
        if($perPage < 10) $perPage = 10;
        if($perOneUser < 3) $perOneUser = 3;
        $q = "
            SELECT  CONCAT_WS(  '_',  `owner_type` ,  `owner_id` ) as owner,
                FROM_UNIXTIME( created_time ) AS dt,
                MIN( id ) AS min_id, MAX( id ) AS max_id,
                IF( COUNT( CONCAT_WS(  '_',  `owner_type` ,  `owner_id` ) ) >9, 9, COUNT( CONCAT_WS(  '_', `owner_type` ,  `owner_id` ) ) ) AS img_cnt,
                COUNT( CONCAT_WS(  '_',  `owner_type` ,  `owner_id` )) as img_cnt_real
            FROM ".$this->_tableName."
            GROUP BY CONCAT_WS(  '_',  `owner_type` ,  `owner_id` )
            ORDER BY dt ".$order."
            LIMIT 0, ".(100*$perOneUser-1)."
        ";
        $items = SQLGetRows($q, $this->_dbh);
        $total = array(
            'cnt'   => $cnt,
            'items' => array(),
            //'pages' => $perPage > 0 ? ceil($cnt / $perPage) : 0,
            'pages' => 0,
        );
        if(count($items) == 0) return $total;
        //if($cnt == 0) $total['cnt'] = count($items);
        $data = NULL;
        $tot = 0;
        $maxId = 0;
        $lastMinId = 0;
        foreach($items as $item){
            if($tot == 0){
                $minId = $item['min_id'];
                $maxId = $item['max_id'];
            }
            $tot += $item['img_cnt'];
            if($tot >= $perPage) {
                $tot = 0;
                $total['pages']++;
            }
            $lastMinId = $item['min_id'];
            if($page != $total['pages']) continue;
            $data = array(
                'from'  => $lastMinId,
                'to'    => $maxId,
            );
        }
        if(is_null($data) && $page == $total['pages']){
            $data = array(
                'from'  => $lastMinId,
                'to'    => $maxId,
            );
        }
        $q = "
            SELECT *, CONCAT_WS(  '_',  `owner_type` ,  `owner_id` ) as owner
            FROM ".$this->_tableName."
            WHERE id >= {$data['from']} AND {$data['to']} >= id
            ORDER BY id ".$order."
        ";
        $items = SQLGetRows($q, $this->_dbh);
        $prevOwner = '';
        $ownerCnt = 0;
        foreach ($items as $item)
        {
            if($prevOwner != $item['owner']){
                $prevOwner = $item['owner'];
                $ownerCnt++;
            }
            if($perOneUser > 0 && isset($total['items'][$ownerCnt][0]) && count( $total['items'][$ownerCnt]) >= $perOneUser+1) continue;
            $itemObj = new $this->_itemObjName($this->_dbh);
            $itemObj->findById($item['id']);
            $total['items'][$ownerCnt][] = $itemObj;
        }
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