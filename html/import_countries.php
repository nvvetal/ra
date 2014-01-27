<?php
set_time_limit(180);
require_once('../lib/config.php');

$countries = array();
$content = file_get_contents('../Countries.txt');
$content = str_replace('"', '', $content);
$content = str_replace("\r", '', $content);
$data = explode("\n", $content);

foreach ($data as $key=>$countryStr){
	if($key == 0) continue;
	$country = explode(',', $countryStr);
	if($country[1] == 'Ukraine') continue;	
	$countries[$country[0]]['name'] = $country[1];
	$countries[$country[0]]['short_name'] = $country[6];
	
}


$content = file_get_contents('../Regions.txt');
$content = str_replace('"', '', $content);
$content = str_replace("\r", '', $content);
$data = explode("\n", $content);

foreach ($data as $key=>$regionStr){
	if($key == 0) continue;
	$region = explode(',', $regionStr);
	if($region[1] == 251) continue;
	$countries[$region[1]]['regions'][$region[0]]['name'] = $region[2];
}

$content = file_get_contents('../cities.txt');
$content = str_replace('"', '', $content);
$content = str_replace("\r", '', $content);
$data = explode("\n", $content);

foreach ($data as $key=>$cityStr){
	if($key == 0) continue;
	$city = explode(',', $cityStr);
	if($city[1] == 251) continue;
	$countries[$city[1]]['regions'][$city[2]]['cities'][$city[0]]['name'] = $city[3];
}

echo "<pre>";
var_dump($countries);
$dbh = $DBFactory->get_db_handle("rakscom");
foreach ($countries as $countryId => $countryData){
	//insert country
	$cId = 	SQLInsert('countries', array('name' => $countryData['name'], 'short_name' => $countryData['short_name']), $dbh);
	foreach ($countryData['regions'] as $regionId => $regionData){
		//insert region
		$rId = 	SQLInsert('country_subdivisions', array('name' => $regionData['name'], 'country_id' => $cId), $dbh);
		if(!isset($regionData['cities'])) continue;
		foreach ($regionData['cities'] as $cityId => $cityData){
			//insert city
			SQLInsert('cities', array('name' => $cityData['name'], 'country_id' => $cId, 'subdivision_id' => $rId), $dbh);
		}
	}
}

?>