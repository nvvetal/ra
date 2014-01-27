<?php
/** 
*
* @package acp
* @version $Id: acp_similar_topics.php,v 1.00 2008/10/27 00:05:43 Porutchik Exp $
* @copyright (c) 2005 phpBB Group 
* @license http://opensource.org/licenses/gpl-license.php GNU Public License 
*
*/

/**
* @package module_install
*/
class acp_similar_topics_info
{
	function module()
	{
		return array(
			'filename'	=> 'acp_similar_topics',
			'title'		=> 'ACP_SIMILAR_TOPICS',
			'version'	=> '1.0.4',
			'modes'		=> array(
				'similar_topics'		=> array('title' => 'ACP_SIMILAR_TOPICS', 'auth' => 'acl_a_board', 'cat' => array('ACP_BOARD_CONFIGURATION')),

			),
		);
	}

	function install()
	{
	}

	function uninstall()
	{
	}
}

?>