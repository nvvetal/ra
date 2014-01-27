<?php

function get_linkmoney_links(){
    require_once("class.linkmoney.php");
    return iconv('windows-1251','utf-8',$lm->getLinks());
}

