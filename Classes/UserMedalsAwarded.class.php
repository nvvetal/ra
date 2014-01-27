<?php
class UserMedalsAwarded extends API_List 
{
    protected $_itemObjName = 'UserMedalAwarded';
    
    public function byParent($parentKey, $parentValue, $sortBy, $order = 'DESC', $page = 1, $perPage = 0)
    {
        $data = parent::byParent($parentKey, $parentValue, $sortBy);
        if($data['cnt'] == 0 ) return $data;
		$group = array();
        foreach ($data['items'] as $key => $item){
        	if(isset($group[$item->medal_id])) {
        		unset($data['items'][$key]);
        		continue;
			}
            $UserMedal = new UserMedal($this->_dbh);
            $UserMedal->findById($item->medal_id);
			
            $data['items'][$key]->assignObj('medal', $UserMedal);
			$group[$item->medal_id] = 1;
        }
        
        return $data;
    }
}

?>