<?php

function smarty_modifier_proto($string, $proto)
{
    if(preg_match('/^\w+\:\/\//i', $string)) return $string;
    return $proto.'://'.$string;   
}

/* vim: set expandtab: */

?>
