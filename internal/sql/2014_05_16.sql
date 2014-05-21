CREATE TABLE IF NOT EXISTS `dropbox_accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `access_token` varchar(255) NOT NULL,
  `current_size` bigint(20) unsigned NOT NULL,
  `max_size` bigint(20) unsigned NOT NULL,
  `created_time` int(11) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `dropbox_items`
--

CREATE TABLE IF NOT EXISTS `dropbox_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `dropbox_id` int(11) NOT NULL,
  `path` varchar(255) NOT NULL,
  `image_type` varchar(6) NOT NULL,
  `attachment_id` int(10) unsigned NOT NULL,
  `created_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
