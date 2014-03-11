<?php
require_once('user.common.php');
$dbh = $DBFactory->get_db_handle('forum');
$from = isset($_REQUEST['from']) ? $_REQUEST['from'] : 0;
$perSend = 100;
$query = "
	SELECT user_id
	FROM phpbb_users
	ORDER BY user_id ASC
	LIMIT $from, $perSend
";
$messagingForum = new MessagingForum($dbh);

$users = SQLGetRows($query, $dbh);

$mailBody = $smarty->fetch($GLOBALS['SMARTY_MODULES_DIR'].'user/mail/advertise1.tpl');
foreach($users as $userData){
    $data = array(
        'fromForumUserId' => 3,
        'subject' => 'Профиль',
        'message' => $mailBody,
        'toForumUserId' => $userData['user_id'],
    );
    $messagingForum->sendMessage($data);
    echo "Sent to ".$userData['user_id']."<br/>\n";

}

if(count($users) > 0) {
    echo "<script>
    setTimeout(function(){window.location.href='?from=".($from+$perSend)."';}, 1000);
    </script>";
}





