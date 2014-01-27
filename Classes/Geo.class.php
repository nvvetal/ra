<?php

class Geo {
    var $dbh;

    function Geo ($dbh){
        $this->dbh = $dbh;
    }

    function get_city($city_id){
        $query = "
			SELECT *
			FROM cities
			WHERE id =".SQLQuote($city_id)."
			LIMIT 1
		";
        $city = SQLGet($query,$this->dbh);
        return $city;
    }
    
    function add_city($params){
        return SQLInsert('cities',$params,$this->dbh);
    }
    
    function set_city($city_id,$params){
        SQLUpdate('cities',$params,"WHERE id = ".SQLQuote($city_id),$this->dbh);
    }
    
    function delete_city($city_id){
        $q = "DELETE FROM cities WHERE id = ".SQLQuote($city_id);
        SQLQuery($q);
    }  
    
    function is_city_name_exists($city_id,$country_id,$name){
        $query = "
            SELECT *
            FROM cities
            WHERE id != ".SQLQuote($city_id)." AND country_id = ".SQLQuote($country_id)." 
                AND name=".SQLQuote($name)."
            LIMIT 1
        ";
        $data = SQLGet($query,$this->dbh);
        return (isset($data['id'])) ? true : false;
    }

    function get_cities($show_deleted = false){
        $where = '';
        $query="
			SELECT *
			FROM cities
			$where
			ORDER BY name ASC
		";
        return SQLGetRows($query,$this->dbh);
    }

    function get_cities_by_country($country_id,$show_deleted = false){
        $and_deleted = '';
        $query="
			SELECT *
			FROM cities
			WHERE country_id = ".SQLQuote($country_id)." $and_deleted
			ORDER BY name ASC
		";
        return SQLGetRows($query,$this->dbh);
    }
    
    function get_cities_by_subdivision($subdision_id,$show_deleted = false){
        $and_deleted = '';
        $query="
			SELECT *
			FROM cities
			WHERE subdivision_id = ".SQLQuote($subdision_id)." $and_deleted
			ORDER BY name ASC
		";
        return SQLGetRows($query,$this->dbh);
    }    
    
    function add_subdivision($params){
        return SQLInsert('country_subdivisions',$params,$this->dbh);
    }
    
    function get_subdivisions($country_id){
        $query = "
            SELECT *
            FROM country_subdivisions
            WHERE country_id = ".SQLQuote($country_id)."
            ORDER BY name ASC
        ";
        return  SQLGetRows($query,$this->dbh);      
    }
    
    function get_subdivision($subdision_id){
        $query = "
            SELECT *
            FROM country_subdivisions
            WHERE id = ".SQLQuote($subdision_id)."
        ";
        return SQLGet($query,$this->dbh);
    }
    
    function is_subdivision_name_exists($subdivision_id,$country_id,$name){
        $query = "
            SELECT *
            FROM country_subdivisions
            WHERE id != ".SQLQuote($subdivision_id)." AND country_id = ".SQLQuote($country_id)." 
                AND name=".SQLQuote($name)."
            LIMIT 1
        ";
        $data = SQLGet($query,$this->dbh);
        return (isset($data['id'])) ? true : false;
    }    
    
    function set_subdivision($subdivision_id,$params){
        SQLUpdate('country_subdivisions',$params,"WHERE id = ".SQLQuote($subdivision_id),$this->dbh);
    }
    
    function delete_subdivision($subdivision_id){
        $q = "DELETE FROM country_subdivisions WHERE id = ".SQLQuote($subdivision_id);
        SQLQuery($q);
    }        

    function get_countries($show_deleted = false){
        $where = '';
        $query="
			SELECT *
			FROM countries
			$where
			ORDER BY IF(name = 'Украина',0,IF(name = 'Россия', 1, name)) ASC
		";

        return SQLGetRows($query,$this->dbh);
    }

    function get_country_id_by_city($city_id){
        $query = "
            SELECT country_id
            FROM cities
            WHERE id = ".SQLQuote($city_id)."	
	    ";

        $data = SQLGet($query,$this->dbh);

        return $city_id = ($data !== false) ? $data['country_id'] : false;
    }
	
	function get_country_by_city($city_id)
	{
		$countryId = $this->get_country_id_by_city($city_id);
		if($countryId === false) return false;
		return $this->get_country($countryId);
	}

    function get_country($country_id){
        $query = "
            SELECT *
            FROM countries
            WHERE id = ".SQLQuote($country_id)."	
	    ";
        $data = SQLGet($query,$this->dbh);
        return $data;
    }
    
    function get_country_by_name($name){
        $query = "
            SELECT *
            FROM countries
            WHERE name = ".SQLQuote($name)."	
	    ";
        $data = SQLGet($query,$this->dbh);
        return $data;        
    }
    
    function add_country($params){
        return SQLInsert('countries',$params,$this->dbh);
    }
    
    function set_country($country_id,$params){
        SQLUpdate('countries',$params,"WHERE id = ".SQLQuote($country_id),$this->dbh);
    }
    
    function delete_country($country_id){
        $q = "DELETE FROM countries WHERE id = ".SQLQuote($country_id);
        SQLQuery($q);
    }
    
    function is_country_name_exists($country_id,$name,$short_name){
        $query = "
            SELECT *
            FROM countries
            WHERE id != ".SQLQuote($country_id)." 
                AND (name=".SQLQuote($name).")
            LIMIT 1
        ";
        $data = SQLGet($query,$this->dbh);
        return (isset($data['id'])) ? true : false;
    }    

}


?>