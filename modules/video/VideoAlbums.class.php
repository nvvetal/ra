<?php

class VideoAlbums extends API_List
{
    protected $_itemObjName = 'VideoAlbum';
    
    public function byOwner($ownerType, $ownerId, $order = 'DESC', $page = 1, $perPage = 0, $isDeleted = 0)
    {
        $cnt = 0;
        if($page < 1) $page = 1;
        $andIsDeleted = " AND is_deleted = 'N'";
        if($isDeleted == 1){
            $andIsDeleted = "";
        }
        if($perPage > 0){            
            $q = "
                SELECT COUNT(*) as cnt
                FROM ".$this->_tableName."
                WHERE owner_type = ".SQLQuote($ownerType)." AND owner_id = ".$ownerId.$andIsDeleted."
            ";
            $data = SQLGet($q, $this->_dbh);
            $cnt = isset($data['cnt']) ? $data['cnt'] : 0;
        }          
        $q = "
            SELECT *
            FROM ".$this->_tableName."
            WHERE owner_type = ".SQLQuote($ownerType)." AND owner_id = ".$ownerId.$andIsDeleted."
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
}

?>