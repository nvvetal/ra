<?php

class Comment extends API_Item
{
    protected $_itemTable = 'comments';
    protected $_isDelete  = true;
    protected $_children = array();

    public function getLogin()
    {
        $user = new User($this->_dbh);
        return $user->get_value($this->createdBy, 'login');
    }

    public function setChildren($children)
    {
        $this->_children = $children;
    }

    public function hasChildren()
    {
        return count($this->_children) > 0;
    }

    public function getChildren()
    {
        return $this->_children;
    }
}

?>