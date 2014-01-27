<?php
include_once("class.linkmoney.php");

if (is_array($_GET) && $_GET){
    $encoding = (isset($_GET['encoding']))?$_GET['encoding']:null;
    $start = abs(isset($_GET['start'])?$_GET['start']:1);
    $start = ($start < 1)?1:$start;
    $end   = abs(isset($_GET['end'])?$_GET['end']:0);
    $url   = isset($_GET['url'])?$_GET['url']:'';
    if ($end){
        $num_links      = abs($end - $start)+1;
        $lastLinknumber = $start-1;
    }else{
        $num_links      = 0;
        $lastLinknumber = $start-1;
    }
    echo $lm->getLinksSsi($num_links, $lastLinknumber, $url, $encoding);
}else{
    echo $lm->getLinksSsi();
}
