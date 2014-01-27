<?php
function articleViewAdd(View $View){

    $returnParams = array();
    $DBFactory  = Registry::get('DBFactory');
    $articleSections = new ArticleSections($DBFactory->get_db_handle('rakscom'));
    $returnParams['articleSections'] = $articleSections->all(1, 0, 'name ASC');
    return $returnParams;
}

