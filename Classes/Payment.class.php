<?php

class Payment {    
    private $dbh;
    private $paymentConfig;
    
    public function __construct($paymentConfig,$dbh){
        $this->dbh = $dbh;
        $this->paymentConfig = $paymentConfig;
    }
    
    public function getPrices($currency){
        return (isset($this->paymentConfig['paymentPrices'][$currency])) ? $this->paymentConfig['paymentPrices'][$currency] : false;
    }
    public function getPaymentConfig($paymentType){
        return (isset($this->paymentConfig['payments'][$paymentType])) ? $this->paymentConfig['payments'][$paymentType] : false;
       
    }    
    
    public function createOrder($params){
        return SQLInsert('payment_orders',$params,$this->dbh);
    }
    
    public function getOrder($orderId){
        $query = "
            SELECT *
            FROM payment_orders
            WHERE id = ".SQLQuote($orderId)."
        ";
        return SQLGet($query,$this->dbh);
    }
    
    public function setOrder($orderId,$params){
        SQLUpdate('payment_orders',$params,"WHERE id = ".SQLQuote($orderId),$this->dbh);
    }
    
    public function addStats($userId,$type,$amount){
        $fields = array(
            'user_id'           => $userId,  
            'type'              => $type,  
            'amount'            => $amount,  
            'time_created'      => time(),  
        );
        SQLInsert('payment_stats',$fields,$this->dbh);
    }
    
    public function getDailyAgrStats($y,$m,$d){
        //echo "$y,$m,$d";
        $begin_date = sprintf("%04d-%02d-%02d 00:00:00",$y,$m,$d);
        $end_date = sprintf("%04d-%02d-%02d 23:59:59",$y,$m,$d);
        $query = "
            (SELECT `type`, SUM(amount) as amount
            FROM payment_stats
            WHERE FROM_UNIXTIME(time_created) BETWEEN '$begin_date' AND '$end_date'
            GROUP BY `type` ASC)
            UNION
            (SELECT `rule` as `type`, SUM(amount) as amount
            FROM raks_history
            WHERE FROM_UNIXTIME(time_action) BETWEEN '$begin_date' AND '$end_date'
            GROUP BY `rule` ASC)
        ";
        $data = SQLGetRows($query,$this->dbh);
        if(!is_array($data)) return false;
        $stats = array();
        foreach ($data as $key=>$stat){
            $stats[$stat['type']] = $stat['amount'];
        }
        return $stats;
    }
        
}

?>