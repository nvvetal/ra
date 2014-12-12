<?php

class Utils {

    function Utils(){

    }

    function get_next_month($current_year,$current_month,$type="+"){
        $current_month = sprintf("%04d-%02d-01",$current_year,$current_month);

        $next_month = strtotime("{$type}1 month",strtotime($current_month));

        $month = array(
            "name"=>date("F",$next_month),
            "year"=>date("Y",$next_month),
            "month"=>date("n",$next_month),
        );

        return $month;
    }

    function get_month_days($current_year,$current_month,$order='asc'){
        $cmonth_full = sprintf("%04d-%02d-01",$current_year,$current_month);
        $cmonth = sprintf("%04d-%02d",$current_year,$current_month);
        $days_count = date("t",strtotime($cmonth_full));
        $days = array();
        
        for($i=1;$i<=$days_count;$i++){
            $current_day = $cmonth.sprintf("-%02d",$i);
            $days[$i] = array(
                'representation'=>date('D',strtotime($current_day)),
                'numeric_representation'=>date('w',strtotime($current_day)),
                'ymd_representation'=>$current_day,
                'timestamp'=>strtotime($current_day),
                'd'=>sprintf('%02d',$i),
                'm'=>$current_month,
                'y'=>$current_year,
            );
        }
        if($order == 'desc') usort($days,array($this,'cmp_month_days'));
        return $days;
    }
    
    function cmp_month_days($a, $b){
        if ($a['timestamp'] == $b['timestamp']) {
            return 0;
        }
        return ($a['timestamp'] < $b['timestamp']) ? 1 : -1;
    }    

    function explode($divider,$data){
        $arr = explode($divider,$data);
        $d = array();
        foreach ($arr as $key=>$value){
            $d[$value]=$value;
        }
        return $d;
    }
    
    function get_months($currentYear, $currentMonth){
        $months = array();
        for ($i = 0; $i <= 11; $i++){
//            $d = strtotime(sprintf("2000-%02d-01",$i));
            $d = strtotime('+'.$i.' month', strtotime($currentYear.'-'.$currentMonth.'-01 00:00:00'));
            $months[] = array(
                'month'         => date('F', $d),
                'month_short'   => date('m', $d),
                'year'          => date('Y', $d),
            );
        }
        return $months;
    }

	function get_current_month_index(){
		return 0;
        return date('n')-1;
	}

}


?>