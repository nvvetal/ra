<?php
$module_name = "schools";
require_once("../../lib/config.php");

$schoolPrices = array(
    'makeSchoolVIP' => 500,
    'makeSchoolTop' => 300,
);
Registry::set('schoolPrices',$schoolPrices);
