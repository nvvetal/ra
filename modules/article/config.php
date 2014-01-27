<?php
$module_name = "article";
require_once("../../lib/config.php");

$articlePrices = array(
    'makeArticleEnabled' => 100,
);
Registry::set('articlePrices', $articlePrices);
