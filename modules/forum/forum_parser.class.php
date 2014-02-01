<?php

class forum_parser {
    private $_dbh;

    public function __construct($dbh){
        $this->_dbh = $dbh;
    }

    public function get_last_posts($maxCount=5){
        $query = "
            SELECT t.*,u.username
            FROM phpbb_topics as t, phpbb_users as u
            WHERE t.topic_poster = u.user_id
            GROUP BY t.topic_id
            ORDER BY t.topic_time DESC
            LIMIT $maxCount
        ";
        $topics = SQLGetRows($query,$this->_dbh);
        return $topics;
    }

    public function get_last_posts_by_topic($maxCount=5)
    {
        $query = "SELECT p.topic_id, p.forum_id, p.post_time, p.post_id, p.poster_id FROM phpbb_posts as p ORDER BY p.post_time DESC LIMIT 500";
        $posts = SQLGetRows($query, $this->_dbh);
        $topics = array();
        $foundTopics = array();
        $i = 0;
        foreach ($posts as $postData){
            if(in_array($postData['forum_id'], array(32, 63, 86, 163))) continue;
            if(isset($foundTopics[$postData['topic_id']])) continue;
            $foundTopics[$postData['topic_id']] = $postData['topic_id'];
            $topics[$i] = $postData;
            $user = $this->getUser($postData['poster_id']);
            $topics[$i] ['username'] = $user['username'];
            $topic = $this->getTopic($postData['topic_id']);
            $topics[$i] ['topic_title'] = $topic['topic_title'];
            $topics[$i] ['topic_views'] = $topic['topic_views'];
            $topics[$i] ['topic_replies'] = $topic['topic_replies'];
            if($i == $maxCount) break;
            $i++;
        }
        return $topics;
    }

    public function getUser($userId)
    {
        $q = "SELECT * FROM phpbb_users WHERE user_id = ".$userId;
        $data = SQLGet($q, $this->_dbh);
        return (isset($data['username'])) ? $data : NULL;
    }

    public function getTopic($topicId)
    {
        $query = "SELECT t.* FROM phpbb_topics as t WHERE t.topic_id = ".$topicId;
        $topic = SQLGet($query, $this->_dbh);
        return $topic;
    }

}

?>