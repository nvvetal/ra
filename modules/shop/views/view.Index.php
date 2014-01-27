<?php
function shopViewIndex(View $View){
    $returnParams                   = array();
    $DBFactory                      = Registry::get('DBFactory');
    $Shops 	                        = new Shops($DBFactory->get_db_handle('rakscom'));
    $shopsData                     	= $Shops->all();
    $returnParams['shopsData']     	= $shopsData;
    return $returnParams;
}

?>