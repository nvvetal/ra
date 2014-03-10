<?php

class UserStatuses extends API_List{

    protected $_itemObjName = 'UserStatus';

    public function byUserAndTime($userId, $order = 'DESC', $page = 1, $perPage = 0, $params = array())
    {
        $cnt = 0;
        if($page < 1) $page = 1;
        $where = array();
        $where[] = "user_id = ".SQLQuote($userId);
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
}
