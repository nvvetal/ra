<?php
class Articles extends API_List
{
    protected $_itemObjName = 'Article';

    public function sortByAuthor($order = 'DESC', $page = 1, $perPage = 0)
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
            SELECT a.*
            FROM ".$this->_tableName." as a, users as u
            WHERE a.owner_id = u.user_id
            ORDER BY u.login ".$order."
        ";
        if($perPage > 0){
            $q .= "LIMIT ".(($page-1)*$perPage).",".$perPage;
        }
        $items = SQLGetRows($q, $this->_dbh);
        $total = $this->prepareTotal($items, $perPage, $cnt);
        return $total;
    }

    public function sortByName($order = 'DESC', $page = 1, $perPage = 0)
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
            SELECT a.*
            FROM ".$this->_tableName." as a
            ORDER BY a.name ".$order."
        ";
        if($perPage > 0){
            $q .= "LIMIT ".(($page-1)*$perPage).",".$perPage;
        }
        $items = SQLGetRows($q, $this->_dbh);
        $total = $this->prepareTotal($items, $perPage, $cnt);
        return $total;
    }

    public function sortByParams($params)
    {
        $cnt = 0;
        $page = isset($params['page']) ? (int) $params['page'] : 1;
        $perPage = isset($params['perPage']) ? (int) $params['perPage'] : 0;
        $order = isset($params['order']) ? $params['order'] : 'DESC';
        $orderBy = isset($params['orderBy']) ? $params['orderBy'] : 'created_time';
        if($orderBy == 'author')  {
            $orderBy = 'u.login';
        }else{
            $orderBy = 'a.'.$orderBy;
        }
        $sectionId = isset($params['sectionId']) ? (int) $params['sectionId'] : 0;

        if($page < 1) $page = 1;
        $whereArr = array('a.owner_id = u.user_id');
        if(!empty($sectionId)) $whereArr[] = "(a.section_id = ".SQLQuote($sectionId).")";
        if(isset($params['enabled'])) $whereArr[] = "(a.is_enabled = 'Y')";
        $where = '';
        if(count($whereArr) > 0) $where = "WHERE ".implode(" AND ", $whereArr);
        if($perPage > 0){
            $q = "
                SELECT COUNT(*) as cnt
                FROM ".$this->_tableName." as a, users as u
                $where
            ";
            $data = SQLGet($q, $this->_dbh);
            $cnt = isset($data['cnt']) ? $data['cnt'] : 0;
        }
        $q = "
            SELECT a.*
            FROM ".$this->_tableName." as a, users as u
            $where
            ORDER BY $orderBy ".$order."
        ";
        if($perPage > 0){
            $q .= "LIMIT ".(($page-1)*$perPage).",".$perPage;
        }
        $items = SQLGetRows($q, $this->_dbh);
        $total = $this->prepareTotal($items, $perPage, $cnt);
        return $total;
    }

    public function sortByCreatedAndApprovedTime($order = 'DESC', $page = 1, $perPage = 0)
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
            (SELECT a.*, IF(a.created_time > a.approved_time, a.created_time, a.approved_time) as max_time
            FROM ".$this->_tableName." as a
            ) ORDER BY max_time ".$order."
        ";
        if($perPage > 0){
            $q .= "LIMIT ".(($page-1)*$perPage).",".$perPage;
        }
        $items = SQLGetRows($q, $this->_dbh);
        $total = $this->prepareTotal($items, $perPage, $cnt);
        return $total;
    }
}

?>