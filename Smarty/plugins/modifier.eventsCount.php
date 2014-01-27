<?php

function smarty_modifier_eventsCount($type)
{
    $cnt = 0;
    switch ($type)
    {
        case "all":
        case "gifts":
            require_once($GLOBALS['MODULES_DIR'].'shop/ShopUserItem.class.php');    
            require_once($GLOBALS['MODULES_DIR'].'shop/ShopUserItems.class.php');
            $maxPeriod                  = Registry::get('GiftMaxNewPeriod');
            $DBFactory                  = Registry::get('DBFactory');
            $dbh                        = $DBFactory->get_db_handle('rakscom');
            $Session                    = Registry::get('Session');
            $sessId                     = Registry::get('s');
            $currentUserId              = $Session->get_value($sessId, 'user_id');    
            $shopUserItems              = new ShopUserItems($dbh);
            $cnt                        = $shopUserItems->getUserNewGiftsCount($currentUserId, $maxPeriod);
        break;
    }
    return $cnt;
}

?>
