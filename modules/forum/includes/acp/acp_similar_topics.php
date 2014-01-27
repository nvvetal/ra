<?php
/**
*
* @package acp
* @version $Id: acp_similar_topics.php,v 1.00 2008/10/27 13:57:02 Porutchik Exp $
* @copyright (c) 2005 phpBB Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
* @todo add cron intervals to server settings? (database_gc, queue_interval, session_gc, search_gc, cache_gc, warnings_gc)
*/

/**
* @package acp
*/
class acp_similar_topics
{
	var $u_action;

	function main($id, $mode)
	{
		global $db, $user, $auth, $template;
		global $config, $phpbb_root_path, $phpbb_admin_path, $phpEx;

		$action	= request_var('action', '');
		$submit = (isset($_POST['submit'])) ? true : false;

		$form_key = 'acp_board';
		add_form_key($form_key);

		if ($mode != 'similar_topics')
		{
			return;
		}
	
		$lang_info_path = 'mods/info_acp_similar_topics';
		$user->add_lang($lang_info_path);
		/**
		*	Validation types are:
		*		string, int, bool,
		*		script_path (absolute path in url - beginning with / and no trailing slash),
		*		rpath (relative), rwpath (realtive, writable), path (relative path, but able to escape the root), wpath (writable)
		*/
		$display_vars = array(
			'title'	=> 'ACP_SIMILAR_TOPICS',
			'lang'	=> $lang_info_path,
			'vars'	=> array(
				'similar_topics_posting'	=> array('lang' => 'SIMILAR_POSTING',		'validate' => 'bool',	'type' => 'radio:yes_no', 'explain' => false),
				'similar_topics_viewtopic'	=> array('lang' => 'SIMILAR_VIEWTOPIC',		'validate' => 'bool',	'type' => 'radio:yes_no', 'explain' => false),
				'similar_sort_type'			=> array('lang' => 'SIMILAR_SORT_TYPE',		'validate' => 'string',	'type' => 'select', 'method' => 'similar_sort_type', 'explain' => true),
				'similar_stopwords'			=> array('lang' => 'SIMILAR_STOPWORDS',		'validate' => 'bool',	'type' => 'radio:yes_no', 'explain' => true),
				'similar_ignore_forums_ids'	=> array('lang' => 'SIMILAR_IGNORE_FORUMS',	'validate' => 'string',	'type' => 'textarea:5:5', 'explain' => true),
				'similar_max_topics'		=> array('lang' => 'SIMILAR_MAX_TOPICS',	'validate' => 'int:0',	'type' => 'text:5:4', 'explain' => true),
				'similar_topics_min_relevance'	=> array('lang' => 'SIMILAR_MIN_RELEVANCE',	'validate' => 'real:0',	'type' => 'text:5:4', 'explain' => true),
				'similar_topics_min_amount_words_viewtopic'	=> array('lang' => 'SIMILAR_MIN_AMOUNT_WORDS_VIEWTOPIC',	'validate' => 'int:0',	'type' => 'text:5:4', 'explain' => true),
				'similar_topics_min_amount_words_posting'	=> array('lang' => 'SIMILAR_MIN_AMOUNT_WORDS_POSTING',	'validate' => 'int:0',	'type' => 'text:5:4', 'explain' => true),
			),
		);

		$this->new_config = $config;
		$cfg_array = (isset($_REQUEST['config'])) ? utf8_normalize_nfc(request_var('config', array('' => ''), true)) : $this->new_config;
		$error = array();

		// We validate the complete config if whished
		validate_config_vars($display_vars['vars'], $cfg_array, $error);

		if ($submit && !check_form_key($form_key))
		{
			$error[] = $user->lang['FORM_INVALID'];
		}
		// Do not write values if there is an error
		if (sizeof($error))
		{
			$submit = false;
		}

		// We go through the display_vars to make sure no one is trying to set variables he/she is not allowed to...
		foreach ($display_vars['vars'] as $config_name => $null)
		{
			if (!isset($cfg_array[$config_name]) || strpos($config_name, 'legend') !== false)
			{
				continue;
			}
			
			$this->new_config[$config_name] = $cfg_array[$config_name];
			
		}

		if ($submit)
		{
			add_log('admin', 'LOG_CONFIG_' . strtoupper($mode));
			
			set_config('similar_stopwords', $this->new_config['similar_stopwords']);
			set_config('similar_ignore_forums_ids', $this->new_config['similar_ignore_forums_ids']);
			set_config('similar_sort_type', $this->new_config['similar_sort_type']);
			set_config('similar_max_topics', $this->new_config['similar_max_topics']);
			set_config('similar_topics_posting', $this->new_config['similar_topics_posting']);
			set_config('similar_topics_viewtopic', $this->new_config['similar_topics_viewtopic']);
			set_config('similar_topics_min_relevance', $this->new_config['similar_topics_min_relevance']);
			set_config('similar_topics_min_amount_words_viewtopic', $this->new_config['similar_topics_min_amount_words_viewtopic']);
			set_config('similar_topics_min_amount_words_posting', $this->new_config['similar_topics_min_amount_words_posting']);

			trigger_error($user->lang['CONFIG_UPDATED'] . adm_back_link($this->u_action));
		}

		$this->tpl_name = 'acp_similar_topics';
		$this->page_title = $display_vars['title'];
		
		$template->assign_vars(array(
			'L_TITLE'			=> $user->lang[$display_vars['title']],
			'L_TITLE_EXPLAIN'	=> $user->lang[$display_vars['title'] . '_EXPLAIN'],

			'S_ERROR'			=> (sizeof($error)) ? true : false,
			'ERROR_MSG'			=> implode('<br />', $error),

			'U_ACTION'			=> $this->u_action)
		);

		// Output relevant page
		foreach ($display_vars['vars'] as $config_key => $vars)
		{
			if (!is_array($vars) && strpos($config_key, 'legend') === false)
			{
				continue;
			}

			if (strpos($config_key, 'legend') !== false)
			{
				$template->assign_block_vars('options', array(
					'S_LEGEND'		=> true,
					'LEGEND'		=> (isset($user->lang[$vars])) ? $user->lang[$vars] : $vars)
				);

				continue;
			}

			$type = explode(':', $vars['type']);

			$l_explain = '';
			if ($vars['explain'] && isset($vars['lang_explain']))
			{
				$l_explain = (isset($user->lang[$vars['lang_explain']])) ? $user->lang[$vars['lang_explain']] : $vars['lang_explain'];
			}
			else if ($vars['explain'])
			{
				$l_explain = (isset($user->lang[$vars['lang'] . '_EXPLAIN'])) ? $user->lang[$vars['lang'] . '_EXPLAIN'] : '';
			}

			$template->assign_block_vars('options', array(
				'KEY'			=> $config_key,
				'TITLE'			=> (isset($user->lang[$vars['lang']])) ? $user->lang[$vars['lang']] : $vars['lang'],
				'S_EXPLAIN'		=> $vars['explain'],
				'TITLE_EXPLAIN'	=> $l_explain,
				'CONTENT'		=> build_cfg_template($type, $config_key, $this->new_config, $config_key, $vars),
				)
			);
		
			unset($display_vars['vars'][$config_key]);
		}

	}

	/**
	* Similar sort type
	*/
	function similar_sort_type($value, $key = '')
	{
		global $user;
		
		$options_ary = array('time' => 'SIMILAR_SORT_DATE', 'relev' => 'SIMILAR_SORT_RELEV');
		$similar_sort_type_options = '';
		foreach ($options_ary as $key_value=>$option)
		{
			$selected = ($value == $key_value) ? ' selected="selected"' : '';
			$similar_sort_type_options .= '<option value="' . $key_value . '"' . $selected . '>' . $user->lang[$option] . '</option>';
		}
		return $similar_sort_type_options;
	}
}

?>