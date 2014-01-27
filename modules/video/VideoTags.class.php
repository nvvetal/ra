<?php

class VideoTags extends API_List 
{
    protected $_itemObjName = 'VideoTag';
	
    public function byVideoId($videoId)
    {
        $cnt = 0;

        $q = "
        	SELECT COUNT(*) as cnt
            FROM ".$this->_tableName."
            WHERE videoId = ".SQLQuote($videoId)."
        ";
        $data = SQLGet($q, $this->_dbh);
        $cnt = isset($data['cnt']) ? $data['cnt'] : 0;
        $q = "
            SELECT *
            FROM ".$this->_tableName."
            WHERE videoId = ".SQLQuote($videoId)."
            ORDER BY tag ASC
        ";
        $total = array(
            'cnt'   => $cnt,
            'pages' => 0,
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
	
    public function byWord($word)
    {
        $q = "
            SELECT *
            FROM ".$this->_tableName."
            WHERE tag LIKE ".SQLQuote('%'.$word.'%')."
            ORDER BY tag ASC 
        ";
		$total = array();
        $items = SQLGetRows($q, $this->_dbh);
        if(count($items) == 0) return $total;
        foreach ($items as $item)
        {
            $total[] = $item['tag'];
        }
        return $total;
    }	 
}

?>