<?php

function smarty_modifier_url($text)
{
    $pattern = '(?xi)\b((?:https?://|www\d{0,3}[.]|[a-z0-9.\-]+[.][a-z]{2,4}/)(?:[^\s()<>]+|\(([^\s()<>]+|(\([^\s()<>]+\)))*\))+(?:\(([^\s()<>]+|(\([^\s()<>]+\)))*\)|[^\s`!()\[\]{};:\'".,<>?«»“”‘’]))';
    return preg_replace_callback("#$pattern#i", function($matches) {
        $input = $matches[0];
        $url = preg_match('!^https?://!i', $input) ? $input : "http://$input";
        return '<a href="' . $url . '" rel="nofollow" target="_blank">' . "$input</a>";
    }, $text);
}


