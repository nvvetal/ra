<?php
function articleViewList(View $View){
    $returnParams                   = array();
    $DBFactory                      = Registry::get('DBFactory');
    $articleSections                = new ArticleSections($DBFactory->get_db_handle('rakscom'));
    $articles                       = new Articles($DBFactory->get_db_handle('rakscom'));
    $sortBy = isset($_REQUEST['sort_by']) ? $_REQUEST['sort_by'] : '';
    $sortOrder = isset($_REQUEST['sort_ord']) && $_REQUEST['sort_ord'] = 'inc' ? 'ASC' : 'DESC';
    $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
    $perPage = isset($_REQUEST['perPage']) ? $_REQUEST['perPage'] : 5;
    $sectionId = isset($_REQUEST['section_id']) ? (int) $_REQUEST['section_id'] : 0;
    $params = array(
        'order'     => $sortOrder,
        'page'      => $page,
        'perPage'   => $perPage,
        'sectionId' => $sectionId,
        'enabled'   => true,
    );
    if(in_array($sortBy, array('author','name','time'))) $params['orderBy'] = $sortBy;
    $returnParams['lastArticles'] = $articles->sortByParams($params);
    $returnParams['articleSections'] = $articleSections->all(1, 0, 'name ASC');
    $returnParams['sectionId'] = $sectionId;
    return $returnParams;
}

?>