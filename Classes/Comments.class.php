<?php

class Comments extends API_List
{
    protected $_itemObjName = 'Comment';
    
    public function getCommentsByPhoto($itemId, $ord = 'ASC', $onlyApproved = false)
    {
        return $this->getCommentsBy('photo', $itemId, $ord, $onlyApproved);
    }

    public function getCommentsByArticle($itemId, $ord = 'ASC', $onlyApproved = false)
    {
        return $this->getCommentsBy('article', $itemId, $ord, $onlyApproved, true);
    }
    
    public function getCommentsBy($itemType, $itemId, $ord = 'ASC', $onlyApproved = false, $fetchChildren = false)
    {
        $comments = array();
        $andApproved = "";
        if($onlyApproved) $andApproved = "AND isApproved = 'Y'";
        $q = "
            SELECT *
            FROM ".$this->_tableName."
            WHERE itemType = ".SQLQuote($itemType)." AND itemId = ".SQLQuote($itemId)." AND pItemId = 0 $andApproved
            ORDER BY timeCreated $ord
        ";
        $data = SQLGetRows($q, $this->_dbh);
        if(!is_array($data) || count($data) == 0) return $comments;
        foreach ($data as $comment){
            try {
                $itemObj = new $this->_itemObjName($this->_dbh);
                $itemObj->findById($comment['id']);
                if($fetchChildren){
                    $children = $this->getCommentsByParent($comment['id'], $ord, $onlyApproved);
                    if(count($children) > 0) $itemObj->setChildren($children);
                }
                $comments[] = $itemObj;
            }catch(Exception $e){
                exception_handler($e);
            }
        }
        return $comments;
    }

    public function getCommentsByParent($parentId,  $ord = 'ASC', $onlyApproved = false)
    {
        $comments = array();
        $andApproved = "";
        if($onlyApproved) $andApproved = "AND isApproved = 'Y'";
        $q = "
            SELECT *
            FROM ".$this->_tableName."
            WHERE pItemId = ".SQLQuote($parentId)." $andApproved
            ORDER BY timeCreated $ord
        ";
        $data = SQLGetRows($q, $this->_dbh);
        if(!is_array($data) || count($data) == 0) return $comments;
        foreach ($data as $comment){
            try {
                $itemObj = new $this->_itemObjName($this->_dbh);
                $itemObj->findById($comment['id']);
                $children = $this->getCommentsByParent($comment['id'], $ord, $onlyApproved);
                if(count($children) > 0) $itemObj->setChildren($children);
                $comments[] = $itemObj;
            }catch(Exception $e){
                exception_handler($e);
            }
        }
        return $comments;
    }
}

?>