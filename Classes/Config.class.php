<?php

class Config {
    var $table_name;
    var $dbh;

    function Config ($table_name,$dbh){
        $this->table_name = $table_name;
        $this->dbh = $dbh;
    }

    function get_param($name){
        $query = "
            SELECT value                                                                                                                   
            FROM ".$this->table_name."                                                                                                     
            WHERE name = ".SQLQuote($name)."                                                                                               
            LIMIT 1                                                                                                                        
        ";
        $res = SQLGet($query,$this->dbh);
        return ($res !== false) ? $res['value'] : false;
    }

    function set_param($name, $value){
        $query = "
            REPLACE ".$this->table_name." (name,value) VALUES (".SQLQuote($name).",".SQLQuote($value).")
        ";
        SQLQuery($query,$this->dbh);
    }
    
    function get_params(){
        $params = array();
        $query = "
            SELECT *
            FROM ".$this->table_name."
            ORDER BY name ASC
        ";        
        $datas = SQLGetRows($query,$this->dbh);        
        foreach ($datas as $key=>$data){
            switch ($data['name']){
                case "register_activation":
                    $data['type'] = 'bool';
                break;
                
                default:
                    $data['type'] = 'string';
                break;
            }
            $params[$data['name']] = $data;   
        }
        return $params;
    }

}


?>