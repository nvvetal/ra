<?php

class Videos extends API_List 
{
    protected $_itemObjName = 'Video';
    
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

	public function byOwnerGroupedLine($order = 'DESC', $page = 0, $perPage = 0)
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
			$q .= "LIMIT ".(($page-1)*$perPage).",".$perPage;
		}
		$items = SQLGetRows($q, $this->_dbh);
		$total = array(
			'cnt'   => $cnt,
			'items' => array(),
			'pages' => $perPage > 0 ? ceil($cnt / $perPage) : 0,
		);
		if(count($items) == 0) return $total;
		if($cnt == 0) $total['cnt'] = count($items);
		$prevOwner = array(
			'ownerId'   => 0,
			'ownerType' => 0,
		);
		$lines = array();
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
			$itemObj = new $this->_itemObjName($this->_dbh);
			$itemObj->findById($item['id']);
			$total['items'][$ownerCnt][] = $itemObj;
		}
		return $total;
	}

    
    public function getRandomVideo()
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
    
    public function getMaxRatedVideo()
    {
        $itemObj = false;
        try {
            $q = "
                SELECT p.*
                FROM ".$this->_tableName." as p, rates_agr as r
                WHERE p.id = r.rateToId AND r.rateToType = 'video'
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
    
    public function getVideoOfDay()
    {
        $itemObj = false;
        $beginDate  = date('Y-m-d H:i:s', strtotime('-1 day'));
        $endDate    = date('Y-m-d H:i:s');
        try {
            $q = "
                SELECT p.*, SUM(r.ratePoints) as s
                FROM ".$this->_tableName." as p, rates as r
                WHERE p.id = r.rateToId AND r.rateToType = 'video' 
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
	
	public function searchGlobal($search, $page, $perPage = 10)
	{
		$tags = explode(' ', $search);
        $tagsIn = array();
        foreach($tags as $tag){
            $tagsIn[] = 'tag LIKE '.SQLQuote('%'.$tag.'%');
        }
        $cnt = 0;
        if($page < 1) $page = 1;
        if($perPage > 0){            
            $q = "
                SELECT COUNT(*) as cnt
				FROM ".$this->_tableName."
				WHERE name LIKE ".SQLQuote('%'.$search.'%')." OR description LIKE ".SQLQuote('%'.$search.'%')." 
					OR id IN (SELECT videoId FROM video_tags WHERE ".implode(' OR ', $tagsIn).")
            ";
            $data = SQLGet($q, $this->_dbh);
            $cnt = isset($data['cnt']) ? $data['cnt'] : 0;
        }          
        $q = "
            SELECT *
			FROM ".$this->_tableName."
			WHERE name LIKE ".SQLQuote('%'.$search.'%')." OR description LIKE ".SQLQuote('%'.$search.'%')." 
				OR id IN (SELECT videoId FROM video_tags WHERE ".implode(' OR ', $tagsIn).")
			ORDER BY name ASC
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
}

?>