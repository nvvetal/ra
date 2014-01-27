<?php

function smarty_modifier_raks_name($string)
{
	$value = get_raks_money_name($string);
    return $value;
}

/* vim: set expandtab: */

?>
