<?php

require_once('../../lib/config.php');

$search = isset($_REQUEST['term']) ? $_REQUEST['term'] : '';

$params = array(
    'type'      => 'login',
    'search'    => $search,
);

$users = $User->findUsersBy($params);
if(count($users['items']) == 0) exit;
$data = array();
foreach ($users['items'] as $user){
    $data[] = $user['login'];
}
//add_to_log(print_r($data,true),'zzz');
echo json_encode($data);
