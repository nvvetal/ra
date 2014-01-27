<?php

function smarty_modifier_bbcode($string)
{
   	$string = preg_replace("/\n/i", "<br />", $string);
	$string = preg_replace("/\[b\]/i","<b>", $string);
	$string = preg_replace("/\[\/b\]/i","</b>", $string);
	$string = preg_replace("/\[i\]/i","<i>", $string);
	$string = preg_replace("/\[\/i\]/i","</i>", $string);
	$string = preg_replace("/\[u\]/i","<u>", $string);
	$string = preg_replace("/\[\/u\]/i","</u>", $string);

	$string = preg_replace("/\[center\]/i","<p style=\"text-align: center;\">", $string);

	$string = preg_replace("/\[\/center\]/i","</p>",$string);	
	

	$string = preg_replace("/\[left\]/i","<p style=\"text-align: left;\">", $string);
	$string = preg_replace("/\[\/left\]/i","</p>", $string);	
	$string = preg_replace("/\[right\]/i","<p style=\"text-align: right;\">", $string);
	
	$string = preg_replace("/\[\/right\]/i","</p>", $string);						
	
	$string = preg_replace("/\[url=([^\]]+)\](.*?)\[\/url\]/i","<a href=\"$1\">$2</a>", $string);
	
	$string = preg_replace("/\[url\](.*?)\[\/url\]/i","<a href=\"$1\">$1</a>", $string);
	$string = preg_replace("/\[img\](.*?)\[\/img\]/i","<img src=\"$1\" />", $string);
	$string = preg_replace("/\[color=(.*?)\](.*?)\[\/color\]/i","<font color=\"$1\">$2</font>", $string);
	$string = preg_replace("/\[quote.*?\](.*?)\[\/quote\]/i","<span class=\"quoteStyle\">$1</span>&nbsp;", $string);
	return $string;
}

?>
