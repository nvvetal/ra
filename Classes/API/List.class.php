<?php

class API_List {
    protected $_dbh         = NULL;
    protected $_itemObj     = NULL;
    protected $_itemObjName = NULL;
    protected $_tableName   = NULL;

    public function __construct($dbh)
    {
        $this->_dbh         = $dbh;
        $this->_itemObj     = new $this->_itemObjName($dbh);
        $this->_tableName   = $this->_itemObj->getTableName();
    }

    public function allCount()
    {
        $items = $this->all();
        return $items['cnt'];
    }

    public function all($page = 1, $perPage = 0, $orderBy = 'id ASC')
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
            ORDER BY ".$orderBy."
        ";
        if($perPage > 0){
            $q .= "LIMIT ".(($page-1)*$perPage).",".$perPage;
        }
        $items = SQLGetRows($q, $this->_dbh);
        $total = $this->prepareTotal($items, $perPage, $cnt);
        return $total;
    }

    public function byTime($order = 'DESC', $page = 1, $perPage = 0, $params = array())
    {
        $cnt = 0;
        if($page < 1) $page = 1;
        $where = array();
        if(isset($params['enabled']) && $params['enabled'] == true){
            $where[] = "is_enabled = 'Y'";
        }
        if($perPage > 0){
            $q = "
                SELECT COUNT(*) as cnt
                FROM ".$this->_tableName."
            ";
            if(count($where) > 0){
                $q .= "
                    WHERE ".implode(" AND ", $where)."
                ";
            }
            $data = SQLGet($q, $this->_dbh);
            $cnt = isset($data['cnt']) ? $data['cnt'] : 0;
        }
        $q = "
            SELECT *
            FROM ".$this->_tableName."
        ";
        if(count($where) > 0){
            $q .= "
                    WHERE ".implode(" AND ", $where)."
                ";
        }
        $q .= "
            ORDER BY created_time ".$order."
        ";
        if($perPage > 0){
            $q .= "LIMIT ".(($page-1)*$perPage).",".$perPage;
        }
        $items = SQLGetRows($q, $this->_dbh);
        $total = $this->prepareTotal($items, $perPage, $cnt);
        return $total;
    }

    public function byParentAndTime($parentKey, $parentValue, $order = 'DESC', $page = 1, $perPage = 0)
    {
        $cnt = 0;
        if($page < 1) $page = 1;
        if($perPage > 0){
            $q = "
                SELECT COUNT(*) as cnt
                FROM ".$this->_tableName."
                WHERE $parentKey = ".SQLQuote($parentValue)."
            ";
            $data = SQLGet($q, $this->_dbh);
            $cnt = isset($data['cnt']) ? $data['cnt'] : 0;
        }
        $q = "
            SELECT *
            FROM ".$this->_tableName."
            WHERE $parentKey = ".SQLQuote($parentValue)."
            ORDER BY created_time ".$order."
        ";
        if($perPage > 0){
            $q .= "LIMIT ".(($page-1)*$perPage).",".$perPage;
        }
        $items = SQLGetRows($q, $this->_dbh);
        $total = $this->prepareTotal($items, $perPage, $cnt);
        return $total;
    }

    public function byParent($parentKey, $parentValue, $sortBy, $order = 'DESC', $page = 1, $perPage = 0)
    {
        $cnt = 0;
        if($page < 1) $page = 1;
        if($perPage > 0){
            $q = "
                SELECT COUNT(*) as cnt
                FROM ".$this->_tableName."
                WHERE $parentKey = ".SQLQuote($parentValue)."
            ";
            $data = SQLGet($q, $this->_dbh);
            $cnt = isset($data['cnt']) ? $data['cnt'] : 0;
        }
        $q = "
            SELECT *
            FROM ".$this->_tableName."
            WHERE $parentKey = ".SQLQuote($parentValue)."
            ORDER BY $sortBy ".$order."
        ";
        if($perPage > 0){
            $q .= "LIMIT ".(($page-1)*$perPage).",".$perPage;
        }
        $items = SQLGetRows($q, $this->_dbh);
        $total = $this->prepareTotal($items, $perPage, $cnt);
        return $total;
    }

    public function getMaxRated($type, $page = 1, $perPage = 0, $params = array())
    {
        $cnt = 0;
        if($page < 1) $page = 1;
        $total = $this->prepareTotal(array(), $perPage, 0);
        $where = array(
            "p.id" => "r.rateToId",
            "r.rateToType" => SQLQuote($type),
        );
        if(isset($params['enabled']) && $params['enabled'] == true){
            $where[] = "p.is_enabled = 'Y'";
        }
        try {
            if($perPage > 0){
                $q = "
                    SELECT COUNT(*) as cnt
                    FROM ".$this->_tableName." as p, rates_agr as r
                ";
                if(count($where) > 0){
                    $q .= "
                        WHERE ".implode(" AND ", $where)."
                    ";
                }
                $data = SQLGet($q, $this->_dbh);
                $cnt = isset($data['cnt']) ? $data['cnt'] : 0;
            }
            $q = "
                SELECT p.*
                FROM ".$this->_tableName." as p, rates_agr as r

            ";
            if(count($where) > 0){
                $q .= "
                    WHERE ".implode(" AND ", $where)."
                ";
            }
            $q .= "
                ORDER BY r.rateAvg DESC, r.ratePoints DESC
            ";
            if($perPage > 0){
                $q .= "LIMIT ".(($page-1)*$perPage).",".$perPage;
            }
            $items = SQLGetRows($q, $this->_dbh);
            $total = $this->prepareTotal($items, $perPage, $cnt);
        }catch(Exception $e){
            exception_handler($e);
        }
        return $total;
    }

    protected function prepareTotal($items, $perPage, $totalAmount)
    {
        $cnt = count($items);
        $total = array(
            'cnt'   => $cnt,
            'pages' => $perPage > 0 ? ceil($totalAmount / $perPage) : 0,
            'items' => array(),
        );
        if($cnt == 0) return $total;

        if($cnt == 0) $total['cnt'] = count($items);
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