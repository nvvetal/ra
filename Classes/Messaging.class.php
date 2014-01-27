<?php

class Messaging {
    private $class;
    private $dbh;
    
    public function __construct($type='forum'){
        try{
            if($type != 'forum') throw new Exception('Cannot find other type!');
            $DBFactory = Registry::get('DBFactory');
            $dbh = $DBFactory->get_db_handle('forum');
            require_once('MessagingForum.class.php');
            $this->class = new MessagingForum($dbh);
        }catch(Exception $e){
            add_to_log("[error cannot init][type $type]",'error_messaging');
        }
    }
    
    public function sendMessage($params){
        return $this->class->sendMessage($params);
    }
}
?>