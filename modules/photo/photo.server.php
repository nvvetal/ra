<?php

require_once('photo.common.php');

function getPhotoComments($photoId, $s){
    global $smarty;
    $photoId = intval($photoId);
    $objResponse = new xajaxResponse();
    $DBFactory  = Registry::get('DBFactory');
    $Session  = Registry::get('Session');
    $userId = $Session->get_value($s, 'user_id');    
    $Comments = new Comments($DBFactory->get_db_handle('rakscom'));
    $photoComments = $Comments->getCommentsByPhoto($photoId);
    $smarty->assign('s', $s);
    $smarty->assign('user_id', $userId);
    $smarty->assign('photoId', $photoId);
    $smarty->assign('photoComments', $photoComments);
    $data = $smarty->fetch('modules/photo/i_comments.tpl');
    $objResponse->addAssign('comments', 'innerHTML', $data);
    return $objResponse; 
}

function addPhotoComment($dataParse, $s)
{
    $objResponse = new xajaxResponse();
    parse_str($dataParse, $data);
    if(empty($data['comment'])){
        $objResponse->addScript('xajax_getPhotoComments('.$data['photo_id'].', "'.$s.'")');
        return $objResponse;        
    }
    $DBFactory  = Registry::get('DBFactory');
    $Session  = Registry::get('Session');
    $userId = $Session->get_value($s, 'user_id');
    $Comment = new Comment($DBFactory->get_db_handle('rakscom'));
    $commentData = array(
        'itemType'  => 'photo',
        'itemId'    => $data['photo_id'],
        'comment'   => $data['comment'],
        'timeCreated'   => time(),
        'createdBy' => $userId,
    );
    $Comment->create($commentData);
    $objResponse->addScript('xajax_getPhotoComments('.$data['photo_id'].', "'.$s.'")');
    return $objResponse; 
}

function getPhotoRating($photoId, $s)
{
    global $smarty;
    $objResponse = new xajaxResponse();
    $DBFactory  = Registry::get('DBFactory');
    $Session  = Registry::get('Session');
    $userId = $Session->get_value($s, 'user_id');
    
    $RateAgr = new RateAgr($DBFactory->get_db_handle('rakscom'));
    $RateAgr->findByRateIdAndType($photoId, 'photo');
    $Rates = new Rates($DBFactory->get_db_handle('rakscom'));
    $lastRate = $Rates->getLastRateByFrom($photoId, 'photo', $userId, 'user');
    if($lastRate !== false){
        $smarty->assign('cannotVote', 1);
    }  

    $smarty->assign('s', $s);
    $smarty->assign('user_id', $userId);
    $smarty->assign('photoId', $photoId);        
    $smarty->assign('rateAgr', $RateAgr);        
    $data = $smarty->fetch('modules/photo/i_rating.tpl');
    $objResponse->addAssign('votings', 'innerHTML', $data);
    return $objResponse;     
}

function setPhotoRating($photoId, $points, $s)
{
    $objResponse = new xajaxResponse();
    //$objResponse->addAlert($points);
    $points = ($points >= 1 && $points <= 5) ? $points : 0;
    if($points == 0) return $objResponse;
    $DBFactory  = Registry::get('DBFactory');
    $Session  = Registry::get('Session');
    $userId = $Session->get_value($s, 'user_id');
    if(empty($userId)) return $objResponse; 
    
    $Rates = new Rates($DBFactory->get_db_handle('rakscom'));
    $lastRate = $Rates->getLastRateByFrom($photoId, 'photo', $userId, 'user');
    if($lastRate !== false /*&& $lastRate->rateTime + 60 > time()*/) {    
        $objResponse->addScript('xajax_getPhotoRating('.$photoId.', "'.$s.'")');
        return $objResponse;             
    }
    $Rate = new Rate($DBFactory->get_db_handle('rakscom'));
    $rateData = array(
        'rateToId'      => $photoId,
        'rateToType'    => 'photo',
        'rateFromType'  => 'user',
        'rateFromId'    => $userId,
        'ratePoints'    => $points,
        'rateTime'      => time(),
    );
    $Rate->create($rateData);
    $objResponse->addScript('xajax_getPhotoRating('.$photoId.', "'.$s.'")');
    return $objResponse; 
}

function getPhotoAdditional($photoId, $s, $showWithoutAlbum = false)
{
    global $smarty;
    $objResponse = new xajaxResponse();
    $DBFactory  = Registry::get('DBFactory');
    $Session  = Registry::get('Session');
    $userId = $Session->get_value($s, 'user_id');
    $smarty->assign('s', $s);
    $smarty->assign('user_id', $userId);
    $smarty->assign('photoId', $photoId); 
    $RateAgr = new RateAgr($DBFactory->get_db_handle('rakscom'));
    $RateAgr->findByRateIdAndType($photoId, 'photo');    
    $Comments = new Comments($DBFactory->get_db_handle('rakscom'));
    $photoComments = $Comments->getCommentsByPhoto($photoId); 
    
    $Photo    = new Photo($DBFactory->get_db_handle('rakscom'));
    $Photo->findById($photoId);
    
    $Rates = new Rates($DBFactory->get_db_handle('rakscom'));
    $lastRate = $Rates->getLastRateByFrom($photoId, 'photo', $userId, 'user');
    if($lastRate !== false){
        $smarty->assign('cannotVote', 1);
    }      
     
    $smarty->assign('photoObj', $Photo);
    $smarty->assign('albumObj', $Photo->getAlbum());
    $smarty->assign('photoComments', $photoComments);
    $smarty->assign('rateAgr', $RateAgr);
    $smarty->assign('showWithoutAlbum', $showWithoutAlbum);
    $smarty->assign('isOwner', ($userId == $Photo->getOwnerUserId()));
    $data = $smarty->fetch('modules/photo/i_rating.tpl');
    $objResponse->addAssign('votings', 'innerHTML', $data);   
    
    $data = $smarty->fetch('modules/photo/i_comments.tpl');
    $objResponse->addAssign('comments', 'innerHTML', $data);     
    
    $data = $smarty->fetch('modules/photo/i_album.tpl');
    $objResponse->addAssign('album', 'innerHTML', $data);       
    return $objResponse;                 
}

function showEditPhoto($photoId, $s)
{
	global $smarty;
	$objResponse = new xajaxResponse();
	$DBFactory  = Registry::get('DBFactory');
	$Session    = Registry::get('Session');
	$userId     = $Session->get_value($s, 'user_id');
	$smarty->assign('s', $s);
	$smarty->assign('user_id', $userId);
	$smarty->assign('photoId', $photoId);
	$Photo      = new Photo($DBFactory->get_db_handle('rakscom'));
	$Photo->findById($photoId);
	$smarty->assign('photoObj', $Photo);
	$Albums     = new Albums($DBFactory->get_db_handle('rakscom'));
	$userAlbums = $Albums->byOwner($Photo->owner_type, $Photo->owner_id, 'DESC', 1, 10000);
	$smarty->assign('albums', $userAlbums);
	$smarty->assign('album_id', $Photo->album_id);
	$data = $smarty->fetch('modules/photo/i_photo_edit.tpl');
	$objResponse->addAssign('ajax-dialog', 'innerHTML', $data);
	$objResponse->addScript('showEditPhoto("'.$photoId.'","'.$s.'")');
	return $objResponse;
}

function savePhotoData($dataParse, $s)
{
	global $smarty;
	parse_str($dataParse, $data);
	$objResponse = new xajaxResponse();
	$DBFactory  = Registry::get('DBFactory');
	$Session    = Registry::get('Session');
	$userId     = $Session->get_value($s, 'user_id');
	$smarty->assign('s', $s);
	$smarty->assign('user_id', $userId);
	$smarty->assign('photoId', $data['photo_id']);
	$Photo      = new Photo($DBFactory->get_db_handle('rakscom'));
	$Photo->findById($data['photo_id']);
	if($userId != $Photo->getOwnerUserId()){
		$objResponse->addAlert('You are not owner of this photo!!!');
		return $objResponse;
	}
	$Photo->name = $data['name'];
	$Photo->album_id = $data['album_id'];
	$Photo->description = $data['description'];
	//$objResponse->addAlert('Data saved successfully!');
    $objResponse->addScript('xajax_getPhotoAdditional('.$data['photo_id'].', "'.$s.'")');
	return $objResponse;
}

function setPhotoAlbumName($fields)
{
    global $smarty;
    parse_str($fields, $data);
    $objResponse = new xajaxResponse();
    $DBFactory   = Registry::get('DBFactory');
    $Session     = Registry::get('Session');
    $userId      = $Session->get_value($data['s'], 'user_id');
    if($userId != $data['photo_album_id'] ){
        $objResponse->addAlert('You are not allowed!');
        return $objResponse;
    }

    $photoAlbum = new Album($DBFactory->get_db_handle('rakscom'));
    $photoAlbum->findById($data['photo_album_id']);

    $photoAlbum->name 		= $data['name'];

    $smarty->assign('s', $data['s']);
    $smarty->assign('user_id', $userId);
    $smarty->assign('photoAlbum', $photoAlbum);
    $objResponse->addScript('closePhotoAlbumEdit('.$data['photo_album_id'].');');
    return $objResponse;
}

function showPhotoAlbumEdit($photoAlbumId, $s)
{
    global $smarty;
    $objResponse = new xajaxResponse();
    $DBFactory  = Registry::get('DBFactory');
    $Session  = Registry::get('Session');
    $userId = $Session->get_value($s, 'user_id');

    $smarty->assign('s', $s);
    $photoAlbum = new Album($DBFactory->get_db_handle('rakscom'));
    $photoAlbum->findById($photoAlbumId);
    $smarty->assign('user_id', $userId);
    $smarty->assign('photoAlbum', $photoAlbum);

    $data = $smarty->fetch('modules/photo/i_photo_album_name.tpl');
    $objResponse->addAssign('dialog-photo-album-update-'.$photoAlbumId, 'innerHTML', $data);
    return $objResponse;
}

$xajax->processRequests();
?>