<?php

class Rate extends API_Item 
{
    protected $_itemTable = 'rates';
    protected $_isDelete  = true;
    
    public function create($data){
        $res = parent::create($data);
        if($res['id'] === false) return array('ok'=>false);
        try {
            $agrData = $this->getRateAgrData($data['rateToId'], $data['rateToType']);            
            $RateAgr = new RateAgr($this->_dbh);
            $RateAgr->findByRateIdAndType($data['rateToId'], $data['rateToType']);
            $RateAgr->rateCnt = $agrData['cnt'];
            $RateAgr->ratePoints = $agrData['sum'];
            $RateAgr->rateAvg = ($agrData['cnt'] > 0) ? $agrData['sum']/$agrData['cnt'] : 0;
        }catch(Exception $e){
            exception_handler($e);
        }
        return array('ok'=>true, 'id' => $res['id']);
    }
    
    public function getRateAgrData($rateToId, $rateToType)
    {
        $q = "
            SELECT SUM(ratePoints) as s, COUNT(rateToId) as c
            FROM ".$this->_itemTable."
            WHERE rateToId = ".SQLQuote($rateToId)." AND rateToType = ".SQLQuote($rateToType)."
            GROUP BY rateToId
        ";
        $res = SQLGet($q, $this->_dbh);
        $data = array(
            'sum' => 0,
            'cnt' => 0,
        );
        if(is_array($res)){
            $data['sum'] = $res['s'];
            $data['cnt'] = $res['c'];
        }
        return $data;       
    }
}

?>