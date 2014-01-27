CREATE TABLE IF NOT EXISTS `payment_stats` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `time_created` int(11) NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `type` varchar(100) NOT NULL,
  `amount` smallint(5) unsigned NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;