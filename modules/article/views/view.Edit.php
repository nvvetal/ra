<?php
function articleViewEdit(View $View){
    $returnParams = array();
    $DBFactory  = Registry::get('DBFactory');
    $articleId = isset($_REQUEST['article_id']) ? (int)$_REQUEST['article_id'] : 0;
    $articleSections = new ArticleSections($DBFactory->get_db_handle('rakscom'));
    $article = new Article($DBFactory->get_db_handle('rakscom'));
    $article->findById($articleId);
    $returnParams['articleSections'] = $articleSections->all(1, 0, 'name ASC');
    $returnParams['article'] = $article;
    return $returnParams;
}

?>