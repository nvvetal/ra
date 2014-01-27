<?php

function articleActionAdd( ActionProcessor $actionProcessor )
{
    $templator = $actionProcessor->getParam('templator');
    $errors = array();
    require_once("captcha/recaptchalib.php");
    $resp = recaptcha_check_answer($GLOBALS['CAPTCHA']['private'], $_SERVER["REMOTE_ADDR"], $_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]);
    if (!$resp->is_valid) {
        $errors['captcha'] = array('message'=>'Wrong captcha!');
    }
    $name = isset($_REQUEST['name']) ? $_REQUEST['name'] : '';
    $sectionId = isset($_REQUEST['section_id']) ? $_REQUEST['section_id'] : '';
    $contentShort = isset($_REQUEST['content_short']) ? $_REQUEST['content_short'] : '';
    $content = isset($_REQUEST['content']) ? $_REQUEST['content'] : '';
    if(empty($name)) $errors['name'] = array('message'=>'Please set name of article!');
    if(empty($sectionId)) $errors['section_id'] = array('message'=>'Please set section!');
    if(empty($contentShort)) $errors['content_short'] = array('message'=>'Please set short content!');
    if(empty($content)) $errors['content'] = array('message'=>'Please set content!');
    if (count($errors) > 0) {
        $templator->assign('errors', $errors);
        return array(
            'ok'        => false,
            'go'        => "add",
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
    $data = array(
        'section_id' => $sectionId,
        'name'  => $name,
        'content_short'  => $contentShort,
        'content'  => $content,
        'owner_id' => $userId,
        'created_time' => time(),
        'is_enabled' => 'N',
    );
    $articleRes = $article->create($data);

    $go = $actionProcessor->getParam($actionProcessor->getGoName());
    return array(
        'ok'        => true,
        'urlParams' => array(
            'go'        => $go,
            'article_id'  => $articleRes['id'],
            's'         => $sessionId,
        ),
    );
}

?>