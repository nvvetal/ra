CREATE TABLE IF NOT EXISTS `admin_logs` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `time_created` int(11) NOT NULL,
  `module` varchar(30) NOT NULL,
  `action` varchar(255) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `send_data` longtext NOT NULL,
  `return_data` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `time_created` (`time_created`),
  KEY `time_created_2` (`time_created`,`module`,`action`)
) TYPE=MyISAM;