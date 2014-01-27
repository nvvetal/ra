<?php

function smarty_modifier_isGiftNew($string)
{
    $maxPeriod = Registry::get('GiftMaxNewPeriod');
    return (time() < ($string)*1 + $maxPeriod) ? 'new' : 'old';
}

?>
