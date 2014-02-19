<?php

function smarty_modifier_eventsCount($type)
{
    $data = array(
        'all'           => 0,
        'gifts'         => 0,
        'photoComments' => 0,
        'videoComments' => 0,
    );

    $DBFactory                  = Registry::get('DBFactory');
    $dbh                        = $DBFactory->get_db_handle('rakscom');
    $Session                    = Registry::get('Session');
    $sessId                     = Registry::get('s');
    $currentUserId              = $Session->get_value($sessId, 'user_id');

    //gifts
    require_once($GLOBALS['MODULES_DIR'].'shop/ShopUserItem.class.php');
    require_once($GLOBALS['MODULES_DIR'].'shop/ShopUserItems.class.php');
    $maxPeriod                  = Registry::get('GiftMaxNewPeriod');
    $shopUserItems              = new ShopUserItems($dbh);
    $cnt                        = $shopUserItems->getUserNewGiftsCount($currentUserId, $maxPeriod);
    $data['gifts'] += $cnt;
    $data['all'] += $cnt;

    //comments
    require_once($GLOBALS['CLASSES_DIR'].'Comments.class.php');
    $commentsObj = new Comments($dbh);
    $maxPeriod                  = Registry::get('CommentMaxNewPeriod');
    $cnt = $commentsObj->getUserNewCommentsCount($currentUserId, 'photo', $maxPeriod);
    $data['photoComments'] += $cnt;
    $data['all'] += $cnt;
    $cnt = $commentsObj->getUserNewCommentsCount($currentUserId, 'video', $maxPeriod);
    $data['videoComments'] += $cnt;
    $data['all'] += $cnt;

    //getUserNewCommentsCount
    return $data[$type];
}

?>
