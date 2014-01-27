<?php

require_once('../../lib/config.php');

$search = isset($_REQUEST['term']) ? $_REQUEST['term'] : '';

if(empty($search)) {
	exit;	
}

require_once('VideoTags.class.php');
require_once('VideoTag.class.php');

$enteredTags = array_unique(explode(" ", $search));
$lastTag = $enteredTags[count($enteredTags)-1];

$prevTags = '';
if(count($enteredTags) > 1){
	unset($enteredTags[count($enteredTags)-1]);
	$prevTags = implode(' ', $enteredTags);
}

//if(in_array($lastTag, $prevTags)) exit;
if(empty($lastTag)) {
	exit;	
}


$tagsObj = new VideoTags($DBFactory->get_db_handle('rakscom'));
$tags = $tagsObj->byWord($lastTag);
if(count($tags) == 0) exit;
$data = array();
foreach ($tags as $tag){
	if(in_array($tag, $enteredTags)) continue;
	if(empty($prevTags)){
		$data[] = $tag;
	}else{
		$data[] = $prevTags.' '.$tag;
	}
	
}
//add_to_log(print_r($data,true),'zzz');
echo json_encode($data);
?>