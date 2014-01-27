<?php

class MenuItem {
	var $menu = array();
	
	function MenuItem(){
		
		if(method_exists($this,'init_menu')){
			$this->init_menu();
		}
	}	
	
	function generate_menu($params,$selected_id=0){
		$menu = array();
		$this->fetch_menu_items($params,$menu,$this->menu,$selected_id);
		return $menu;
	}
	
	function fetch_menu_items($params,&$r_menu,&$g_menu,$selected_id){
		foreach ($g_menu as $name=>$item){
			$m_item = array();
			
			$is_need_childs = true;
			
			
			//echo $this->get_template();
			switch (@$item['type']){
				case "function":
					$cb = 'cb_'.$item['method'];
					if(method_exists($this,$cb)){
						$data = $this->$cb($params);
						if(is_array($data) && count($data)>0){
							foreach ($data as $d_key=>$d_item){
								$m_item = array();
								$m_item['name']=$d_item[$item['url_params']['menu_item_name']];
								if(isset($item['is_url'])) $m_item['is_url'] = $item['is_url'];

								if(isset($item['url_params']['menu_item_id'])){
									$m_item['id']=$item['id'].'_'.$d_item[$item['url_params']['menu_item_id']];
								}
								if(count($item['url_params']) > 0 ){
									foreach ($item['url_params'] as $p_name=>$p_key){
										if(strpos($p_name,'menu_item_') === false){
										    $m_item['url'][$p_name]=@$d_item[$p_key];
										}
									}
								}
								unset($m_item['url']['menu_item_name']);
								if(isset($item['additional_url_params']) && count($item['additional_url_params']) > 0 ){
									foreach ($item['additional_url_params'] as $p_name=>$p_key){
										$m_item['url'][$p_name]=$p_key;
									}
								}
								$params['parent_data']=$d_item;
								$r_menu[$m_item['name']]=$m_item;
								if(isset($item['childs'])){
									$r_menu[$m_item['name']]['childs']=array();
									$this->fetch_menu_items($params, $r_menu[$m_item['name']]['childs'],$item['childs'],$selected_id);
								}
								
							}
						}
						$is_need_childs = false;
					}
				break;
				
				case "require_function_data":
					$m_item['name']=$name;
					$m_item['id']=$item['id'];
					if(count($item['url_params']) > 0 ){
						
						foreach ($item['url_params'] as $p_name=>$p_key){
							if(strpos($p_key,'menu_item_') === false)$m_item['url'][$p_name]=@$params['parent_data'][$p_key];
						}
					}
				break;
				
				default:
					$m_item['name']=$name;
					$m_item['id']=$item['id'];
					if(isset($item['additional_url_params']) && count($item['additional_url_params']) > 0 ){
					    foreach ($item['additional_url_params'] as $p_name=>$p_key){
						$m_item['url'][$p_name]=$p_key;
					    }
					}
				break;
			}
			
			
			if($is_need_childs){
				$r_menu[$name]=$m_item;
				if(isset($item['childs'])){
					$r_menu[$name]['childs']=array();
					$this->fetch_menu_items($params,$r_menu[$name]['childs'],$item['childs'],$selected_id);
				}
			}
			if($item['id'] === $selected_id && isset($r_menu[$name])){
				$r_menu[$name]['is_selected']=1;
			}
	    
			if(isset($item['is_url']) && isset($r_menu[$name])) $r_menu[$name]['is_url'] = $item['is_url'];

		}
	}


}

?>