<?php

function articleActionEdit( ActionProcessor $actionProcessor )
{
    $templator = $actionProcessor->getParam('templator');
    $errors = array();
    $name = isset($_REQUEST['name']) ? $_REQUEST['name'] : '';
    $sectionId = isset($_REQUEST['section_id']) ? $_REQUEST['section_id'] : '';
    $contentShort = isset($_REQUEST['content_short']) ? $_REQUEST['content_short'] : '';
    $content = isset($_REQUEST['content']) ? $_REQUEST['content'] : '';
    $articleId = isset($_REQUEST['article_id']) ? $_REQUEST['article_id'] : '';
    if(empty($name)) $errors['name'] = array('message'=>'Please set name of article!');
    if(empty($sectionId)) $errors['section_id'] = array('message'=>'Please set section!');
    if(empty($contentShort)) $errors['content_short'] = array('message'=>'Please set short content!');
    if(empty($content)) $errors['content'] = array('message'=>'Please set content!');
    if (count($errors) > 0) {
        $templator->assign('errors', $errors);
        return array(
            'ok'        => false,
            'article_id' => $articleId,
            'go'        => "edit",
        );
    }
    $Session    = Registry::get('Session');
    $sessionId  = Registry::get('s');
    $DBFactory  = Registry::get('DBFactory');
    $userId     = $Session->get_value($sessionId, 'user_id');
    if(empty($userId)) {
        header('Location: /');
        exit;
    }
    $article = new Article($DBFactory->get_db_handle('rakscom'));
    $article->findById($articleId);
    $article->name = $name;
    $article->section_id = $sectionId;
    $article->content_short = $contentShort;
    $article->content = $content;
    $article->is_enabled = 'N';
    $article->approved_time = 0;


    $go = $actionProcessor->getParam($actionProcessor->getGoName());
    return array(
        'ok'        => true,
        'urlParams' => array(
            'go'        => $go,
            'article_id'  => $articleId,
            's'         => $sessionId,
        ),
    );
}

?>