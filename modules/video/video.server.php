<?php

require_once('video.common.php');

function saveVideo($fields)
{
    global $smarty;
    parse_str($fields, $data);
    $objResponse = new xajaxResponse();
    $DBFactory   = Registry::get('DBFactory');
    $Session     = Registry::get('Session');
    $userId      = $Session->get_value($data['s'], 'user_id');

    if(empty($data['link'])){
        $objResponse->addAlert('Please fill Youtube links!');
        $objResponse->addScript('$("#btnSubmit").attr("disabled", false);');
        return $objResponse;
    }
    $albumName  = isset($data['album_name']) ? $data['album_name'] : '';
    $albumId    = isset($data['album_id']) ? $data['album_id'] : '';
    if(empty($albumId) && empty($albumName)){
        $objResponse->addAlert('Please fill album name!');
        $objResponse->addScript('$("#btnSubmit").attr("disabled", false);');
        return $objResponse;
    }

    if(empty($albumId)){
        $album = new VideoAlbum($DBFactory->get_db_handle('rakscom'));
        if($album->findByParam('name', $albumName)){
            $albumId = $album->id;
        }else{

            $albumData = array(
                'name'          => $albumName,
                'created_time'  => time(),
                'owner_type'    => 'user',
                'owner_id'      => $userId,
            );
            $album->create($albumData);
            $albumId = $album->id;
        }
    }

    foreach ($data['link'] as $key => $curData){

        if(empty($data['link'][$key])) continue;
        $video = new Video($DBFactory->get_db_handle('rakscom'));
        $parsedLink = $video->parseLink($data['link'][$key]);
        if($parsedLink === false){
            $objResponse->addAlert('Cannot parse YouTube Code!');
            $objResponse->addScript('$("#btnSubmit").attr("disabled", false);');
            return $objResponse;
        }
        $fields = array(
            'album_id' 		=> $albumId,
            'name' 			=> isset($data['name'][$key]) ? isset($data['name'][$key]) : '',
            'description' 	=> isset($data['description'][$key]) ? $data['description'][$key] : '',
            'youtube_id'	=> $parsedLink,
            'owner_id'		=> $userId,
            'owner_type'	=> 'user',
            'created_time'	=> time(),
        );
        $video->create($fields);
        if(isset($data['tags'][$key])){
            $data['tags'][$key] = array_unique($data['tags'][$key]);
            foreach($data['tags'][$key] as $tag){
                $videoTag = new VideoTag($DBFactory->get_db_handle('rakscom'));
                $tagData = array(
                    'videoId'   => $video->id,
                    'tag'       => $tag,
                );
                $videoTag->create($tagData);
            }
        }
        $smarty->assign('youtubeId', $parsedLink);
        $smarty->assign('videoWidth', 560);
        $smarty->assign('videoHeight', 314);
        $data = $smarty->fetch('modules/video/i_youtube_video.tpl');

        $objResponse->addAppend('videoUploaded', 'innerHTML', $data);

    }
    //$objResponse->addAlert('ololo');
    $objResponse->addScript('$("#btnSubmit").attr("disabled", false);');
    $data = '';
    for($i = 0; $i < 3; $i++){
        $smarty->assign('lineId', $i);
        $data .= $smarty->fetch('modules/video/i_video_line.tpl');
    }
    //$objResponse->addAlert('ololo');
    $objResponse->addAssign('videoItemsContainer', 'innerHTML', $data);
    return $objResponse;
}

function setVideoContent($fields)
{
    global $smarty;
    parse_str($fields, $data);
    $objResponse = new xajaxResponse();
    $DBFactory   = Registry::get('DBFactory');
    $Session     = Registry::get('Session');
    $userId      = $Session->get_value($data['s'], 'user_id');

    if(empty($data['link'])){
        $objResponse->addAlert('Please fill Youtube link!!');
        return $objResponse;
    }
    $video = new Video($DBFactory->get_db_handle('rakscom'));
    $parsedLink = $video->parseLink($data['link']);
    if($parsedLink === false){
        $objResponse->addAlert('Cannot parse YouTube Code!');
        return $objResponse;
    }
    $video->findById($data['video_id']);
    $video->name 		= $data['name'];
    $video->description = $data['description'];
    $video->youtube_id 	= $parsedLink;

    if(isset($data['tags'])){
        $data['tags'] = array_unique($data['tags']);
        foreach($data['tags'] as $tag){
            $videoTag = new VideoTag($DBFactory->get_db_handle('rakscom'));
            $tagData = array(
                'videoId'   => $video->id,
                'tag'       => $tag,
            );
            $videoTag->create($tagData);
        }
    }

    $smarty->assign('s', $data['s']);
    $smarty->assign('user_id', $userId);
    $smarty->assign('video', $video);
    $res = $smarty->fetch('modules/video/i_video_content.tpl');
    $objResponse->addAssign('videoDataInfo_'.$data['video_id'], 'innerHTML', $res);
    $objResponse->addScript('closeVideoEdit('.$data['video_id'].');');
    return $objResponse;
}

function setVideoRating($videoId, $points, $s)
{
    $objResponse    = new xajaxResponse();
    $points         = ($points >= 1 && $points <= 5) ? $points : 0;
    if($points == 0) return $objResponse;
    $DBFactory      = Registry::get('DBFactory');
    $Session        = Registry::get('Session');
    $userId         = $Session->get_value($s, 'user_id');
    if(empty($userId)) return $objResponse;

    $Rates          = new Rates($DBFactory->get_db_handle('rakscom'));
    $lastRate       = $Rates->getLastRateByFrom($videoId, 'video', $userId, 'user');
    if($lastRate !== false /*&& $lastRate->rateTime + 60 > time()*/) {
        $objResponse->addScript('xajax_getVideoRating('.$videoId.', "'.$s.'")');
        return $objResponse;
    }
    $Rate = new Rate($DBFactory->get_db_handle('rakscom'));
    $rateData = array(
        'rateToId'      => $videoId,
        'rateToType'    => 'video',
        'rateFromType'  => 'user',
        'rateFromId'    => $userId,
        'ratePoints'    => $points,
        'rateTime'      => time(),
    );
    $Rate->create($rateData);
    $objResponse->addScript('xajax_getVideoRating('.$videoId.', "'.$s.'")');
    return $objResponse;
}

function getVideoRating($videoId, $s)
{
    global $smarty;
    $objResponse = new xajaxResponse();
    $DBFactory  = Registry::get('DBFactory');
    $Session  = Registry::get('Session');
    $userId = $Session->get_value($s, 'user_id');

    $RateAgr = new RateAgr($DBFactory->get_db_handle('rakscom'));
    $RateAgr->findByRateIdAndType($videoId, 'video');
    $Rates = new Rates($DBFactory->get_db_handle('rakscom'));
    $lastRate = $Rates->getLastRateByFrom($videoId, 'video', $userId, 'user');
    if($lastRate !== false){
        $smarty->assign('cannotVote', true);
    }

    $smarty->assign('s', $s);
    $smarty->assign('user_id', $userId);
    $smarty->assign('videoId', $videoId);
    $smarty->assign('rateAgr', $RateAgr);
    $data = $smarty->fetch('modules/video/i_rating_video.tpl');
    $objResponse->addAssign('video_rating_'.$videoId, 'innerHTML', $data);
    return $objResponse;
}

function addVideoComment($fields)
{
    global $smarty;
    parse_str($fields, $data);
    $objResponse = new xajaxResponse();
    $DBFactory   = Registry::get('DBFactory');
    $Session     = Registry::get('Session');
    $userId      = $Session->get_value($data['s'], 'user_id');
    //$objResponse->addAlert($fields);
    //return $objResponse;
    if(empty($data['comment'])){
        $objResponse->addAlert('Please enter comment!');
        return $objResponse;
    }
    $comment = new Comment($DBFactory->get_db_handle('rakscom'));

    $fields = array(
        'itemId' 		=> $data['video_id'],
        'itemType' 		=> 'video',
        'comment' 		=> $data['comment'],
        'timeCreated'	=> time(),
        'createdBy'		=> $userId,
    );
    $comment->create($fields);
    $video          = new Video($DBFactory->get_db_handle('rakscom'));
    $video->findById($data['video_id']);
    $videoComments = $video->getComments();
    $smarty->assign('videoComments', $videoComments);
    $smarty->assign('s', $data['s']);
    $data = $smarty->fetch('modules/video/i_video_comments.tpl');
    $objResponse->addAssign('videoComments', 'innerHTML', $data);
    return $objResponse;
}

function showVideoEdit($videoId, $s)
{
    global $smarty;
    $objResponse = new xajaxResponse();
    $DBFactory  = Registry::get('DBFactory');
    $Session  = Registry::get('Session');
    $userId = $Session->get_value($s, 'user_id');

    $smarty->assign('s', $s);
    $video = new Video($DBFactory->get_db_handle('rakscom'));
    $video->findById($videoId);
    $smarty->assign('user_id', $userId);
    $smarty->assign('video', $video);

    $data = $smarty->fetch('modules/video/i_video_update.tpl');
    $objResponse->addAssign('dialog-video-update-'.$videoId, 'innerHTML', $data);
    //$objResponse->addScriptCall('$( "#dialog-video-update-"+videoId ).dialog("close")');
    return $objResponse;
}




function addMoreVideo()
{
    global $smarty;
    $objResponse	= new xajaxResponse();
    $id 			= md5(microtime(true));
    $smarty->assign('lineId', $id);
    $data 			= $smarty->fetch('modules/video/i_video_line.tpl');
    $objResponse->addAppend('videoItemsContainer', 'innerHTML', $data);
    //$objResponse->addAssign($id, 'innerHTML', $data);
    return $objResponse;
}


function showVideoAlbumEdit($videoAlbumId, $s)
{
    global $smarty;
    $objResponse = new xajaxResponse();
    $DBFactory  = Registry::get('DBFactory');
    $Session  = Registry::get('Session');
    $userId = $Session->get_value($s, 'user_id');

    $smarty->assign('s', $s);
    $videoAlbum = new VideoAlbum($DBFactory->get_db_handle('rakscom'));
    $videoAlbum->findById($videoAlbumId);
    $smarty->assign('user_id', $userId);
    $smarty->assign('videoAlbum', $videoAlbum);

    $data = $smarty->fetch('modules/video/i_video_album_name.tpl');
    $objResponse->addAssign('dialog-video-album-update-'.$videoAlbumId, 'innerHTML', $data);
    return $objResponse;
}

function setVideoAlbumName($fields)
{
    global $smarty;
    parse_str($fields, $data);
    $objResponse = new xajaxResponse();
    $DBFactory   = Registry::get('DBFactory');
    $Session     = Registry::get('Session');
    $userId      = $Session->get_value($data['s'], 'user_id');
    if($userId != $data['video_album_id'] ){
        $objResponse->addAlert('You are not allowed!');
        return $objResponse;
    }

    $videoAlbum = new VideoAlbum($DBFactory->get_db_handle('rakscom'));
    $videoAlbum->findById($data['video_album_id']);

    $videoAlbum->name 		= $data['name'];

    $smarty->assign('s', $data['s']);
    $smarty->assign('user_id', $userId);
    $smarty->assign('videoAlbum', $videoAlbum);
    $objResponse->addScript('closeVideoAlbumEdit('.$data['video_album_id'].');');
    return $objResponse;
}

$xajax->processRequests();
?>