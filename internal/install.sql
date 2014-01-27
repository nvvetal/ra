--
-- Структура таблицы `advertise`
--

CREATE TABLE IF NOT EXISTS `advertise` (
  `a_time` bigint(20) NOT NULL DEFAULT '0',
  `a_type` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `a_value` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  KEY `a_type` (`a_type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `banners_ip`
--

CREATE TABLE IF NOT EXISTS `banners_ip` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ip` bigint(20) NOT NULL,
  `time_showed` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fast_idx` (`ip`,`time_showed`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=40 ;

-- --------------------------------------------------------

--
-- Структура таблицы `blog_firm`
--

CREATE TABLE IF NOT EXISTS `blog_firm` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `firm_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `post_datetime` bigint(20) unsigned NOT NULL DEFAULT '0',
  `post_text` text COLLATE utf8_unicode_ci NOT NULL,
  `post_count` bigint(20) unsigned NOT NULL DEFAULT '0',
  `is_approved` enum('not_yet','yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'not_yet',
  `approved_by` bigint(20) NOT NULL DEFAULT '0',
  `approved_datetime` bigint(20) unsigned NOT NULL DEFAULT '0',
  `approved_no_reason_id` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `blog_firm_posts`
--

CREATE TABLE IF NOT EXISTS `blog_firm_posts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `blog_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `poster_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `message` text COLLATE utf8_unicode_ci NOT NULL,
  `is_approved` enum('not_yet','yes','not') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'not_yet',
  `approved_by` bigint(20) unsigned NOT NULL DEFAULT '0',
  `approved_datetime` bigint(20) unsigned NOT NULL DEFAULT '0',
  `approved_no_reason_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `blog_firm_tags`
--

CREATE TABLE IF NOT EXISTS `blog_firm_tags` (
  `blog_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `tag` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  KEY `tag` (`tag`),
  KEY `blog_id` (`blog_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `calendar`
--

CREATE TABLE IF NOT EXISTS `calendar` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `bdate` date NOT NULL DEFAULT '0000-00-00',
  `city_id` bigint(20) NOT NULL DEFAULT '0',
  `address` varchar(255) NOT NULL DEFAULT '',
  `category_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `small_info` varchar(100) NOT NULL DEFAULT '',
  `full_info` text NOT NULL,
  `creator_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `organizator_name` varchar(255) NOT NULL DEFAULT '',
  `is_approved` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

-- --------------------------------------------------------

--
-- Структура таблицы `calendar_additional_info`
--

CREATE TABLE IF NOT EXISTS `calendar_additional_info` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `calendar_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `name` char(20) NOT NULL DEFAULT '',
  `value` char(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `idx_calendar` (`calendar_id`,`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=112 ;

-- --------------------------------------------------------

--
-- Структура таблицы `calendar_categories`
--

CREATE TABLE IF NOT EXISTS `calendar_categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Структура таблицы `cities`
--

CREATE TABLE IF NOT EXISTS `cities` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `country_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Структура таблицы `config`
--

CREATE TABLE IF NOT EXISTS `config` (
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `countries`
--

CREATE TABLE IF NOT EXISTS `countries` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `short_name` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Структура таблицы `firms`
--

CREATE TABLE IF NOT EXISTS `firms` (
  `firm_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `createTime` bigint(20) NOT NULL DEFAULT '0',
  `state` enum('not_active','active','vip','banned') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'not_active',
  PRIMARY KEY (`firm_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `firms_data`
--

CREATE TABLE IF NOT EXISTS `firms_data` (
  `firm_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `f_param` char(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `f_value` char(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  KEY `firm_id` (`firm_id`,`f_param`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `i18n_admin`
--

CREATE TABLE IF NOT EXISTS `i18n_admin` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `lang` char(3) NOT NULL,
  `name` varchar(255) NOT NULL,
  `value` tinytext NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_uniq` (`lang`,`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=155 ;

-- --------------------------------------------------------

--
-- Структура таблицы `i18n_default`
--

CREATE TABLE IF NOT EXISTS `i18n_default` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `lang` char(3) NOT NULL,
  `name` varchar(255) NOT NULL,
  `value` tinytext NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_uniq` (`lang`,`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=67 ;

-- --------------------------------------------------------

--
-- Структура таблицы `images`
--

CREATE TABLE IF NOT EXISTS `images` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `owner_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `owner_type` varchar(25) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'unknown',
  `path` varchar(24) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `img_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fname` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `approve_state` tinyint(1) NOT NULL DEFAULT '0',
  `is_public` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=34 ;

-- --------------------------------------------------------

--
-- Структура таблицы `members`
--

CREATE TABLE IF NOT EXISTS `members` (
  `mem_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `email` varchar(250) NOT NULL,
  `username` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `fname` varchar(250) NOT NULL,
  `lname` varchar(250) NOT NULL,
  `verified` enum('0','1') NOT NULL DEFAULT '0',
  `banned` enum('0','1') NOT NULL DEFAULT '0',
  `membership` tinyint(4) NOT NULL DEFAULT '0',
  `access_end` bigint(20) NOT NULL,
  `member_type` enum('a','m','mm','u') NOT NULL DEFAULT 'u' COMMENT 'a: Master Administrator\r\nm: FT Administrator\r\nmm: Moderator\r\nu: User',
  `mem_status` enum('e','d','h','r','p','rf','m') DEFAULT 'e' COMMENT 'e: Enabled; d: Disabled; h: Hidden; r: Read Only; p: Pending Approval; rf: Refused',
  `account_expire_date` bigint(20) DEFAULT NULL COMMENT 'null value is never expire',
  `level_id` int(11) DEFAULT NULL,
  `mc_id` int(11) DEFAULT NULL,
  `quota` float DEFAULT '2' COMMENT 'event quota field is used for checking number of events of members. Default value is 2 for Web Member',
  `number_of_invitation` float NOT NULL DEFAULT '-1' COMMENT 'number of invitation is used for checking number of external users invited. Default value is unlimited for number. -1 is unlimited, 0 is none. It is number of referrals',
  PRIMARY KEY (`mem_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Структура таблицы `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `subject` tinytext NOT NULL,
  `text` text NOT NULL,
  `owner_id` bigint(20) NOT NULL DEFAULT '0',
  `is_approved` enum('y','n','not_yet') NOT NULL DEFAULT 'not_yet',
  `is_visible` enum('y','n') NOT NULL DEFAULT 'y',
  PRIMARY KEY (`id`),
  KEY `idx_view` (`is_approved`,`is_visible`),
  KEY `idx_owner` (`owner_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `partner_links`
--

CREATE TABLE IF NOT EXISTS `partner_links` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `url` text NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `external_name` varchar(255) NOT NULL DEFAULT '',
  `external_codepage` varchar(10) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `type` enum('free','pay','pay_clicks','pay_view','pay_percent') NOT NULL DEFAULT 'free',
  `free_viewed` bigint(20) NOT NULL DEFAULT '0',
  `pay_end` date NOT NULL DEFAULT '0000-00-00',
  `pay_clicks` bigint(20) unsigned NOT NULL DEFAULT '0',
  `pay_clicked` bigint(20) unsigned NOT NULL DEFAULT '0',
  `pay_views` bigint(20) unsigned NOT NULL DEFAULT '0',
  `pay_viewed` bigint(20) unsigned NOT NULL DEFAULT '0',
  `pay_percent_clicks` float NOT NULL DEFAULT '0',
  `pay_percent_clicked` bigint(20) NOT NULL DEFAULT '0',
  `pay_percent` float NOT NULL DEFAULT '0',
  `position` int(10) unsigned NOT NULL DEFAULT '0',
  `is_enabled` tinyint(1) NOT NULL DEFAULT '0',
  `added_datetime` int(10) unsigned NOT NULL DEFAULT '0',
  `added_by` bigint(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `position` (`position`),
  KEY `idx_banners` (`type`,`pay_end`,`pay_clicks`,`pay_clicked`,`pay_views`,`pay_viewed`,`pay_percent_clicks`,`pay_percent_clicked`,`pay_percent`,`is_enabled`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Структура таблицы `partner_links_config`
--

CREATE TABLE IF NOT EXISTS `partner_links_config` (
  `name` varchar(255) NOT NULL DEFAULT '',
  `value` varchar(255) NOT NULL DEFAULT '',
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `partner_links_stats`
--

CREATE TABLE IF NOT EXISTS `partner_links_stats` (
  `s_datetime` int(10) unsigned NOT NULL DEFAULT '0',
  `s_type` varchar(10) NOT NULL DEFAULT '',
  `s_id` bigint(20) NOT NULL DEFAULT '0',
  `s_user_id` bigint(20) NOT NULL DEFAULT '0',
  `s_referer` varchar(255) NOT NULL DEFAULT '',
  `s_ip` bigint(20) NOT NULL DEFAULT '0',
  KEY `s_id` (`s_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `ratings`
--

CREATE TABLE IF NOT EXISTS `ratings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Структура таблицы `rating_history`
--

CREATE TABLE IF NOT EXISTS `rating_history` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `rating_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `item_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `time_add` bigint(20) unsigned NOT NULL DEFAULT '0',
  `action` enum('add','delete') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'add',
  `value` bigint(20) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `rating_id` (`rating_id`),
  KEY `item_id` (`item_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Структура таблицы `rating_values`
--

CREATE TABLE IF NOT EXISTS `rating_values` (
  `rating_id` bigint(20) NOT NULL DEFAULT '0',
  `item_id` bigint(20) NOT NULL DEFAULT '0',
  `value` bigint(20) NOT NULL DEFAULT '0',
  UNIQUE KEY `rating_idx` (`rating_id`,`item_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `schools`
--

CREATE TABLE IF NOT EXISTS `schools` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `image_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `owner_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `city_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `email` text COLLATE utf8_unicode_ci NOT NULL,
  `icq` bigint(20) unsigned NOT NULL DEFAULT '0',
  `url` text COLLATE utf8_unicode_ci NOT NULL,
  `address` text COLLATE utf8_unicode_ci NOT NULL,
  `phone_1` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `phone_2` varchar(15) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `created_date_time` int(11) NOT NULL DEFAULT '0',
  `position` bigint(20) unsigned NOT NULL DEFAULT '0',
  `payed_link_date_start` int(11) NOT NULL DEFAULT '0',
  `payed_link_date_end` int(11) NOT NULL DEFAULT '0',
  `last_updated_date` int(11) NOT NULL DEFAULT '0',
  `is_approved` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Структура таблицы `school_blog`
--

CREATE TABLE IF NOT EXISTS `school_blog` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `pid` bigint(20) NOT NULL DEFAULT '0',
  `school_id` bigint(20) NOT NULL DEFAULT '0',
  `text` text NOT NULL,
  `author_id` bigint(20) NOT NULL DEFAULT '0',
  `created_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `is_approved` enum('y','n','p') NOT NULL COMMENT 'y - yes, n - no, p - in process',
  `moderator_id` bigint(20) unsigned NOT NULL,
  `approve_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

-- --------------------------------------------------------

--
-- Структура таблицы `sessions`
--

CREATE TABLE IF NOT EXISTS `sessions` (
  `sess_id` char(16) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `createdTime` bigint(20) unsigned NOT NULL DEFAULT '0',
  `updatedTime` bigint(20) NOT NULL DEFAULT '0',
  `expireTime` bigint(20) unsigned NOT NULL DEFAULT '0',
  `state` enum('active','expired','closed','deleted') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'active',
  `type` enum('web','wap') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'web',
  `remote_addr` char(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `user_agent` char(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`sess_id`),
  KEY `user_id` (`user_id`),
  KEY `remote_addr` (`remote_addr`),
  KEY `user_agent` (`user_agent`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `sessions_data`
--

CREATE TABLE IF NOT EXISTS `sessions_data` (
  `sess_id` char(16) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `s_param` char(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `s_value` char(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  UNIQUE KEY `sess_id_2` (`sess_id`,`s_param`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `login` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `password` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `email` text COLLATE utf8_unicode_ci NOT NULL,
  `type` enum('guest','user','vip_user','moderator','admin') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'guest',
  `state` enum('not_active','active','banned') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'not_active',
  `is_autologin` tinyint(4) NOT NULL DEFAULT '0',
  `createdTime` int(11) NOT NULL DEFAULT '0',
  `lastEnterTime` bigint(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`),
  KEY `login` (`login`),
  KEY `password` (`password`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Структура таблицы `users_data`
--

CREATE TABLE IF NOT EXISTS `users_data` (
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `u_param` char(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `u_value` char(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  UNIQUE KEY `user_id_2` (`user_id`,`u_param`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;