<?php

class calendar {
    var $dbh;

    function calendar($dbh){
        $this->dbh = $dbh;
    }

    function get_categories(){
        $query = "
	       SELECT *
	       FROM calendar_categories
	       WHERE is_deleted = 0
	       ORDER BY name ASC
	    ";
        return SQLGetRows($query,$this->dbh);
    }

    function get_category($category_id){
        $query = "
	       SELECT *
	       FROM calendar_categories
	       WHERE id = ".SQLQuote($category_id)."
	       LIMIT 1
	    ";
        return SQLGet($query,$this->dbh);
    }

    function add_category($params){
        return SQLInsert('calendar_categories',$params,$this->dbh);
    }

    function set_category($category_id,$params){
        SQLUpdate('calendar_categories',$params,'WHERE id = '.SQLQuote($category_id),$this->dbh);
    }

    function delete_category($category_id){
        $params = array(
            'is_deleted' => 1,
        );
        $this->set_category($category_id,$params);
    }

    function is_category_name_exists($category_id,$name){
        $query = "
            SELECT COUNT(*) as cnt
            FROM calendar_categories
            WHERE is_deleted = 0 AND name = ".SQLQuote($name)."
                AND id != ".SQLQuote($category_id)."
        ";
        $data = SQLGet($query,$this->dbh);
        return ($data['cnt']>0) ? true : false;
    }

    function add_calendar($params){
        SQLInsert('calendar',$params,$this->dbh);
        return SQLInsId($this->dbh);
    }

    function checkCategoryForumId($forumId)
    {
        $query = "
            SELECT COUNT(*) as cnt
            FROM calendar_categories
            WHERE forum_id = ".SQLQuote($forumId)."
        ";
        $data = SQLGet($query, $this->dbh);
        return ($data['cnt'] > 0) ? true : false;
    }

    function getCategoryByPostId($postId)
    {
        $query = "
            SELECT *
            FROM calendar
            WHERE forum_post_id = ".SQLQuote($postId)."
            LIMIT 1
        ";
        $data = SQLGet($query, $this->dbh);
        return isset($data['id']) ? $data : false;
    }

    function get_calendar($calendar_id){
        $query = "
	       SELECT *
	       FROM calendar
	       WHERE id=".SQLQuote($calendar_id)."
	   ";
        return SQLGet($query,$this->dbh);
    }

    function set_calendar($calendar_id,$params){
        SQLUpdate('calendar',$params,"WHERE id=".SQLQuote($calendar_id),$this->dbh);
    }

    function approve_calendar($calendar_id){
        $params = array(
            'is_approved' => 1,
        );
        $this->set_calendar($calendar_id,$params);

    }
    function disable_calendar($calendar_id){
        $params = array(
            'is_approved' => -1,
        );
        $this->set_calendar($calendar_id,$params);
    }

    function delete_calendar($calendar_id){
        $params = array(
            'is_deleted' => 1,
        );
        $this->set_calendar($calendar_id,$params);
    }

    function set_calendar_additional_info($calendar_id,$params){
        $this->delete_calendar_additional_info($calendar_id);
        if(count($params) == 0) return false;
        foreach ($params as $p_key=>$p_value){
            $fields = array(
                'calendar_id'=>$calendar_id,
                'name'=>$p_key,
                'value'=>$p_value,
            );
            SQLInsert('calendar_additional_info',$fields,$this->dbh);
        }
    }


    function delete_calendar_additional_info($calendar_id){
        $query = "
            DELETE FROM calendar_additional_info
            WHERE calendar_id = ".SQLQuote($calendar_id)."
        ";
        SQLQuery($query,$this->dbh);
    }

    function get_calendar_additional_info($calendar_id,$key,$iteration=''){
        $and_name = "AND name LIKE ".SQLQuote($key.'%');
        if(strval($iteration) != ''){
            $and_name = "AND name = ".SQLQuote($key.$iteration);
        }
        $query = "
	       SELECT *
	       FROM calendar_additional_info
	       WHERE calendar_id = ".SQLQuote($calendar_id)." $and_name
	       ORDER BY name ASC
	    ";
        $data = array();
        if(strval($iteration) != ''){
            $row = SQLGet($query,$this->dbh);
            return ($row !== false) ? $row['value'] : false;
        }
        $rows = SQLGetRows($query,$this->dbh);
        foreach ($rows as $key=>$row){
            $data[] = $row['value'];
        }
        return $data;
    }

    function get_calendars_cnt($year,$month){
        $begin_date = sprintf("%04d-%02d-01",$year,$month);
        $end_date = sprintf("%04d-%02d-%02d",$year,$month,date('t',strtotime($begin_date)));
        $query = "
	       SELECT COUNT(*) as cnt
	       FROM calendar
	       WHERE bdate BETWEEN '$begin_date' AND '$end_date' AND is_approved = 1
	           AND is_deleted = 0
	    ";
        $data = SQLGet($query,$this->dbh);
        return $data['cnt'];
    }

    function get_calendars_by_month($year,$month){
        $begin_date = sprintf("%04d-%02d-01",$year,$month);
        $end_date = sprintf("%04d-%02d-%02d",$year,$month,date('t',strtotime($begin_date)));
        $query = "
	       SELECT *
	       FROM calendar
	       WHERE bdate BETWEEN '$begin_date'
	           AND '$end_date' AND is_approved = 1
	           AND is_deleted = 0
	       ORDER BY bdate ASC, small_info ASC
	    ";
        $rows = SQLGetRows($query,$this->dbh);
        if(count($rows)==0)return array();
        $data = array();
        foreach ($rows as $key=>$row){
            $data[$row['bdate']][]=$row;
        }
        return $data;
    }

    function get_calendars_not_approved(){
        $query = "
            SELECT *
            FROM calendar
            WHERE is_approved != 1 AND is_deleted = 0
            ORDER BY bdate DESC
        ";

        return SQLGetRows($query,$this->dbh);
    }

    function is_user_owner($calendar_id, $user_id){
        $calendar = $this->get_calendar($calendar_id);
        if(!is_array($calendar) || $calendar['creator_id'] != $user_id) return false;
        return true;
    }

    function get_cost($key){
        $prices = Registry::get('calendarPrices');
        return $prices[$key];
    }

    function set_vip($calendar_id)
    {
        $params = array(
            'is_vip' => 'Y',
        );
        $this->set_calendar($calendar_id,$params);
    }

    function is_vip($calendar_id)
    {
        $calendar = $this->get_calendar($calendar_id);
        return ($calendar['is_vip'] == 'Y') ? true : false;
    }
}
?>