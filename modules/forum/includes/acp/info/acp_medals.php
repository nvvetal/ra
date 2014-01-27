<?php
/***************************************************************************
*
* @package Medals Mod for phpBB3
* @version $Id: medals.php,v 0.9.1 2008/02/19 Gremlinn$
* @copyright (c) 2008 Nathan DuPra (mods@dupra.net)
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
***************************************************************************/

/**
* @package module_install
*/
class acp_medals_info
{
	var $u_action;

    function module()
    {
        return array(
            'filename'		=> 'acp_medals',
            'title'			=> 'ACP_MEDALS_INDEX',
            'version'		=> '0.9.8',
            'modes'			=> array(
				'config'		=> array(
					'title' 		=> 'ACP_MEDALS_SETTINGS',
					'auth' 			=> 'acl_a_board',
					'cat' 			=> array('ACP_CAT_USERS')),
                'management'	=> array(
					'title'			=> 'ACP_MEDALS_TITLE',
					'auth'			=> 'acl_a_manage_medals',
					'cat' 			=> array('ACP_CAT_USERS')
				),
			),
        );
    }

    function install()
    {
		global $phpbb_root_path, $phpEx, $db, $user, $table_prefix;
		
		// Setup $auth_admin class so we can add permission options
		include($phpbb_root_path . 'includes/acp/auth.' . $phpEx);
		$auth_admin = new auth_admin();

		// Add permission for manage cvsdb
		$auth_admin->acl_add_option(array(
			'local'		=> array(),
			'global'	=> array('u_award_medals', 'a_manage_medals')
		));
		
		$module_data = $this->module();
		$module_basename = substr(strchr($module_data['filename'], '_'), 1);
		$sql_ary = array();
		$message = '';
		$db->sql_return_on_error(true);

		$sql = 'SELECT module_id
				FROM ' . MODULES_TABLE . "
				WHERE module_basename = '$module_basename'";
		$result = $db->sql_query($sql);
		$module_id = $db->sql_fetchfield('module_id');
		$db->sql_freeresult($result);
		
		$sql_ary[] = 'UPDATE ' . MODULES_TABLE . " SET module_auth = 'acl_a_manage_medals' WHERE module_id = $module_id";

		$sql_ary[] = "CREATE TABLE {$table_prefix}medals (
				  `id` tinyint(10) NOT NULL auto_increment,
				  `name` varchar(30) collate utf8_bin NOT NULL default '',
				  `image` varchar(100) collate utf8_bin NOT NULL default '',
				  `dynamic` tinyint(1) NOT NULL default '0',
				  `device` varchar(32) collate utf8_bin NOT NULL default '',
                  `number` tinyint(2) NOT NULL default '1',                             
				  `parent` tinyint(5) NOT NULL default '0',
				  `nominated` tinyint(1) NOT NULL default '0',
				  `order_id` tinyint(5) NOT NULL default '0',
				  `description` varchar(256) NULL COLLATE utf8_bin,
				  `points` smallint(4) NOT NULL default '0',
				  PRIMARY KEY  (`id`),
				  KEY `order_id` (`order_id`)
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";

		$sql_ary[] = "CREATE TABLE {$table_prefix}medals_awarded (
				  `id` int(10) NOT NULL auto_increment,
				  `medal_id` bigint(20) NOT NULL default '0',
				  `user_id` bigint(20) NOT NULL default '0',
				  `awarder_id` bigint(20) NOT NULL default '0',
				  `awarder_un` varchar(255) collate utf8_bin NOT NULL default '',
				  `awarder_color` varchar(6) collate utf8_bin NOT NULL default '',
				  `time` int(11) NOT NULL default '0',
				  `nominated` tinyint(1) NOT NULL default '0',
				  `nominated_reason` text collate utf8_bin NOT NULL,
				  `points` smallint(4) NOT NULL default '0',
				  `bbuid` varchar(255) collate utf8_bin NOT NULL,
				  `bitfield` varchar(255) collate utf8_bin NOT NULL,
				  PRIMARY KEY  (`id`),
				  KEY `time` (`time`)
				) ENGINE=MyISAM DEFAULT CHARSET=utf8;";

		$sql_ary[] = "CREATE TABLE {$table_prefix}medals_cats (
				  `id` tinyint(5) NOT NULL auto_increment,
				  `name` varchar(30) collate utf8_bin NOT NULL default '',
				  `order_id` tinyint(5) NOT NULL default '0',
				  PRIMARY KEY  (`id`),
				  KEY `order_id` (`order_id`)
				) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";

		$sqlinsert = array(
				'image_name'		=> 'icon_post_approve',
				'image_filename'		=> 'icon_post_approve.gif',
				'image_height'		=> '20',
				'image_width'		=> '20',
				'imageset_id'		=> '1',
			);
		$sql_ary[]  = 'INSERT INTO ' . STYLES_IMAGESET_DATA_TABLE . ' ' . $db->sql_build_array('INSERT', $sqlinsert);

		foreach ($sql_ary as $sql)
		{
			$message .= '<p style="font-weight: bold;">'.$sql.'</p>';
			$result = $db->sql_query($sql);
			if ($result)
			{
				$message .= '<p style="color: yellow;">Query processed succesfully.</p>';
			}
			else
			{
				$error = true;
				$message .= '<p style="color: red;">There was an error while processing this query.</p>';
			}
			$message .= '<br />';
		}

		set_config('medals_mod_version', $module_data['version']);
		set_config('medal_small_img_width', 0);
		set_config('medal_small_img_ht', 0);
		set_config('medal_profile_across', 5);
		set_config('medal_display_topic', 0);
		set_config('medal_topic_row', 1);
		set_config('medal_topic_col', 1);
		set_config('medal_profile_across', 0);

		$message .= sprintf($user->lang['MEDALS_MOD_INSTALLED'], $module_data['version']) . adm_back_link($this->u_action) ;

		trigger_error($message);
	}

    function uninstall()
    {
    }
	
	function update($mod_version)
	{
		global $phpbb_root_path, $phpEx, $db, $user, $table_prefix;
		
		$module_data = $this->module();
		$sql_ary = array();
		$message = '';
		$db->sql_return_on_error(true);

		switch ($mod_version)
		{
			case '0.6.4':
				// Change to Medals table
				//  Add number column to store how many awards can be issued.  Default is one award.  Replaces multiple (yes/no) column.
				//  Add dynamic column (bool) to indicate if multiple awards are static images or created on the fly.
				//  Drop multiple column as it is replaced by number.
				$sql_ary[] = "ALTER TABLE {$table_prefix}medals ADD COLUMN `number` tinyint(2) DEFAULT '1' NOT NULL after `image`";
				$sql_ary[] = "ALTER TABLE {$table_prefix}medals ADD COLUMN `device` varchar(32) DEFAULT 'device' NOT NULL after `image`";
				$sql_ary[] = "ALTER TABLE {$table_prefix}medals ADD COLUMN `dynamic` tinyint(1) DEFAULT '0' NOT NULL after `image`";
				$sql_ary[] = "ALTER TABLE {$table_prefix}medals DROP COLUMN `multiple`";

				// Change to Medals Awarded table
				//  Change id column to allow more medals. Now INT which can hold 4,294,967,295 medal ids.
				$sql_ary[] = "ALTER TABLE {$table_prefix}medals_awarded CHANGE `id` `id` int(10) NOT NULL AUTO_INCREMENT";
				$sql_ary[] = "ALTER TABLE {$table_prefix}medals_awarded ADD COLUMN `points` tinyint(3) DEFAULT '0' NOT NULL";

			// No Break

			// No Database changes
			case '0.7.0':
			case '0.7.1':
			case '0.7.2':

			// No Break

			case '0.7.3':
				// Change to Medals table
				//  Change id column to allow more user_points. Now SMALLINT which can be +/-32767.
				$sql_ary[] = "ALTER TABLE {$table_prefix}medals CHANGE `points` `points` smallint(4) DEFAULT '0' NOT NULL";

				// Change to Medals Awarded table
				//  added bbuid and bitfield columns to accomodate BBcode and smilies like the phpBB does.
				$sql_ary[] = "ALTER TABLE {$table_prefix}medals_awarded ADD COLUMN `bbuid` varchar(255) NOT NULL";
				$sql_ary[] = "ALTER TABLE {$table_prefix}medals_awarded ADD COLUMN `bitfield` varchar(255) NOT NULL";

				foreach ($sql_ary as $sql)
				{
					$message .= '<p style="font-weight: bold;">'.$sql.'</p>';
					$result = $db->sql_query($sql);
					if ($result)
					{
						$message .= '<p style="color: yellow;">Query processed succesfully.</p>';
					}
					else
					{
						$error = true;
						$message .= '<p style="color: red;">There was an error while processing this query.</p>';
					}
					$message .= '<br />';
				}
	        // No Break

	        case '0.8.0':
			case '0.8.1':
			case '0.8.2':
			case '0.8.3':
			case '0.8.4':
			case '0.8.5':
			case '0.9.0':
			case '0.9.1':
			case '0.9.2':
			case '0.9.3':
			case '0.9.4':
			case '0.9.5':
			case '0.9.6':
			case '0.9.7':
			case '0.9.8':
	            // No Database changes

	            $update = true;
			break;

	         default:
				$message = ($user->lang['MEDALS_MOD_MANUAL']);
				$update = false;
			break;
		}
		
		if ($update)
		{
			set_config('medals_mod_version', $module_data['version']);
			
			$message .= sprintf($user->lang['MEDALS_MOD_UPDATED'], $module_data['version']) . adm_back_link($this->u_action) ;
		}

		trigger_error($message);
	}
}

?>