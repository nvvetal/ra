<?php

class school {
    var $dbh;

    function __construct($dbh){
        $this->dbh = $dbh;
    }

    function get_user_schools($user_id){
        $query="
			SELECT *
			FROM schools
			WHERE owner_id = ".SQLQuote($user_id)."
			ORDER BY name ASC
		";
        $rows = SQLGetRows($query,$this->dbh);
        return $rows;
    }

    function is_user_owner($school_id,$user_id){
        $school = $this->get_school($school_id);
        if(!is_array($school) || $school['owner_id'] != $user_id) return false;
        return true;
    }

    function add_school($params){
        SQLInsert("schools",$params,$this->dbh);
        $this->sync_positions();
        return SQLInsId($this->dbh);
    }

    function edit_school($school_id,$params){
        SQLUpdate("schools",$params,"WHERE id=".SQLQuote($school_id),$this->dbh);
    }

    function delete_school($school_id){
        $query = "
			DELETE FROM schools
			WHERE id = ".SQLQuote($school_id)."
		";
        $this->sync_positions();
        SQLQuery($query,$this->dbh);
    }

    function get_school($school_id){
        $query = "
			SELECT *
			FROM schools
			WHERE id = ".SQLQuote($school_id)."
			LIMIT 1
		";
        $school = SQLGet($query,$this->dbh);
        return $school;
    }

    function get_premium_schools(){
        $current_time = time();
        $query = "
			SELECT *
			FROM schools as s, schools_premium as sp
			WHERE s.is_approved = 1 AND s.id = sp.school_id
				AND sp.end_time > $current_time
			ORDER BY RAND() DESC
			LIMIT 3
		";
        $schools = SQLGetRows($query,$this->dbh);
        return $schools;
    }

    function get_premium_schools_count(){
        $current_time = time();
        $query = "
			SELECT COUNT(s.id) as cnt
			FROM schools as s, schools_premium as sp
			WHERE s.is_approved = 1 AND s.id = sp.school_id
				AND sp.end_time > $current_time
			GROUP BY s.id
		";
        $data = SQLGet($query,$this->dbh);
        return $data['cnt'];
    }

    function get_schools($page=1,$per_page=10,$city_id='all', $only_approved = 1){
        $where = ($city_id == 'all') ? '' : 'city_id = '.SQLQuote($city_id).' AND ';
        $where .= ($only_approved == 1) ? 'is_approved = 1 AND ' : '';
        if(!empty($where)) {
            $where = substr($where,0,strlen($where)-4);
            $where = "WHERE ".$where;
        }
        $begin = ($page-1) * $per_page;
        $query = "
			SELECT *
			FROM schools
			$where
			ORDER BY position ASC
			LIMIT $begin,$per_page
		";
        $schools = SQLGetRows($query,$this->dbh);
        return $schools;
    }



    function get_schools_count($per_page=10,$city_id='all', $only_approved = 1){
        $where = ($city_id == 'all') ? '' : 'city_id = '.SQLQuote($city_id).' AND ';
        $where .= ($only_approved == 1) ? 'is_approved = 1 AND ' : '';
        if(!empty($where)) {
            $where = substr($where,0,strlen($where)-4);
            $where = "WHERE ".$where;
        }

        $query = "
            SELECT COUNT(*) as cnt
            FROM schools
            $where
        ";
        $data = SQLGet($query,$this->dbh);
        $count = ceil($data['cnt'] / $per_page);
        return $count;
    }

    function get_schools_search($searchFilter){
        $order = (isset($searchFilter['order_by']) && $searchFilter['order_by'] == 'last') ? 'position' : 'name';
        $city_id = (!empty($searchFilter['city_id']) && $searchFilter['city_id'] > 0) ? intval($searchFilter['city_id']) : '';
        $subdivision_id = (!empty($searchFilter['subdivision_id']) && $searchFilter['subdivision_id'] > 0) ? intval($searchFilter['subdivision_id']) : '';
        $country_id = (!empty($searchFilter['country_id']) && $searchFilter['country_id'] > 0) ? intval($searchFilter['country_id']) : '';
        $per_page = isset($searchFilter['per_page']) ? intval($searchFilter['per_page']) : 25;
        $page = isset($searchFilter['page']) ? intval($searchFilter['page']) : 1;
        $begin = ($page-1) * $per_page;

        $where = '';
        $and = array();
        $andFromCities = '';
        $citiesUse = false;
        if(!empty($country_id)){
            $citiesUse = true;
            $and[] = "c.country_id = ".SQLQuote($country_id);
        }

        if(!empty($subdivision_id)){
            $citiesUse = true;
            $and[] = "c.subdivision_id = ".SQLQuote($subdivision_id);
        }

        if(!empty($city_id)){
            $citiesUse = true;
            $and[] = "c.id = ".SQLQuote($city_id);
        }

        if($citiesUse){
            array_unshift($and,'c.id = s.city_id');
            $andFromCities = ', cities as c';
        }

        $and[] = 's.is_approved = 1';

        if(count($and) > 0){
            $where = implode(' AND ',$and);
        }

        if(!empty($where)) $where = 'WHERE '.$where;

        $query = "
            SELECT s.*
            FROM schools as s$andFromCities
            $where
            ORDER BY s.$order ASC
            LIMIT $begin,$per_page
        ";

        return SQLGetRows($query,$this->dbh);
    }

    function get_schools_search_cnt($searchFilter){
        $city_id = (!empty($searchFilter['city_id']) && $searchFilter['city_id'] > 0) ? intval($searchFilter['city_id']) : '';
        $subdivision_id = (!empty($searchFilter['subdivision_id']) && $searchFilter['subdivision_id'] > 0) ? intval($searchFilter['subdivision_id']) : '';
        $country_id = (!empty($searchFilter['country_id']) && $searchFilter['country_id'] > 0) ? intval($searchFilter['country_id']) : '';
        $per_page = isset($searchFilter['per_page']) ? intval($searchFilter['per_page']) : 25;
        $where = '';
        $and = array();
        $andFromCities = '';
        $citiesUse = false;
        if(!empty($country_id)){
            $citiesUse = true;
            $and[] = "c.country_id = ".SQLQuote($country_id);
        }

        if(!empty($subdivision_id)){
            $citiesUse = true;
            $and[] = "c.subdivision_id = ".SQLQuote($subdivision_id);
        }

        if(!empty($city_id)){
            $citiesUse = true;
            $and[] = "c.id = ".SQLQuote($city_id);
        }

        if($citiesUse){
            array_unshift($and,'c.id = s.city_id');
            $andFromCities = ', cities as c';
        }
        $and[] = 's.is_approved = 1';

        if(count($and) > 0){
            $where = implode(' AND ',$and);
        }

        if(!empty($where)) $where = 'WHERE '.$where;

        $query = "
            SELECT COUNT(s.id) as cnt
            FROM schools as s$andFromCities
            $where
        ";
        $data = SQLGet($query,$this->dbh);
        $count = ceil($data['cnt'] / $per_page);
        return $count;
    }

    function approve_school($school_id, $is_approved){
        $query="
			UPDATE schools
			SET is_approved = '$is_approved'
			WHERE id = ".SQLQuote($school_id)."
		";
        SQLQuery($query,$this->dbh);
    }

    function get_user_schools_count($owner_id){
        $query= "
			SELECT COUNT(*) as cnt
			FROM schools
			WHERE owner_id=".SQLQuote($owner_id)."
		";
        $row = SQLGet($query,$this->dbh);

        return ($row !== false) ? $row['cnt'] : 0;
    }

    function sync_positions(){
        $query = "
	       SELECT *
	       FROM schools
	       ORDER BY position ASC, created_date_time ASC
	    ";
        $rows = SQLGetRows($query,$this->dbh);
        $i = 0;
        foreach($rows as $row){
            $fields = array(
                'position' => ++$i,
            );
            $this->edit_school($row['id'],$fields);
        }
    }

    function set_top($school_id){
        $fields = array(
            'position' => 0,
        );
        $this->edit_school($school_id,$fields);
        $this->sync_positions();
    }

    function set_vip($school_id){
        $isActive = $this->is_school_vip_active($school_id);
        if(!$isActive){
            $fields = array(
                'school_id'=>$school_id,
                'begin_time'=>time(),
                'end_time'  =>strtotime('+1 month',time()),
            );
            SQLInsert('schools_premium',$fields,$this->dbh);
        }else{
            $lastVip = $this->get_vip_school_data($school_id);
            $fields = array(
                'end_time' => $lastVip['end_time'] - time() + strtotime('+1 month',time()),
            );
            SQLUpdate('schools_premium',$fields,'WHERE id = '.$lastVip['id'],$this->dbh);
        }
    }

    function is_school_vip_active($school_id){
        $query = "
            SELECT COUNT(*) as cnt
            FROM schools_premium
            WHERE school_id = ".SQLQuote($school_id)." AND end_time > ".time()."
            ORDER BY end_time DESC
            LIMIT 1
        ";
        $data = SQLGet($query,$this->dbh);
        return ($data['cnt'] > 0) ? true : false;
    }

    function get_vip_school_data($school_id){
        $query = "
            SELECT *
            FROM schools_premium
            WHERE school_id = ".SQLQuote($school_id)." AND end_time > ".time()."
            ORDER BY end_time DESC
            LIMIT 1
        ";

        return SQLGet($query,$this->dbh);
    }

    function get_cost($key){
        $prices = Registry::get('schoolPrices');
        return $prices[$key];
    }

    function get_school_cities_by_subdivision($subdivision_id){
        $query = "
            SELECT c.*
            FROM schools as s, cities as c
            WHERE s.city_id = c.id AND c.is_deleted = 0
                AND c.subdivision_id = ".SQLQuote($subdivision_id)."
            GROUP BY c.id
            ORDER BY c.name ASC
        ";
        return SQLGetRows($query,$this->dbh);
    }
}

?>