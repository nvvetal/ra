<?php
function articleViewArticle(View $View){
    $returnParams = array();
    $DBFactory  = Registry::get('DBFactory');
    $Images  = Registry::get('Images');
    $articleSections = new ArticleSections($DBFactory->get_db_handle('rakscom'));
    $articleId = isset($_REQUEST['article_id']) ? (int)$_REQUEST['article_id'] : 0;
    $article = new Article($DBFactory->get_db_handle('rakscom'));
    $article->findById($articleId);
    $articleSection = new ArticleSection($DBFactory->get_db_handle('rakscom'));
    $articleSection->findById($article->section_id);
    $returnParams['article'] = $article;
    $returnParams['article_id'] = $articleId;
    $returnParams['articleSection'] = $articleSection;
    $articleImage = ($article->image_id > 0) ? $GLOBALS['HTTP_IMAGES_PATH'].$Images->get_image_url($article->image_id, 200, 200,'jpg') : $GLOBALS['HTTP_PROJECT_ROOT'].'images/logo_real_krug_1024.png';
    $returnParams['articleImage'] = $articleImage;

    $templator = Registry::get('templator');
    $templator->assign('metaTitle', $article->name);
    $templator->assign('metaDescription', $article->content);
    $metaIMG = $GLOBALS['HTTP_IMAGES_PATH'].$Images->get_image_url_center_square($article->image_id, 500, 'jpg');
    $templator->assign('metaIMG', $metaIMG);
    return $returnParams;
}
