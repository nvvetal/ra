<?php
require_once('common.php');

require_once($GLOBALS['CLASSES_DIR']."/Dropbox.class.php");
require_once($GLOBALS['LIB_ROOT']."/CurlWrapper.php");
require_once($GLOBALS['MODULES_DIR']."/calendar/calendar_forum_message_parser.class.php");
$curl = new CurlWrapper();
$dropbox = new Dropbox($curl);
$dbhForum = $DBFactory->get_db_handle('forum');
//Getting few posts with attachments which is not processed yet
$q = "
    SELECT *
    FROM phpbb_posts
    WHERE post_attachment = 1 AND post_text LIKE ".SQLQuote('%[attachment%')."
    ORDER BY post_id ASC
    LIMIT 10
";
$rows = SQLGetRows($q, $dbhForum);
if(count($rows) == 0) exit;
echo "<pre>";
foreach($rows as $row){
    echo $row['post_id']."<br/>";
    $names = getAttachmentNames($row['post_text']);
    var_dump($names);
    foreach($names as $name){
        $data = fetchForumAttachment($row['post_id'], $name, $dbhForum);
        var_dump($data);
    }
}

//[attachment=0:fda29lbr]<!-- ia0 -->ins2.jpg<!-- ia0 -->[/attachment:fda29lbr]
function getAttachmentNames($text)
{
    //var_dump($text);
    $names = NULL;
    if(preg_match_all("/\[attachment\=[^\]]+\]\<\!\-\-[^\>]+\>([^\<]+)\<\!/ims", $text, $m)){
        $names = $m[1];
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