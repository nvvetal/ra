<?php

function smarty_modifier_maxstring($string,$length=100)
{
    $currentLen = mb_strlen($string);
    $string = mb_substr($string,0,$length,'UTF-8');
    if($currentLen > $length) $string .= "...";
	return $string;
}
?>