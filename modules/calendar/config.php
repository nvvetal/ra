<?php
$module_name = "calendar";
require_once("../../lib/config.php");

$calendarPrices = array(
    'makeCalendarVIP' => 300,
);
Registry::set('calendarPrices', $calendarPrices);

?>