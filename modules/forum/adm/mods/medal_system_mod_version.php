<?php
/**
*
* @package acp
* @version $Id: medal_system_mod_version.php 01 2008-03-12 17:35:00Z Gremlinn $
* @copyright (c) 2005 phpBB Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/**
* @package medal_system_mod
*/
class medal_system_mod_version
{
	function version()
	{
		global $config;
		return array(
			'author'	=> 'Gremlinn',
			'title'		=> 'Medal System Mod for phpbb3',
			'tag'		=> 'mod_version_check',
			'version'	=> $config['medals_mod_version'],
			'file'		=> array('test.dupra.net', 'download', 'medals.xml'),
		);
	}
}

?>