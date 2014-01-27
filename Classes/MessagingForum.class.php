<?php

class MessagingForum{
    private $dbh;
    
    public function __construct($dbh){
        $this->dbh = $dbh;
    }
    
    public function sendMessage($params){
        $User = Registry::get('User');
        $fromUserId = $params['fromUserId'];
        $fromForumUserId = $User->find_forum_by_user_id($fromUserId);
        
        $toUserId = $params['toUserId'];
        $toForumUserId = $User->find_forum_by_user_id($toUserId);        
        $fields = array(
            'root_level'=>0,
            'author_id' => $fromForumUserId,
            'author_ip' => $_SERVER['REMOTE_ADDR'],
            'message_time' => time(),
            'enable_bbcode' => 0,
            'enable_smilies' => 1,
            'enable_magic_url' => 0,
            'enable_sig' => 0,
            'message_subject' => $params['subject'],
            'message_text' => $params['message'],
            'to_address' => 'u_'.$toForumUserId,
        ); 
        $msg_id = SQLInsert('phpbb_privmsgs',$fields,$this->dbh);  
        
        $fields = array(
            'msg_id'=>$msg_id,
            'user_id'=>$toForumUserId,
            'author_id'=>$fromForumUserId,
        );
        SQLInsert('phpbb_privmsgs_to',$fields,$this->dbh);
        return true;    
    }
    
    
}

?>