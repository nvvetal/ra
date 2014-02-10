<?php
function articleViewIndex(View $View){
    $returnParams                   = array();
    $DBFactory                      = Registry::get('DBFactory');
    $articleSections                = new ArticleSections($DBFactory->get_db_handle('rakscom'));
    $articles                       = new Articles($DBFactory->get_db_handle('rakscom'));

    $returnParams['articleSections'] = $articleSections->all(1, 0, 'name ASC');
    $returnParams['lastArticles'] = $articles->byTime('DESC', 1, 5, array('enabled' => true));
    $returnParams['bestArticles'] = $articles->getMaxRated('article', 1, 5, array('enabled' => true));
    return $returnParams;
}

?>