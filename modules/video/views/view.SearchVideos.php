<?php
function videoViewSearchVideos(View $View){
    $returnParams               = array();
    $search                     = isset($_REQUEST['search']) ? $_REQUEST['search'] : '';
    $page                       = isset($_REQUEST['page']) ? intval($_REQUEST['page']) : 0;
    $perPage                    = 10;    
    $DBFactory                  = Registry::get('DBFactory');
    $Session                    = Registry::get('Session');
    $sessionId                  = Registry::get('s');
    $userId                     = $Session->get_value($sessionId, 'user_id');
    $Videos                    	= new Videos($DBFactory->get_db_handle('rakscom'));
    $searchVideos             	= $Videos->searchGlobal($search, $page, $perPage);
    
    $returnParams['searchVideos'] = $searchVideos;      
    return $returnParams;
}

?>