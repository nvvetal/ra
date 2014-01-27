<?php

class banners {
    var $dbh;

    function banners ($dbh){
        $this->dbh = $dbh;
    }

    function can_show_banner_by_ip_count($ip,$count){
        $b_date = mktime(0,0,0,date("n"),date("j"),date("Y"));
        $e_date = mktime(0,0,0,date("n")+1,date("j"),date("Y"));

        $query = "
            SELECT COUNT(*) as cnt
            FROM banners_ip
            WHERE ip = INET_ATON(".SQLQuote($ip).") AND time_showed BETWEEN $b_date AND $e_date
        ";
        $data = SQLGet($query,$this->dbh);
        return ($count <= $data['cnt']) ? false : true;
    }

    function save_banner_ip_show($ip,$time){
        $query = "
            INSERT INTO banners_ip
            (ip,time_showed)
            VALUES (INET_ATON(".SQLQuote($ip)."),'".$time."')
        ";

        SQLQuery($query,$this->dbh);
    }

}


?>