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
    $string = preg_replace("/\[s\]/i","<s>", $string);
    $string = preg_replace("/\[\/s\]/i","</s>", $string);

	$string = preg_replace("/\[url=([^\]]+)\](.*?)\[\/url\]/i","$1", $string);
	$string = preg_replace("/\[url\]([^\[]+)\[\/url\]/i","$1", $string);
	$string = preg_replace("/\[size=([^\]]+)\](.*?)\[\/size\]/i","<font size=\"$1\">$2</font>", $string);

	$string = preg_replace("/\[url\](.*?)\[\/url\]/i","<a href=\"$1\">$1</a>", $string);
	$string = preg_replace("/\[img\](.*?)\[\/img\]/i","<img src=\"$1\" />", $string);
	$string = preg_replace("/\[color=(.*?)\](.*?)\[\/color\]/i","<font color=\"$1\">$2</font>", $string);
	$string = preg_replace("/\[quote.*?\](.*?)\[\/quote\]/i","<span class=\"quoteStyle\">$1</span>&nbsp;", $string);
    #http://daringfireball.net/2010/07/improved_regex_for_matching_urls
	/*
    $pattern = '(?i)\b((?:[a-z][\w-]+:(?:/{1,3}|[a-z0-9%])|www\d{0,3}[.]|[a-z0-9.\-]+[.][a-z]{2,4}/)(?:[^\s()<>]+|\(([^\s()<>]+|(\([^\s()<>]+\)))*\))+(?:\(([^\s()<>]+|(\([^\s()<>]+\)))*\)|[^\s`!()\[\]{};:\'".,<>?«»“”‘’]))';
    $string = preg_replace_callback("#$pattern#i", function($matches) {
        $input = $matches[1];
        $url = preg_match('!^https?://!i', $input) ? $input : "http://$input";
        return '<a href="' . $url . '">'.$url.'</a>';
    }, $string);
	*/
	return $string;
}