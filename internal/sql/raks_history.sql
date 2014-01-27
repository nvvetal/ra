CREATE TABLE IF NOT EXISTS `raks_history` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `rule` varchar(255) NOT NULL,
  `time_action` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;