<?php

function blog_firm_bl ( $go, &$container_class, &$smarty ){

	
	$action =  @$_REQUEST["action"];
	
	switch ($go){
		case "show_blogs":
		
			switch ($action){
				case "add_blog":
					$params=array(
						"post_text"=>@$_REQUEST['post_text'],
						"firm_id"=>@$_REQUEST['firm_id'],
					);
				
					$res = $container_class->call_method($action,$params);
					
					
					if($container_class->is_valid($res)){
						echo "new element is - $res";
					}else{
						print_r($container_class->get_errors($res));
					}
					
				
				break;
			}
		
		break;
	}
	
	return $go;
}

?>