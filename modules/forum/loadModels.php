<?php

$DBFactory = Registry::get('DBFactory');
$db_params = Registry::get('db_params');
$DBFactory->add_db_handle("forum",$db_params['forum']['server'],$db_params['forum']['database'],
    $db_params['forum']['user'],$db_params['forum']['password']);

?>