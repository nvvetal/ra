<?php
if($_REQUEST['pass'] != 'ollooolo') exit;
set_time_limit(3600);
require_once('../lib/config.php');
header('Content-Type: text/html; charset=utf-8');

$data = mb_convert_encoding(file_get_contents('../1.txt'), 'UTF-8', 'Windows-1251');
$countries = explode("\r\n", $data);

$final = array();

foreach ($countries as $countryData){
    $countryFields = explode(';', $countryData);

    $final[$countryFields[0]]['data'] = $countryFields[1];
	
    $subdivisions = json_decode(preg_replace("/(\d+):/im", "\"$1\":", file_get_contents('http://loveplanet.ru/?a=geojson&fs=reg_'.$countryFields[0])), true);
	foreach($subdivisions as $subId=>$subdivisionName){

		$final[$countryFields[0]]['sudivisions'][$subId]['data'] = $subdivisionName;
    	$cities = json_decode(preg_replace("/(\d+):/im", "\"$1\":", file_get_contents('http://loveplanet.ru/?a=geojson&fs=cities_'.$subId)), true);
		foreach($cities as $key2=>$cityName){
			$final[$countryFields[0]]['sudivisions'][$subId]['cities'][$key2]['data'] = $cityName;
		}
	}

    //http://loveplanet.ru/?a=geojson&fs=cities_4312
    //echo"<pre>";
    //var_dump($final);
    //exit;
    //break;
}

foreach ($final as $countryData){
   
    $fields = array(
        'name' => $countryData['data'],
    );
    $countryId = SQLInsert('countries2', $fields, $DBFactory->get_db_handle("rakscom"));
     
    foreach($countryData['sudivisions'] as $subdivisionData){
        $fields = array(
            'country_id'    => $countryId,
            'name'          => $subdivisionData['data'],
        );
        $subdivisionId = SQLInsert('country_subdivisions2', $fields, $DBFactory->get_db_handle("rakscom"));
        
        foreach($subdivisionData['cities'] as $cityData){
            $fields = array(
                'country_id'        => $countryId,
                'subdivision_id'    => $subdivisionId,
                'name'              => $cityData['data'],
            ); 
            SQLInsert('cities2', $fields, $DBFactory->get_db_handle("rakscom"));           
        }        
    }    
}

?>