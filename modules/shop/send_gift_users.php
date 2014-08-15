<?php

require_once('shop.common.php');
$dbh = $DBFactory->get_db_handle('rakscom');
$users = $User->getAll();
$giftId = 1084;
$shopGood = new ShopGood($dbh);
$shopGood->findById($giftId);
$ShopUserItem = new ShopUserItem($dbh);
$message = "С Днем Независимости! Слава Украине!";
$fromUserId = 38607;
foreach($users as $user){
    $toUserId = $user['user_id'];
    $ShopUserItem->addUserGift($fromUserId, $toUserId, $giftId, $message);
}