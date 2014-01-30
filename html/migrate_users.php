<?php

if(!isset($_REQUEST['pass']) || $_REQUEST['pass'] != 'sdafs34dtw43w645') exit;
set_time_limit(3600);
require_once ('../lib/config.php');
require_once ('../lib/CurlWrapper.php');

$q = "
    SELECT u.*, pf.pf_name as first_name
    FROM phpbb_users as u
    LEFT JOIN phpbb_profile_fields_data AS pf ON (u.user_id = pf.user_id)
    ORDER BY u.user_id ASC
    LIMIT 10000
";

$data = SQLGetRows($q, $DBFactory->get_db_handle('forum'));

$Images = Registry::get('Images');
$User = new User($DBFactory->get_db_handle('rakscom'));

foreach ($data as $userData){
    add_to_log('[starting '.$userData['user_id'].']', 'migrate');
    $uParams = array(
        'login'     => $userData['username'],
        'password'  => $userData['user_password'],
        'email'     => $userData['user_email'],
        'state'     => 'active',
    );
    $userId = $User->register_user($uParams);
    if($userId === false) {
        add_to_log('[exists '.$userData['user_id'].']', 'migrate');
        continue;
    }
    $needConvert = true;
    $t = 0;
    $file = '';
    if(empty($userData['user_avatar'])){
//nothing
        $needConvert = false;
    }elseif(substr($userData['user_avatar'], 0, 4) == 'http'){
        $ch = new CurlWrapper();
        $ch->init();
        $ch->setOpt(CURLOPT_POST, 0);
        $ch->setOpt(CURLOPT_URL, $userData['user_avatar']);
        $ch->setOpt(CURLOPT_TIMEOUT, 5);
        $ch->setOpt(CURLOPT_RETURNTRANSFER, 1);

        $data = $ch->execute();
        if( $ch->curlErrno() ){
            add_to_log('[error fetch image '.$userData['user_avatar'].'][error '.$ch->curlError().']', 'migrate');
            $file = '';
        }elseif($ch->curlGetInfo(CURLINFO_HTTP_CODE) !== 200){
            add_to_log('[error fetch image by curl code '.$userData['user_avatar'].']', 'migrate');
            $file = '';
        }else{
            $pData = parse_url($userData['user_avatar']);
            $ext = 'png';
            if(preg_match('/\.(\w+)$/i', $pData['path'], $m)){
                $ext = $m[1];
            }
            $file = $GLOBALS['IMAGE_UPLOAD_FORUM_ORIGINAL_PATH'].md5(microtime(true).mt_rand(10000,1000000)).'.'.$ext;
            file_put_contents($file, $data);
        }
        $t = 1;
    }elseif(strpos('/', $userData['user_avatar'])){
        $file = $GLOBALS['IMAGE_FORUM_AVATAR_PATH'].$userData['user_avatar'];
        $t = 2;
    }else{
        $file = $GLOBALS['IMAGE_FORUM_AVATAR_PATH'].'upload/3953387675efec4c0bd9ae15685ad5ca_'.$userData['user_avatar'];
        $t = 3;
        if(!file_exists($file)){
            $file = $GLOBALS['IMAGE_FORUM_AVATAR_PATH'].'upload/c9589b706a984dcdeb11717419bb6a50_'.$userData['user_avatar'];
            $t = 4;
        }
    }
    if(!file_exists($file)) {
        $t = $t+100;
        $needConvert = false;
    }

    $imageId = 0;
    if($needConvert){
        $res = $Images->copy_image($file, $GLOBALS['IMAGE_UPLOAD_ORIGINAL_PATH']);
        $imageId = ($res['res'] == true) ? $res['ID'] : 0;
    }

    //images/avatars/upload
    $params = array(
        'forum'         => $userData['user_id'],
        'image_id'      => $imageId,
        'is_activated'  => 1,
        'p_sex'         => 'female',
        'p_first_name'  => $userData['first_name'],
        'p_hobby'       => $userData['user_interests'],
        'p_icq'         => $userData['user_icq'],
        'p_url'         => str_replace('http://', '' ,$userData['user_website']),
        'p_profession'  => $userData['user_occ'],
        'state'         => 'active',
    );
    if(preg_match("/^(\d{2})\-(\d{2})-{\d{4}}$/i",$userData['user_birthday'])){
        $params['p_birthday']    = $userData['user_birthday'];
    }



    add_to_log(
        '[forumUserId '.$userData['user_id'].']'.
        '[userId '.$userId.']'.
        '[t '.$t.']'.
        '[avatar '.$userData['user_avatar'].']'.
        '[imageId '.$imageId.']'.
        '[file '.$file.']'.
        '[fBirthday '.$userData['user_birthday'].']'.
        '[fName '.$userData['first_name'].']'.
        '[fInterests '.$userData['user_interests'].']'.
        '[fUrl '.$userData['user_website'].']'.
        '[fProfession '.$userData['user_occ'].']'
    ,'migrate');

    foreach ($params as $pk=>$pval){
        $User->set_value($userId, $pk, $pval);
    }

    if($imageId > 0)$Images->assign_image($imageId, $userId, 'user');
    add_to_log('[finish '.$userData['user_id'].']', 'migrate');
}