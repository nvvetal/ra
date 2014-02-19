<?php
class ShopUserItems extends API_List
{
    protected $_itemObjName = 'ShopUserItem';

    public function getGoodsByUser($userId, $orderBy, $page = 1, $perPage = 0)
    {
        $cnt = 0;
        if($page < 1) $page = 1;
        if($perPage > 0){
            $q = "
                SELECT COUNT(*) as cnt
                FROM ".$this->_tableName."
                WHERE to_user_id = ".SQLQuote($userId)."
            ";
            $data = SQLGet($q, $this->_dbh);
            $cnt = isset($data['cnt']) ? $data['cnt'] : 0;
        }
        //echo $cnt;
        $q = "
            SELECT *
            FROM ".$this->_tableName."
            WHERE to_user_id = ".SQLQuote($userId)."
            ORDER BY $orderBy
        ";
        if($perPage > 0){
            $q .= "LIMIT ".(($page-1)*$perPage).",".$perPage;
        }
        //echo $q;
        $total = array(
            'cnt'   => $cnt,
            'pages' => $perPage > 0 ? ceil($cnt / $perPage) : 0,
            'items' => array(),
        );
        $items = SQLGetRows($q, $this->_dbh);
        if(count($items) == 0) return $total;
        $i = 0;
        foreach ($items as $item)
        {
            $itemObj = new ShopGood($this->_dbh);
            $giftItemObj = new ShopUserItem($this->_dbh);
            $itemObj->findById($item['item_id']);
            $giftItemObj->findById($item['id']);
            $total['items'][$i]['good'] = $itemObj;
            $total['items'][$i]['giftItem'] = $giftItemObj;
            $i++;
        }
        //echo "<pre>";
        //var_dump($total['items']);
        return $total;
    }

    public function getUserNewGiftsCount($userId, $maxPeriodSecs)
    {
        $q = "
            SELECT COUNT(*) as cnt
            FROM ".$this->_tableName."
            WHERE to_user_id = ".SQLQuote($userId)." AND (saw_time > ".SQLQuote(time() - $maxPeriodSecs)." OR saw_time = 0)
        ";
        //echo $q;
        $data = SQLGet($q, $this->_dbh);
        return $cnt = isset($data['cnt']) ? $data['cnt'] : 0;
    }

}
