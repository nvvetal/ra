<?php

class DBFactory {
    var $dbh =array();

    /*------------------------------------------------------*/
    /* CREATED BY nvvetal 2006 Sun Sep 10 14:26:59 EEST 2006
    /* USING FOR:
    /*------------------------------------------------------*/
    function add_db_handle($handle_name,$server,$database,$user,$password)
    {
        $params=array(
            "server"=>$server,
            "database"=>$database,
            "user"=>$user,
            "password"=>$password,
        );
        $handle=SQLConnect($params);
        $params["handle"]=$handle;
        SQLQuery("SET NAMES UTF8",$handle);
        $this->dbh["$handle_name"]=$params;
    }//end function set_db_values

    /*------------------------------------------------------*/
    /* CREATED BY nvvetal 2006 Sun Sep 10 14:38:37 EEST 2006
    /* USING FOR:
    /*------------------------------------------------------*/
    function get_db_handle($handle_name)
    {
        if(array_key_exists($handle_name,$this->dbh)){
            return $this->dbh[$handle_name]["handle"];
        }elseif($handle_name == 'forum'){
            $db_params = Registry::get('db_params');
            $this->add_db_handle("forum",$db_params['forum']['server'],$db_params['forum']['database'],$db_params['forum']['user'],$db_params['forum']['password']); 
            return $this->dbh[$handle_name]["handle"];
        }else{
            die("Could not connect to database [$handle_name]!");
        }
    }//end function get_handle

    function get_db_params_by_handle($handle_name){
        if(array_key_exists($handle_name,$this->dbh)){
            return $this->dbh["$handle_name"];
        }else{
            return false;
        }
    }
}
?>