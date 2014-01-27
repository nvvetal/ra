<?php

require_once('article.common.php');

function getArticleComments($articleId, $s){
    global $smarty;
    $articleId = intval($articleId);
    $objResponse = new xajaxResponse();
    $DBFactory  = Registry::get('DBFactory');
    $Session  = Registry::get('Session');
    $userId = $Session->get_value($s, 'user_id');
    $Comments = new Comments($DBFactory->get_db_handle('rakscom'));
    $articleComments = $Comments->getCommentsByArticle($articleId);
    $smarty->assign('s', $s);
    $smarty->assign('user_id', $userId);
    $smarty->assign('articleId', $articleId);
    $smarty->assign('articleComments', $articleComments);
    $data = $smarty->fetch('modules/article/i_comments.tpl');
    $objResponse->addAssign('comments', 'innerHTML', $data);
    return $objResponse;
}

function addArticleComment($dataParse, $s)
{
    $objResponse = new xajaxResponse();
    parse_str($dataParse, $data);
    if(empty($data['comment'])){
        $objResponse->addScript('xajax_getArticleComments('.$data['article_id'].', "'.$s.'")');
        return $objResponse;
    }
    $DBFactory  = Registry::get('DBFactory');
    $Session  = Registry::get('Session');
    $userId = $Session->get_value($s, 'user_id');
    $Comment = new Comment($DBFactory->get_db_handle('rakscom'));
    $commentData = array(
        'itemType'  => 'article',
        'itemId'    => $data['article_id'],
        'pItemId'    => !empty($data['p_item_id']) ? (int)$data['p_item_id'] : 0,
        'comment'   => $data['comment'],
        'timeCreated'   => time(),
        'createdBy' => $userId,
    );
    $Comment->create($commentData);
    $objResponse->addScript('xajax_getArticleComments('.$data['article_id'].', "'.$s.'")');
    return $objResponse;
}

function getArticleRating($articleId, $s)
{
    global $smarty;
    $objResponse = new xajaxResponse();
    $DBFactory  = Registry::get('DBFactory');
    $Session  = Registry::get('Session');
    $userId = $Session->get_value($s, 'user_id');

    $RateAgr = new RateAgr($DBFactory->get_db_handle('rakscom'));
    $RateAgr->findByRateIdAndType($articleId, 'article');
    $Rates = new Rates($DBFactory->get_db_handle('rakscom'));
    $lastRate = $Rates->getLastRateByFrom($articleId, 'article', $userId, 'user');
    if($lastRate !== false){
        $smarty->assign('cannotVote', 1);
    }

    $smarty->assign('s', $s);
    $smarty->assign('user_id', $userId);
    $smarty->assign('articleId', $articleId);
    $smarty->assign('rateAgr', $RateAgr);
    $data = $smarty->fetch('modules/article/i_rating.tpl');
    $objResponse->addAssign('votings', 'innerHTML', $data);
    return $objResponse;
}

function setArticleRating($articleId, $points, $s)
{
    $objResponse = new xajaxResponse();
    //$objResponse->addAlert($points);
    $points = ($points >= 1 && $points <= 5) ? $points : 0;
    if($points == 0) return $objResponse;
    $DBFactory  = Registry::get('DBFactory');
    $Session  = Registry::get('Session');
    $userId = $Session->get_value($s, 'user_id');
    if(empty($userId)) return $objResponse;

    $Rates = new Rates($DBFactory->get_db_handle('rakscom'));
    $lastRate = $Rates->getLastRateByFrom($articleId, 'article', $userId, 'user');
    if($lastRate !== false /*&& $lastRate->rateTime + 60 > time()*/) {
        $objResponse->addScript('xajax_getArticleRating('.$articleId.', "'.$s.'")');
        return $objResponse;
    }
    $Rate = new Rate($DBFactory->get_db_handle('rakscom'));
    $rateData = array(
        'rateToId'      => $articleId,
        'rateToType'    => 'article',
        'rateFromType'  => 'user',
        'rateFromId'    => $userId,
        'ratePoints'    => $points,
        'rateTime'      => time(),
    );
    $Rate->create($rateData);
    $objResponse->addScript('xajax_getArticleRating('.$articleId.', "'.$s.'")');
    return $objResponse;
}

function getArticleAdditional($articleId, $s)
{
    global $smarty;
    $objResponse = new xajaxResponse();
    $DBFactory  = Registry::get('DBFactory');
    $Session  = Registry::get('Session');
    $userId = $Session->get_value($s, 'user_id');
    $smarty->assign('s', $s);
    $smarty->assign('user_id', $userId);
    $smarty->assign('articleId', $articleId);
    $RateAgr = new RateAgr($DBFactory->get_db_handle('rakscom'));
    $RateAgr->findByRateIdAndType($articleId, 'article');
    $Comments = new Comments($DBFactory->get_db_handle('rakscom'));
    $articleComments = $Comments->getCommentsByArticle($articleId);

    $Article    = new Article($DBFactory->get_db_handle('rakscom'));
    $Article->findById($articleId);

    $Rates = new Rates($DBFactory->get_db_handle('rakscom'));
    $lastRate = $Rates->getLastRateByFrom($articleId, 'article', $userId, 'user');
    if($lastRate !== false){
        $smarty->assign('cannotVote', 1);
    }
    $smarty->assign('articleObj', $Article);
    $smarty->assign('articleComments', $articleComments);
    $smarty->assign('rateAgr', $RateAgr);
    $smarty->assign('isOwner', ($userId == $Article->getOwnerUserId()));
    $data = $smarty->fetch('modules/article/i_rating.tpl');
    $objResponse->addAssign('votings', 'innerHTML', $data);

    $data = $smarty->fetch('modules/article/i_comments.tpl');
    $objResponse->addAssign('comments', 'innerHTML', $data);

    return $objResponse;
}


$xajax->processRequests();
?>