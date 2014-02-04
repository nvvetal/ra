<?php
// phpBB 3.0.x auto-generated configuration file
// Do not change anything in this file!
$dbms = 'mysql';
$dbhost = '';
$dbport = '';


define('RAKS_URL','http://raks.com.ua/');
$dbname = '';
$dbuser = '';
$dbpasswd = '';

define("RATING_SERVER_URL",RAKS_URL.'rating/rating_server.php');
define("RAKS_REGISTER_URL",RAKS_URL.'?go=register');
define("RAKS_FORGOT_PASS_URL",RAKS_URL.'?go=password_back');
define("RAKS_ACTIVATION_URL",RAKS_URL.'?go=password_back');
define("RAKS_MY_ROFILE_URL",RAKS_URL.'?go=my_profile');
define("RAKS_NEW_TOPIC_URL",RAKS_URL.'?go=forum_new_topic');
define("RAKS_EDIT_POST_URL",RAKS_URL.'?go=forum_edit_post');

$table_prefix = 'phpbb_';
$acm_type = 'file';
$load_extensions = '';

@define('PHPBB_INSTALLED', true);
// @define('DEBUG', true);
// @define('DEBUG_EXTRA', true);
?>