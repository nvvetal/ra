<?php

class calendar_forum
{

    private $_dbh;
    public function __construct()
    {
        $DBFactory = Registry::get('DBFactory');
        $db_params = Registry::get('db_params');
        $DBFactory->add_db_handle("forum",$db_params['forum']['server'],$db_params['forum']['database'],
            $db_params['forum']['user'],$db_params['forum']['password']);
        $this->_dbh = $DBFactory->get_db_handle('forum');
    }
    
    public function getForums($pid = 0)
    {
        $query = "
            SELECT *
            FROM phpbb_forums
            WHERE parent_id = ".SQLQuote($pid)."
            ORDER BY forum_name ASC
        ";
        $forums = SQLGetRows($query, $this->_dbh);
        return $forums;
    }
    
    public function createTopic($params)
    {
        $topicId = SQLInsert('phpbb_topics', $params, $this->_dbh);
        $this->incrementForumTopicCount($params['forum_id']);
        return $topicId;
    }

    public function incrementForumTopicCount($forumId)
    {
        $q = 'SELECT forum_topics, forum_topics_real  FROM phpbb_forums WHERE forum_id = '.SQLQuote($forumId);
        $forumData = SQLGet($q,  $this->_dbh);
        $forumData['forum_topics']++;
        $forumData['forum_topics_real']++;
        SQLUpdate('phpbb_forums', $forumData, 'WHERE forum_id = '.SQLQuote($forumId), $this->_dbh);
    }
    
    public function setTopic($topicId, $params)
    {
        SQLUpdate('phpbb_topics', $params, 'WHERE topic_id = '.SQLQuote($topicId), $this->_dbh);
    }
    
    public function postMessage($postId, $params)
    {
        if($postId == 0){
            $postId = SQLInsert('phpbb_posts', $params, $this->_dbh);
        }else{
            SQLUpdate('phpbb_posts', $params, "WHERE post_id = ".SQLQuote($postId), $this->_dbh);
        }        
        return $postId;
    }
    
    public function updateTopicForumId($topicId, $forumId)
    {
        $fields = array(
            'forum_id' => $forumId,
        );
        SQLUpdate('phpbb_posts', $fields, 'WHERE topic_id = '.SQLQuote($topicId), $this->_dbh);
        SQLUpdate('phpbb_topics', $fields, 'WHERE topic_id = '.SQLQuote($topicId), $this->_dbh);
    }
    
    public function deleteTopic($topicId)
    {
        $query = "
            DELETE FROM phpbb_posts WHERE topic_id = ".SQLQuote($topicId)."
        ";
        SQLQuery($query, $this->_dbh);
        $query = "
            DELETE FROM phpbb_topics WHERE topic_id = ".SQLQuote($topicId)."
        ";
        SQLQuery($query, $this->_dbh);        
    }
}

?>