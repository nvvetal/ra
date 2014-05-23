<?php
error_reporting(E_ALL);
ini_set('max_execution_time', 0);
require_once('../lib/config.php');

require_once($GLOBALS['CLASSES_DIR']."/Dropbox.class.php");
require_once($GLOBALS['CLASSES_DIR']."/DropboxAccount.class.php");
require_once($GLOBALS['CLASSES_DIR']."/DropboxFiles.class.php");
require_once($GLOBALS['LIB_ROOT']."/CurlWrapper.php");
require_once($GLOBALS['MODULES_DIR']."/calendar/calendar_forum_message_parser.class.php");
$dbhForum = $DBFactory->get_db_handle('forum');
$dbhRaks = $DBFactory->get_db_handle('rakscom');
$curl = new CurlWrapper();
$dropbox = new Dropbox($curl);
$dropboxAccount = new DropboxAccount($dbhRaks);
$dropboxFiles = new DropboxFiles($dropbox, $dropboxAccount, $curl, $dbhRaks);
$minPostTime = time() - 365*24*3600*3;
//Getting few posts with attachments which is not processed yet
$q = "
    SELECT *
    FROM phpbb_posts
    WHERE post_attachment = 1 AND post_text LIKE ".SQLQuote('%[attachment%')." AND post_time < ".$minPostTime."
    ORDER BY post_id ASC
    LIMIT 25
";
$rows = SQLGetRows($q, $dbhForum);
if(count($rows) == 0) exit;
foreach($rows as $row){
    $names = getAttachmentNames($row['post_text']);
    if(is_null($names)) continue;
    echo $row['post_id']."<br/>";
    add_to_log('[postId '.$row['post_id'].']', "attachment_dropbox_migrate");

    $bbcodeUid = $row['bbcode_uid'];
    $postText = $row['post_text'];
    foreach($names[1] as $key => $name){
        $dropboxAccountBest = $dropboxAccount->getBestAccount();
        if(is_null($dropboxAccountBest)){
            $error = "Please create new dropbox accounts, no space available in current";
            echo $error;
            add_to_log('[fatal][error '.$error.']', "attachment_dropbox_migrate");
            exit;
        }
        $dropbox->setAccessToken($dropboxAccountBest['access_token']);
        $data = fetchForumAttachment($row['post_id'], $name, $dbhForum);
        if(is_null($data)){
            echo $error = "Cannot fetch ".$name."<br/>";
            add_to_log('[continue][error '.$error.']', "attachment_dropbox_migrate");
            continue 2;
        }
        $comment = $data['attach_comment'];
        $filename = $data['physical_filename'];
        $ext = $data['extension'];
        $dir = substr(md5(microtime(true)), 0, 3).'/'.substr(md5(mt_rand(100,10000000)), 0, 10);
        $isOk = $dropbox->createFolder($dir);
        if(!$isOk) {
            echo $error = "Cannot create folder !<br/>";
            add_to_log('[continue][error '.$error.']', "attachment_dropbox_migrate");
            continue 2;
        }
        $newFilename = $dir.'/'.$data['attach_id'].'.'.strtolower($ext);
        $oldFilename = $GLOBALS['PROJECT_ROOT'].'/files/forum/'.$filename;
        $res = $dropbox->storeFile($newFilename, $oldFilename);
        if(!file_exists($oldFilename)){
            echo $error = "Old file not exists ".$oldFilename." in attachmentId ".$data['attach_id']."<br/>";
            add_to_log('[continue][error '.$error.']', "attachment_dropbox_migrate");
            continue 2;
        }
        if(is_null($res) || $res['bytes'] == 0) {
            echo $error = "Cannot save new file ".$newFilename." from ".$filename.' attachmentId '.$data['attach_id']."<br/>";
            add_to_log('[continue][error '.$error.']', "attachment_dropbox_migrate");
            continue 2;
        }
        $info = $dropbox->getAccountInfo();
        $dropboxAccount->setCurrentSize($dropboxAccountBest['id'], $info['quota_info']['normal'] + $info['quota_info']['shared']);
        $dropboxAccount->setMaxSize($dropboxAccountBest['id'], $info['quota_info']['quota']);
        $fileId = $dropboxFiles->saveFile($dropboxAccountBest['id'], $data['attach_id'], $dir, $ext);
        @unlink($oldFilename);
        $toReplace = '[img:'.$bbcodeUid.']http://raks.com.ua/i/attachment/real/'.$fileId.'.'.$ext.'[/img:'.$bbcodeUid.']';
        if(!empty($comment)) $toReplace .= "\r\n".'('.$comment.')'."\r\n";
        $postText = str_replace($names[0][$key], $toReplace, $postText);
        $text = preg_replace('/\:[a-z0-9]+\]/ims', ']', $postText);
        $calendarParser = new calendar_forum_message_parser($text);
        $newBitfield = $calendarParser->get_bitfield();
        //echo $postText;
        $fields = array(
            'post_text'         => $postText,
            'bbcode_bitfield'   => $newBitfield,
            'post_attachment'   => 0,
        );
        SQLUpdate('phpbb_posts', $fields, 'WHERE post_id = '.SQLQuote($row['post_id']), $dbhForum);
    }
}

//[attachment=0:fda29lbr]<!-- ia0 -->ins2.jpg<!-- ia0 -->[/attachment:fda29lbr]
function getAttachmentNames($text)
{
    //var_dump($text);
    $names = NULL;
    if(preg_match_all("/\[attachment\=[^\]]+\]\<\!\-\-[^\>]+\>([^\<]+)\<\!\-\-[^\>]+\>\[\/attachment\:[^\]]+\]/imsu", $text, $m)){
        $names = $m;
        //var_dump($m);
    }
    return $names;
}

function fetchForumAttachment($postId, $attachmentName, $dbhForum)
{
    $query = "
        SELECT *
        FROM phpbb_attachments
        WHERE post_msg_id = ".SQLQuote($postId)." AND real_filename = ".SQLQuote($attachmentName)."
    ";
    $data = SQLGet($query, $dbhForum);
    return isset($data['attach_id']) ? $data : NULL;
}