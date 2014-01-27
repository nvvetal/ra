<?php
function articleViewArticle(View $View){
    $returnParams = array();
    $DBFactory  = Registry::get('DBFactory');
    $articleSections = new ArticleSections($DBFactory->get_db_handle('rakscom'));
    $articleId = isset($_REQUEST['article_id']) ? (int)$_REQUEST['article_id'] : 0;
    $article = new Article($DBFactory->get_db_handle('rakscom'));
    $article->findById($articleId);
    $articleSection = new ArticleSection($DBFactory->get_db_handle('rakscom'));
    $articleSection->findById($article->section_id);
    $returnParams['article'] = $article;
    $returnParams['article_id'] = $articleId;
    $returnParams['articleSection'] = $articleSection;
    return $returnParams;
}

?>