<?php

class Raks{
	private $_dbh;
	
    private $_rules = array(
        'forumEnter' => array(
            'count'     => 30,
            'period'    => '+1 month',
        ),
        'forumEnterDaily' => array(
            'count'     => 2,
            'period'    => '+1 day',
        ),        
        'register' => array(
            'count'     => 30,
        ),
        'forumMessage' => array(
            'count' => array(
                'firstWeek'     => 1,
                'nextWeek'      => 1,
            ),
        ),   
        'forumMedal'   => array(
            'count' => 40,
        ),
        'forumRank'   => array(
            'count' => 40,
        ),
        'forumConcurs' =>array(
            'count' => array(
                '1st' => 100,
                '2nd' => 80,
                '3rd' => 60,
            ),
        ),
    );
    
    public function __construct($dbh){
        $this->_dbh = $dbh;
		$this->_initRules();
		//var_dump($this->_rules);
	}
	
	private function _initRules()
	{
		$Config = Registry::get('Config');
		$params = $Config->get_params();
		$this->_initRule(array(), $this->_rules, $params);
	}
	
	private function _initRule($ruleKeys, &$rules, $params)
	{
		$Config = Registry::get('Config');
		foreach ($rules as $ruleName => &$ruleValue){
			
			if(is_array($ruleValue)){
				//$ruleKeys[] = $ruleName;
				$this->_initRule(array_merge($ruleKeys, array($ruleName)), $ruleValue, $params);
				continue;
			}
			$ruleFullName = implode('::', array_merge($ruleKeys, array($ruleName)));
			if(!isset($params[$ruleFullName])){
				$Config->set_param($ruleFullName, $ruleValue);
			}else{
				$ruleValue = $Config->get_param($ruleFullName);
			}
		}
	}

    
    public function addMoney($userId, $amount, $rule = '')
    {
		$User = new User($this->_dbh);
		$User->inc_raks_money($userId, $amount);
		$this->_addRaksHistory($userId, $amount, $rule);
		return true;
    }
	
	private function _addRaksHistory($userId, $amount, $rule)
	{
		$fields = array(
			'user_id' 		=> $userId,
			'amount'		=> $amount,
			'rule'			=> $rule,
			'time_action' 	=> time(),			
		);
		SQLInsert('raks_history', $fields, $this->_dbh);	
	}
    
    public function addMoneyByRule($userId, $rule, $params)
    {
        if(!isset($this->_rules[$rule])) return false;
		$ruleData = $this->_rules[$rule];
		if(!is_array($ruleData['count']) && !isset($ruleData['period'])) 
			return $this->addMoney($userId, $ruleData['count'], $rule);
		
		//cheking only period
		if(!is_array($ruleData['count'])){
			$canAdd = $this->_canAddRaksByPeriod($userId, $rule, $ruleData['period']);
			if(!$canAdd) return false;
			return $this->addMoney($userId, $ruleData['count'], $rule);
		}
		
		//not chek period
		if(is_array($ruleData['count'])){
			if(!isset($params['countType'])) return false;
			$amount = $ruleData['count'][$params['countType']];
			return $this->addMoney($userId, $amount, $rule);
		}
		
		return $this->addMoney($userId, $ruleData['count'], $rule);
    }


	private function _canAddRaksByPeriod($userId, $rule, $period)
	{
		$q = "
			SELECT time_action
			FROM raks_history
			WHERE user_id = ".SQLQuote($userId)." AND rule = ".SQLQuote($rule)." 	
			ORDER BY time_action DESC
			LIMIT 1			
		";
		
		$data = SQLGet($q, $this->_dbh);
		return (!isset($data['time_action']) || strtotime($period, $data['time_action']) < time()) ? true : false;
	}
}

?>