<?php
function schoolsViewSchools(View $View){
    $DBFactory = Registry::get('DBFactory');
    $user = Registry::get('User');
    $geo = Registry::get('Geo');
    $dbh =  $DBFactory->get_db_handle('rakscom');
    $school = new school($dbh);
    $searchData = $user->get_session_data('get_schools_search');
    $order_by = (isset($_REQUEST['order_by']) && in_array($_REQUEST['order_by'],array('last','name'))) ? $_REQUEST['order_by'] : 'last';
    $city_id = (isset($_REQUEST['city_id'])) ? intval($_REQUEST['city_id']) : $searchData['city_id'];
    $subdivision_id = (isset($_REQUEST['subdivision_id'])) ? intval($_REQUEST['subdivision_id']) : $searchData['subdivision_id'];
    $country_id = (isset($_REQUEST['country_id'])) ? intval($_REQUEST['country_id']) :  $searchData['country_id'];
    $page = (isset($_REQUEST['page'])) ? intval($_REQUEST['page']) : $searchData['page'];
    $per_page = (isset($_REQUEST['per_page'])) ? intval($_REQUEST['per_page']) : $searchData['per_page'];
    if($per_page < 1) $per_page = 25;
    if($page < 1) $page = 1;
    $country = array('id' => 0);
    $subdivision = array('id' => 0);
    $city = array('id' => 0);
    if(!empty($city_id)){
        $city = $geo->get_city($city_id);
        $country = $geo->get_country($city['country_id']);
        $subdivision = $geo->get_subdivision($city['subdivision_id']);
    }elseif(!empty($subdivision_id)){
        $subdivision = $geo->get_subdivision($subdivision_id);
        $country = $geo->get_country($subdivision['country_id']);
    }elseif(!empty($country_id)){
        $country = $geo->get_country($country_id);
    }



    $schoolsSearchData = array(
        'order_by'          => $order_by,
        'city_id'           => $city_id,
        'subdivision_id'    => $subdivision_id,
        'country_id'        => $country_id,
        'per_page'          => $per_page,
        'page'              => $page,
    );

    $schools = $school->get_schools_search($schoolsSearchData);
    if(count($schools) == 0 && $page > 1){
        $page = 1;
        $schoolsSearchData['page'] = 1;
        $schools = $school->get_schools_search($schoolsSearchData);
    }

    $user->set_session_data('get_schools_search', $schoolsSearchData);
    $returnParams = array(
        'page'              => $page,
        'per_page'          => $per_page,
        'order_by'          => $order_by,
        'schools'           => $schools,
        'country'           => $country,
        'subdivision'       => $subdivision,
        'city'              => $city,
        'school_pages'      => $school->get_schools_search_cnt($schoolsSearchData),
    );

    //echo "<pre>";
    //var_dump($returnParams);
    return $returnParams;
}
