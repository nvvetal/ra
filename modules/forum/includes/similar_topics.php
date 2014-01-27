<?php
/** 
*
* @package phpBB3
* @version $Id: similar_topics.php,v 1.0.0 2008/10/23 01:10:26 Porutchik Exp $
* @copyright (c) 2005 phpBB Group 
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/**
*/
if (!defined('IN_PHPBB'))
{
	// This was an AJAX request
	define('IN_PHPBB', true);
	$phpbb_root_path = '../';
	$phpEx = substr(strrchr(__FILE__, '.'), 1);
	include($phpbb_root_path . 'common.' . $phpEx);
	include($phpbb_root_path . 'includes/functions_display.' . $phpEx);

	// Start session management
	$user->session_begin();
	$auth->acl($user->data);
	$user->setup('posting');
	
	$topic_title = utf8_normalize_nfc(request_var('topic_title', '', true));
	if (empty($topic_title))
	{
		exit(0);
	}
	$topic_title = utf8_strtolower(utf8_htmlspecialchars($topic_title));
	$AJAXrequest = true;
	$min_amount_words = $config['similar_topics_min_amount_words_posting'];
}
else
{
	$topic_title = utf8_strtolower($topic_data['topic_title']);
	$topic_id = (int) $topic_data['topic_id'];
	$AJAXrequest = false;
	$min_amount_words = $config['similar_topics_min_amount_words_viewtopic'];
}

// Reduce multiple spaces to a single space.
$topic_title = trim(preg_replace('#\s+#', ' ', strip_tags($topic_title)));

if ( $config['similar_stopwords'] )
{ 
	// check against stopwords start 
	if (file_exists("{$user->lang_path}/search_ignore_words.$phpEx"))
	{
		$stopword_list = array();
		// include the file containing ignore words
		include("{$user->lang_path}/search_ignore_words.$phpEx");
		$stopword_list = $words;
		unset($words);
		if ( !empty($stopword_list) )
		{
			// Remove words to be ignored
			$topic_title = ' ' . utf8_case_fold_nfc($topic_title) . ' ';
			foreach ($stopword_list as $stopword)
			{
				$topic_title = str_replace(' ' . trim($stopword) . ' ', ' ', $topic_title); 
			}
			$topic_title = trim($topic_title); 
			if (empty($topic_title))
			{
				exit(0);
			}
		}
	}
	// check against stopwords end
}
$check_words = (sizeof(explode(' ', $topic_title)) < $min_amount_words) ? false : true;
if (!$check_words && $AJAXrequest) 
{
	exit(0);
}
else if (!$check_words && !$AJAXrequest) 
{
	return;
}

if ( $config['similar_sort_type'] == 'time' )
{
	$sql_sort = 't.topic_last_post_time';
}
else
{
	$sql_sort = 'relevance';
}

if ( trim($config['similar_ignore_forums_ids']) != '' )
{
	$ignore_forums_ids = ' AND f.forum_id NOT IN (' . implode(',', array_map('intval', explode("\n", trim($config['similar_ignore_forums_ids'])))) . ')';
}
else
{
	$ignore_forums_ids = '';
}

$sql_match = "MATCH (t.topic_title) AGAINST ('" . $db->sql_escape($topic_title) . "' )";
$sql_min_relevance = (trim($config['similar_topics_min_relevance']) != '') ? ' >= ' . trim($config['similar_topics_min_relevance']) : '';

$sql_array = array(
	'SELECT'	=> 'f.forum_id, f.forum_name, t.*, u.user_id, u.username, u.user_colour, ' . $sql_match . ' AS relevance',

	'FROM'		=> array(
		TOPICS_TABLE	=> 't',
	),

	'LEFT_JOIN'	=> array(
		array(
			'FROM'	=>	array(USERS_TABLE	=> 'u'),
			'ON'	=> 'u.user_id = t.topic_poster'
	),
		array(
			'FROM'	=>	array(FORUMS_TABLE	=> 'f'),
			'ON'	=> 'f.forum_id = t.forum_id'
		),
	),

	'WHERE'		=> $sql_match . $sql_min_relevance . '
		AND t.topic_status <> ' . ITEM_MOVED . $ignore_forums_ids . ((!$AJAXrequest) ? ' AND t.topic_id <> ' . $topic_id : ''),

	'GROUP_BY'	=> 't.topic_id',

	'ORDER_BY'	=> $sql_sort,
);

$sql = $db->sql_build_query('SELECT', $sql_array);
$result = $db->sql_query_limit($sql, intval($config['similar_max_topics']));
$similar_topics = $db->sql_fetchrowset($result);
$db->sql_freeresult($result);

$count_similar = sizeof($similar_topics);
if ( $count_similar )
{
	// Grab icons
	$icons = $cache->obtain_icons();

	if ($AJAXrequest)
	{
		// application/xhtml+xml not used because of IE
		@header('Content-type: text/html; charset=UTF-8');
		$template->assign_vars(array(
			'T_ICONS_PATH'	=> "{$phpbb_root_path}{$config['icons_path']}/",
			'LAST_POST_IMG'	=> $user->img('icon_topic_latest', 'VIEW_LATEST_POST')
		));
	}
	$template->set_filenames(array(
		'similar_viewtopic' => 'similar_viewtopic.html')
	);
	$template->assign_vars(array(
		'LAST_POST_IMG'	=> $user->img('icon_topic_latest', 'VIEW_LATEST_POST')
	));

	$forums_auth = array();
	foreach ($similar_topics as $similar)
	{
		$similar_forum_id = $similar['forum_id'];
		if (!isset($forums_auth[$similar_forum_id]))
		{
			$forums_auth[$similar_forum_id]['f_list'] = $auth->acl_get('f_list', $similar_forum_id);
			$forums_auth[$similar_forum_id]['m_approve'] = $auth->acl_get('m_approve', $similar_forum_id);
		}
		if ($forums_auth[$similar_forum_id]['f_list'])
		{
			$similar_topic_id = $similar['topic_id'];
			$replies = ($forums_auth[$similar_forum_id]['m_approve']) ? $similar['topic_replies_real'] : $similar['topic_replies'];

			$folder_img = $folder_alt = $topic_type = '';
			topic_status($similar, $replies, false, $folder_img, $folder_alt, $topic_type);

			$similar_forum_url	= append_sid('viewforum.' . $phpEx, 'f=' . $similar_forum_id);
			$similar_topic_url	= append_sid('viewtopic.' . $phpEx, 'f=' . $similar_forum_id . '&amp;t=' . $similar_topic_id);
			$similar_user		= get_username_string('full', $similar['user_id'], $similar['username'], $similar['user_colour'], $similar['username']);
		
			$template->assign_block_vars('similar', array(
				'TOPIC_TITLE'			=> censor_text($similar['topic_title']),
				'TOPIC_FOLDER_IMG'		=> $user->img($folder_img, $folder_alt),
				'TOPIC_FOLDER_IMG_SRC'	=> $user->img($folder_img, $folder_alt, false, '', 'src'),
				'TOPIC_ICON_IMG'		=> (!empty($icons[$similar['icon_id']])) ? $icons[$similar['icon_id']]['img'] : '',
				'TOPIC_ICON_IMG_WIDTH'	=> (!empty($icons[$similar['icon_id']])) ? $icons[$similar['icon_id']]['width'] : '',
				'TOPIC_ICON_IMG_HEIGHT'	=> (!empty($icons[$similar['icon_id']])) ? $icons[$similar['icon_id']]['height'] : '',
				'TOPIC_REPLIES'			=> $replies,
				'TOPIC_VIEWS'			=> $similar['topic_views'],
				'TOPIC_AUTHOR'			=> get_username_string('no_profile', $similar['user_id'], $similar['username'], $similar['user_colour']),
				'TOPIC_AUTHOR_FULL'		=> $similar_user,
				'TOPIC_AUTHOR_COLOUR'	=> get_username_string('colour', $similar['user_id'], $similar['username'], $similar['user_colour']),
				'FIRST_POST_TIME'		=> $user->format_date($similar['topic_time']),
				'PAGINATION'			=> topic_generate_pagination($replies, $similar_topic_url),
				'LAST_POST_AUTHOR'			=> get_username_string('no_profile', $similar['topic_last_poster_id'], $similar['topic_last_poster_name'], $similar['topic_last_poster_colour']),
				'LAST_POST_AUTHOR_COLOUR'	=> get_username_string('colour', $similar['topic_last_poster_id'], $similar['topic_last_poster_name'], $similar['topic_last_poster_colour']),
				'LAST_POST_AUTHOR_FULL'		=> get_username_string('full', $similar['topic_last_poster_id'], $similar['topic_last_poster_name'], $similar['topic_last_poster_colour']),
				'LAST_POST_TIME'		=> $user->format_date($similar['topic_last_post_time']),
				'FORUM_TITLE'			=> $similar['forum_name'],
				'S_TOPIC_TYPE'			=> $similar['topic_type'],
				'S_TOPIC_GLOBAL'		=> (!$similar_forum_id) ? true : false,
				'U_VIEW_TOPIC'			=> $similar_topic_url,
				'U_VIEW_FORUM'			=> $similar_forum_url,
				'U_LAST_POST'			=> append_sid('viewtopic.' . $phpEx, 'p=' . $similar['topic_last_post_id'] . '#p' . $similar['topic_last_post_id']),
				'U_LAST_POST_AUTHOR'	=> append_sid(get_username_string('profile', $similar['topic_last_poster_id'], $similar['topic_last_poster_name'], $similar['topic_last_poster_colour'], false, 'memberlist.' . $phpEx . '?mode=viewprofile')),
				'U_TOPIC_AUTHOR'		=> append_sid(get_username_string('profile', $similar['user_id'], $similar['username'], $similar['user_colour'], false, 'memberlist.' . $phpEx . '?mode=viewprofile')),
				)
			);
		}
	}
	if ($AJAXrequest)
	{
		$template->display('similar_viewtopic');
	}
}
?>