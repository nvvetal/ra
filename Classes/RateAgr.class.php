<?php

class RateAgr extends API_Item 
{
    protected $_itemTable = 'rates_agr';
    protected $_isDelete  = true;

    public function findByRateIdAndType($rateToId, $rateToType)
    {
        $this->_initCache($rateToId.'::'.$rateToType);
        $data = $this->_cache->getData();
        if(!is_null($data)) {
            $this->_itemData = $data;        
            return true;
        }
        $q = "
            SELECT *
            FROM ".$this->_itemTable."
            WHERE rateToId = ".SQLQuote($rateToId)." AND rateToType = ".SQLQuote($rateToType)."
            LIMIT 1
        ";
        $data = SQLGet($q, $this->_dbh);
        if($data !== false) {
            if($data['rateAvg'] > 4.5){
                $data['rateAvgRound'] = 5;
            }elseif($data['rateAvg'] > 4){
                $data['rateAvgRound'] = 4.5;
            }elseif($data['rateAvg'] > 3.5){
                $data['rateAvgRound'] = 4;                
            }elseif($data['rateAvg'] > 3){
                $data['rateAvgRound'] = 3.5;
            }elseif($data['rateAvg'] > 2.5){
                $data['rateAvgRound'] = 3;
            }elseif($data['rateAvg'] > 2){
                $data['rateAvgRound'] = 2.5;
            }elseif($data['rateAvg'] > 1.5){
                $data['rateAvgRound'] = 2;
            }elseif($data['rateAvg'] > 1){
                $data['rateAvgRound'] = 1.5;
            }elseif($data['rateAvg'] > 0.5){
                $data['rateAvgRound'] = 1;
            }elseif($data['rateAvg'] > 0){
                $data['rateAvgRound'] = 0.5;
            }else{
                $data['rateAvgRound'] = 1;
            }
            
            $this->_cache->setData($data);
            $this->_itemData = $data;
        }else{          
            $fields = array(
                'rateToId'      => $rateToId,
                'rateToType'    => $rateToType,
            );
            $this->create($fields);
            return $this->findByRateIdAndType($rateToId, $rateToType);
        }
        return true;
    }
}

?>