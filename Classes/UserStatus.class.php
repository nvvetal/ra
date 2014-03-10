<?php

class UserStatus extends API_Item
{
    protected $_itemTable = 'user_status';
    protected $_isDelete  = true;

    public function getLastActiveStatus($userId)
    {
        $q = "
            SELECT status
            FROM ".$this->_itemTable."
            WHERE user_id = ".SQLQuote($userId)." AND is_active = 'Y'
            ORDER BY created_time DESC
            LIMIT 1
        ";
        $data = SQLGet($q, $this->_dbh);

        return isset($data['status']) ? $data['status'] : '';
    }
}

