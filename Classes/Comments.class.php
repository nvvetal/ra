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

    public function getUserNewCommentsCountByType($userId, $type, $maxPeriodSecs)
    {
        if(!in_array($type, array('photo', 'video'))) return 0;
        $addTable = $type.'_'.$type.'s';
        $q = "
            SELECT COUNT(c.id) as cnt
            FROM ".$this->_tableName." as c, $addTable as a
            WHERE c.createdBy <> ".SQLQuote($userId)."
                AND (c.sawTime > ".SQLQuote(time() - $maxPeriodSecs)." OR c.sawTime = 0)
                AND c.itemType = ".SQLQuote($type)."
                AND c.itemId = a.id AND a.owner_id = ".SQLQuote($userId)."
        ";
        $data = SQLGet($q, $this->_dbh);
        return $cnt = isset($data['cnt']) ? $data['cnt'] : 0;
    }

    public function getUserNewCommentsByType($userId, $type, $maxPeriodSecs)
    {
        require_once($GLOBALS['MODULES_DIR'].'photo/Photo.class.php');
        require_once($GLOBALS['MODULES_DIR'].'video/Video.class.php');
        if(!in_array($type, array('photo', 'video'))) return 0;
        $addTable = $type.'_'.$type.'s';
        $q = "
            SELECT c.*
            FROM ".$this->_tableName." as c, $addTable as a
            WHERE c.createdBy <> ".SQLQuote($userId)."
                AND (c.sawTime > ".SQLQuote(time() - $maxPeriodSecs)." OR c.sawTime = 0)
                AND c.itemType = ".SQLQuote($type)."
                AND c.itemId = a.id AND a.owner_id = ".SQLQuote($userId)."
            ORDER BY c.timeCreated DESC
        ";
        $data = SQLGetRows($q, $this->_dbh);
        $comments = array();
        $photo = new Photo($this->_dbh);
        $video = new Video($this->_dbh);
        foreach ($data as $comment){
            try {
                $itemObj = new $this->_itemObjName($this->_dbh);
                $itemObj->findById($comment['id']);
                $commentItem = NULL;
                if($type == 'photo') {
                    $photo->findById($comment['itemId']);
                    $commentItem = $photo;
                }else{
                    $video->findById($comment['itemId']);
                    $commentItem = $video;
                }
                $comments[] = array(
                    'comment' => $itemObj,
                    'commentItem' => $commentItem,
                );
            }catch(Exception $e){
                exception_handler($e);
            }
        }
        return $comments;
    }
}
