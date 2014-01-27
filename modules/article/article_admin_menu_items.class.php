<?php

require_once($GLOBALS['CLASSES_DIR'].'MenuItem.class.php');
require_once($GLOBALS['MODULES_DIR'].'article/config.php');
require_once($GLOBALS['MODULES_DIR'].'article/Article.class.php');
require_once($GLOBALS['MODULES_DIR'].'article/Articles.class.php');
require_once($GLOBALS['MODULES_DIR'].'article/ArticleSection.class.php');
require_once($GLOBALS['MODULES_DIR'].'article/ArticleSections.class.php');

class article_admin_menu_items extends MenuItem{

    function article_admin_menu_items(){
        $this->MenuItem();
    }

    function get_id(){
        return "articles";
    }

    function get_name(){
        return "Article";
    }

    function get_module(){
        return "article";
    }

    function init_menu(){
        $this->menu = array(
            'Articles'=>array(
                'id'=>'articles',
                'is_url'=>1,
            ),
        );
    }

    //PAGES
    function page_default($params){

        $params['smarty']->assign('http_module_path',$GLOBALS['HTTP_PROJECT_PATH'].$params['module'].'/');
        $DBFactory  = Registry::get('DBFactory');
        $articles = new Articles($DBFactory->get_db_handle('rakscom'));
        $articlesSorted = $articles->sortByCreatedAndApprovedTime();
        $params['smarty']->assign('articles', $articlesSorted);
        $go = !empty($params['ago']) ? $params['ago'] : $params['a_sid'];
        $data = $params['smarty']->fetch($params['template_path'].$go.'.tpl');
        return $data;
    }

    function page_edit($params){
        $params['smarty']->assign('http_module_path',$GLOBALS['HTTP_PROJECT_PATH'].$params['module'].'/');
        $DBFactory  = Registry::get('DBFactory');
        $articleId = isset($_REQUEST['article_id'])?$_REQUEST['article_id']:"";
        $article = new Article($DBFactory->get_db_handle('rakscom'));
        $article->findById($articleId);
        $params['smarty']->assign('article', $article);
        $articleSections = new ArticleSections($DBFactory->get_db_handle('rakscom'));
        $articleSections = $articleSections->all(1, 0, 'name ASC');
        $params['smarty']->assign('articleSections', $articleSections);
        $go = !empty($params['ago']) ? $params['ago'] : $params['a_sid'];
        $data = $params['smarty']->fetch($params['template_path'].$go.'.tpl');
        return $data;
    }

    //ACTIONS
    function act_edit_article($params){
        $errors = array();
        $name = isset($_REQUEST['name']) ? $_REQUEST['name'] : '';
        $sectionId = isset($_REQUEST['section_id']) ? $_REQUEST['section_id'] : '';
        $contentShort = isset($_REQUEST['content_short']) ? $_REQUEST['content_short'] : '';
        $content = isset($_REQUEST['content']) ? $_REQUEST['content'] : '';
        $reason = isset($_REQUEST['reason']) ? $_REQUEST['reason'] : '';
        $articleId = isset($_REQUEST['article_id']) ? $_REQUEST['article_id'] : '';
        if(empty($name)) $errors['name'] = array('message'=>'Please set name of article!');
        if(empty($sectionId)) $errors['section_id'] = array('message'=>'Please set section!');
        if(empty($contentShort)) $errors['content_short'] = array('message'=>'Please set short content!');
        if(empty($content)) $errors['content'] = array('message'=>'Please set content!');
        if (count($errors) > 0) {
            $params['smarty']->assign('errors', $errors);
            return 'edit';
        }
        $DBFactory  = Registry::get('DBFactory');
        $article = new Article($DBFactory->get_db_handle('rakscom'));
        $article->findById($articleId);
        $article->name = $name;
        $article->section_id = $sectionId;
        $article->content_short = $contentShort;
        $article->content = $content;
        $article->reason = $reason;
        return $params['ago'];
    }

    function act_delete_article($params){
        $articleId = isset($_REQUEST['article_id'])?$_REQUEST['article_id']:"";
        $DBFactory  = Registry::get('DBFactory');
        $article = new Article($DBFactory->get_db_handle('rakscom'));
        $article->findById($articleId);
        $article->delete();

        return $params['ago'];
    }

    function act_enable_article($params){
        $articleId = isset($_REQUEST['article_id'])?$_REQUEST['article_id']:"";
        $DBFactory  = Registry::get('DBFactory');
        $article = new Article($DBFactory->get_db_handle('rakscom'));
        $article->findById($articleId);
        $article->is_enabled = 'Y';
        $article->approved_time = time();
        if($article->approve_cnt == 0){
            $raksMoney = Registry::get('articlePrices');
            $params['User']->inc_raks_money($article->owner_id, $raksMoney['makeArticleEnabled']);
            $Payment = Registry::get('Payment');
            $Payment->addStats($article->owner_id, 'article_enabled', 1);
            $Payment->addStats($article->owner_id, 'raks_in', $raksMoney['makeArticleEnabled']);
        }
        $fromUserId = $params['Session']->get_value(@$_REQUEST['s'],'user_id');
        $i18n = Registry::get('i18n');
        $subject = $i18n->get_translate(Registry::get('lang'),'Article enabled message subject','article');
        $params['smarty']->assign('articleId', $articleId);
        $message = $params['smarty']->fetch('modules/article/admin/article_approved_message.tpl');
        $mParams = array(
            'fromUserId' => $fromUserId,
            'toUserId' => $article->owner_id,
            'subject' => $subject,
            'message' => $message,
        );
        require_once($GLOBALS['CLASSES_DIR'].'Messaging.class.php');
        $Messaging = new Messaging();
        $Messaging->sendMessage($mParams);

        $article->approve_cnt++;
        return $params['ago'];
    }


    function act_disable_article($params){
        $articleId = isset($_REQUEST['article_id'])?(int) $_REQUEST['article_id']:0;
        $reason = isset($_REQUEST['reason'])?$_REQUEST['reason']:"";
        $DBFactory  = Registry::get('DBFactory');
        $article = new Article($DBFactory->get_db_handle('rakscom'));
        $article->findById($articleId);
        $article->is_enabled = 'N';
        $article->approved_time = time();
        $article->reason = $reason;
        $fromUserId = $params['Session']->get_value(@$_REQUEST['s'],'user_id');
        $i18n = Registry::get('i18n');
        $subject = $i18n->get_translate(Registry::get('lang'),'Article disabled message subject','article');
        $mParams = array(
            'fromUserId' => $fromUserId,
            'toUserId' => $article->owner_id,
            'subject' => $subject.' ['.$article->name.']',
            'message' => $reason,
        );
        require_once($GLOBALS['CLASSES_DIR'].'Messaging.class.php');
        $Messaging = new Messaging();
        $Messaging->sendMessage($mParams);
        return $params['ago'];

    }


}

?>