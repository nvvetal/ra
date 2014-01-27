<?php
require_once ('config.php');

$q = "
    SELECT u.*, pf.pf_name as first_name
    FROM phpbb_users as u
    LEFT JOIN phpbb_profile_fields_data AS pf ON (u.user_id = pf.user_id)
    ORDER BY u.user_id ASC
    LIMIT 100    
";

$data = SQLGetRows($q, $DBFactory->get_db_handle('forum'));

$Images = Registry::get('Images');
$User = new User($DBFactory->get_db_handle('rakscom'));

foreach ($data as $userData){
	$file = '../modules/forum/images/avatars/upload/3953387675efec4c0bd9ae15685ad5ca_'.$userData['user_avatar'];
	$needConvert = true;
	if(!file_exitsts($file)){
		$file = '../modules/forum/images/avatars/upload/c9589b706a984dcdeb11717419bb6a50_'.$userData['user_avatar'];
		if(file_exists($file)) $needConvert = false;
	}
	$imageId = 0;
	if($needConvert){
   		$res = $Images->copy_image($file, $GLOBALS['IMAGE_UPLOAD_ORIGINAL_PATH']);
    	$imageId = ($res['res'] != true) ? $res['ID'] : 0; 	
	}
	//images/avatars/upload
    $params = array(
        'forum'         => $userData['user_id'],
        'image_id'      => $imageId,
        'is_activated'  => 1,
        'p_birthday'    => $userData['user_birthday'],

        'p_first_name'  => $userData['first_name'],
        'p_hobby'       => $userData['user_interests'],
        'p_icq'         => $userData['user_icq'],
        'p_url'         => str_replace('http://', '' ,$userData['user_website']),
        'p_profession'  => $userData['user_occ'],
    );	
	
    
	$uParams = array(
		'login' 	=> $userData['username'],
		'password'	=> $userData['user_password'],
		'email'		=> $userData['user_email'],
		'state'		=> 'active',
	);	
	$userId = $User->register_user($uParams);
	
	foreach ($params as $pk=>$pval){
		$User->set_user_value($userId, $pk, $pval);
	}
	
	if($imageId > 0)$Images->assign_image($imageId, $userId, 'user');
}
/*
p_hobby
p_icq
p_sex
p_skype
p_url
*/
?>