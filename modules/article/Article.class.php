<?php

class Article extends API_Item {

    protected $_itemTable = 'articles';
    protected $_isDelete  = true;

    public function getOwnerUserId()
    {
        return $this->owner_id;
    }
}

?>