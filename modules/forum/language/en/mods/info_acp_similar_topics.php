<?php
/** 
*
* posting [English]
*
* @package language
* @version $Id: similar_topics.php,v 1.6.6 2008/10/27 16:38:47 Porutchik Exp $
* @copyright (c) 2005 phpBB Group 
* @license http://opensource.org/licenses/gpl-license.php GNU Public License 
*
*/

/**
* DO NOT CHANGE
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine

$lang = array_merge($lang, array(
// ACP block
	'ACP_SIMILAR_TOPICS'				=> 'Similar Topics',
	'ACP_SIMILAR_TOPICS_EXPLAIN'		=> 'On this page you can configure search of similar topics.',
	'LOG_CONFIG_SIMILAR_TOPICS'			=> '<strong>Edited Similar Topics settings</strong>',
	
	'SIMILAR_STOPWORDS'					=> 'Excludes stop-words',
	'SIMILAR_IGNORE_FORUMS'				=> 'Ignored forums',
	'SIMILAR_IGNORE_FORUMS_EXPLAIN'		=> 'Enter ids of forums, in which the similar topics will be ignored (for example test forum, forum for talk, etc.). One id per line.',
	'SIMILAR_SORT_TYPE'					=> 'Sort by',
	'SIMILAR_SORT_TYPE_EXPLAIN'			=> 'Select sort method the similar topics',
	'SIMILAR_SORT_DATE'					=> 'post time',
	'SIMILAR_SORT_RELEV'				=> 'relevance',
	'SIMILAR_MAX_TOPICS'				=> 'Maximum amount of a topics for show',
	'SIMILAR_POSTING'					=> 'To enable search of similar topics at creation of a new topics',
	'SIMILAR_VIEWTOPIC'					=> 'To enable similar topics in viewtopic',
	'SIMILAR_MIN_AMOUNT_WORDS_VIEWTOPIC'=> 'Min number of words (for viewtopic).<br />Set to 0 for no limit',
	'SIMILAR_MIN_AMOUNT_WORDS_VIEWTOPIC_EXPLAIN'=> 'This control in number of words in the topic title to appear in the similar topics',
	'SIMILAR_MIN_AMOUNT_WORDS_POSTING'	=> 'Min number of words (for posting form).<br />Set to 0 for no limit',
	'SIMILAR_MIN_AMOUNT_WORDS_POSTING_EXPLAIN'=> 'This control in number of words in the topic title to appear in the similar topics',
	'SIMILAR_MIN_RELEVANCE'				=> 'Minimum relevance.<br />Set to 0 for no limit',
	'SIMILAR_MIN_RELEVANCE_EXPLAIN'		=> 'This control a relevance in the topic title to appear in the similar topics. To install this value by an experimental way.',

	'SIMILAR_TOPICDESC'					=> 'Take into account the description of a topics <br /> (at installed the Topic Description mod)',
	
// Install block
	'INSTALLED'							=> 'You have successfully <strong>installed</strong> Similar Topics mod.',
	'NO_FILES_MODIFIED'					=> 'You haven\'t modified files in according to Similar Topics MOD installation instruction.',
	'NOT_INSTALLED'						=> 'You have not Similar Topics mod installed.',
	'UNINSTALLED'						=> 'You have successfully <strong>uninstalled</strong> Similar Topics mod from your database.',
));

?>