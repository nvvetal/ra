CREATE TABLE IF NOT EXISTS `user_status` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `status` text NOT NULL,
  `is_active` enum('N','Y') NOT NULL DEFAULT 'N',
  `created_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
