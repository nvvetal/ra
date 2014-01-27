-- phpMyAdmin SQL Dump
-- version 2.11.7
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Авг 30 2010 г., 09:46
-- Версия сервера: 5.0.51
-- Версия PHP: 5.2.6

--
-- База данных: `rakscom`
--

-- --------------------------------------------------------

--
-- Структура таблицы `advertise`
--

CREATE TABLE IF NOT EXISTS `advertise` (
  `a_time` bigint(20) NOT NULL default '0',
  `a_type` varchar(5) NOT NULL default '',
  `a_value` varchar(255) NOT NULL default '',
  KEY `a_type` (`a_type`)
) TYPE=MyISAM;

--
-- Дамп данных таблицы `advertise`
--


-- --------------------------------------------------------

--
-- Структура таблицы `banners_ip`
--

CREATE TABLE IF NOT EXISTS `banners_ip` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `ip` bigint(20) NOT NULL,
  `time_showed` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `fast_idx` (`ip`,`time_showed`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

--
-- Дамп данных таблицы `banners_ip`
--


-- --------------------------------------------------------

--
-- Структура таблицы `blog_firm`
--

CREATE TABLE IF NOT EXISTS `blog_firm` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `firm_id` bigint(20) unsigned NOT NULL default '0',
  `post_datetime` bigint(20) unsigned NOT NULL default '0',
  `post_text` text NOT NULL,
  `post_count` bigint(20) unsigned NOT NULL default '0',
  `is_approved` enum('not_yet','yes','no') NOT NULL default 'not_yet',
  `approved_by` bigint(20) NOT NULL default '0',
  `approved_datetime` bigint(20) unsigned NOT NULL default '0',
  `approved_no_reason_id` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

--
-- Дамп данных таблицы `blog_firm`
--


-- --------------------------------------------------------

--
-- Структура таблицы `blog_firm_posts`
--

CREATE TABLE IF NOT EXISTS `blog_firm_posts` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `parent_id` bigint(20) unsigned NOT NULL default '0',
  `blog_id` bigint(20) unsigned NOT NULL default '0',
  `poster_id` bigint(20) unsigned NOT NULL default '0',
  `message` text NOT NULL,
  `is_approved` enum('not_yet','yes','not') NOT NULL default 'not_yet',
  `approved_by` bigint(20) unsigned NOT NULL default '0',
  `approved_datetime` bigint(20) unsigned NOT NULL default '0',
  `approved_no_reason_id` bigint(20) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

--
-- Дамп данных таблицы `blog_firm_posts`
--


-- --------------------------------------------------------

--
-- Структура таблицы `blog_firm_tags`
--

CREATE TABLE IF NOT EXISTS `blog_firm_tags` (
  `blog_id` bigint(20) unsigned NOT NULL default '0',
  `tag` varchar(50) NOT NULL default '',
  KEY `tag` (`tag`),
  KEY `blog_id` (`blog_id`)
) TYPE=MyISAM;

--
-- Дамп данных таблицы `blog_firm_tags`
--


-- --------------------------------------------------------

--
-- Структура таблицы `calendar`
--

CREATE TABLE IF NOT EXISTS `calendar` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `bdate` date NOT NULL default '0000-00-00',
  `city_id` bigint(20) NOT NULL default '0',
  `address` varchar(255) NOT NULL default '',
  `category_id` bigint(20) unsigned NOT NULL default '0',
  `small_info` varchar(100) NOT NULL default '',
  `full_info` text NOT NULL,
  `creator_id` bigint(20) unsigned NOT NULL default '0',
  `organizator_name` varchar(255) NOT NULL default '',
  `is_approved` int(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM  AUTO_INCREMENT=14 ;

--
-- Дамп данных таблицы `calendar`
--

INSERT INTO `calendar` (`id`, `bdate`, `city_id`, `address`, `category_id`, `small_info`, `full_info`, `creator_id`, `organizator_name`, `is_approved`) VALUES
(13, '2010-08-27', 1, 'яяяя', 3, 'сачяп', 'вапвыапвап', 1, 'ваыпавп выа па', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `calendar_additional_info`
--

CREATE TABLE IF NOT EXISTS `calendar_additional_info` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `calendar_id` bigint(20) unsigned NOT NULL default '0',
  `name` char(20) NOT NULL default '',
  `value` char(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `idx_calendar` (`calendar_id`,`name`)
) TYPE=MyISAM  AUTO_INCREMENT=114 ;

--
-- Дамп данных таблицы `calendar_additional_info`
--

INSERT INTO `calendar_additional_info` (`id`, `calendar_id`, `name`, `value`) VALUES
(113, 13, 'image0', '10');

-- --------------------------------------------------------

--
-- Структура таблицы `calendar_categories`
--

CREATE TABLE IF NOT EXISTS `calendar_categories` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM  AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `calendar_categories`
--

INSERT INTO `calendar_categories` (`id`, `name`) VALUES
(3, 'Мероприятие'),
(4, 'Мероприятие 2');

-- --------------------------------------------------------

--
-- Структура таблицы `cities`
--

CREATE TABLE IF NOT EXISTS `cities` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `country_id` tinyint(3) unsigned NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM  AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `cities`
--

INSERT INTO `cities` (`id`, `country_id`, `name`) VALUES
(1, 1, 'Мухосранск');

-- --------------------------------------------------------

--
-- Структура таблицы `config`
--

CREATE TABLE IF NOT EXISTS `config` (
  `name` varchar(255) NOT NULL default '',
  `value` varchar(255) NOT NULL default '',
  UNIQUE KEY `name` (`name`)
) TYPE=MyISAM;

--
-- Дамп данных таблицы `config`
--


-- --------------------------------------------------------

--
-- Структура таблицы `countries`
--

CREATE TABLE IF NOT EXISTS `countries` (
  `id` tinyint(3) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `short_name` varchar(3) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM  AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `countries`
--

INSERT INTO `countries` (`id`, `name`, `short_name`) VALUES
(1, 'Ukraine', 'ua');

-- --------------------------------------------------------

--
-- Структура таблицы `firms`
--

CREATE TABLE IF NOT EXISTS `firms` (
  `firm_id` bigint(20) unsigned NOT NULL auto_increment,
  `user_id` bigint(20) unsigned NOT NULL default '0',
  `createTime` bigint(20) NOT NULL default '0',
  `state` enum('not_active','active','vip','banned') NOT NULL default 'not_active',
  PRIMARY KEY  (`firm_id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

--
-- Дамп данных таблицы `firms`
--


-- --------------------------------------------------------

--
-- Структура таблицы `firms_data`
--

CREATE TABLE IF NOT EXISTS `firms_data` (
  `firm_id` bigint(20) unsigned NOT NULL default '0',
  `f_param` char(100) NOT NULL default '',
  `f_value` char(255) NOT NULL default '',
  KEY `firm_id` (`firm_id`,`f_param`)
) TYPE=MyISAM;

--
-- Дамп данных таблицы `firms_data`
--


-- --------------------------------------------------------

--
-- Структура таблицы `images`
--

CREATE TABLE IF NOT EXISTS `images` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `owner_id` bigint(20) unsigned NOT NULL default '0',
  `owner_type` enum('unknown','user','school') NOT NULL default 'unknown',
  `path` varchar(24) NOT NULL default '',
  `img_type` varchar(255) NOT NULL default '',
  `fname` varchar(30) NOT NULL default '',
  `approve_state` tinyint(1) NOT NULL default '0',
  `is_public` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM  AUTO_INCREMENT=12 ;

--
-- Дамп данных таблицы `images`
--

INSERT INTO `images` (`id`, `owner_id`, `owner_type`, `path`, `img_type`, `fname`, `approve_state`, `is_public`) VALUES
(1, 1, 'user', 'f41/48780af571359be56c53', 'image/jpeg', '48780af571359be56c53', 0, 0),
(2, 1, 'user', 'ba2/26c5db28fecd8fe4218b', 'image/jpeg', '26c5db28fecd8fe4218b', 0, 0),
(3, 1, 'user', '9f9/31a20ecdb7dd7b373e62', 'image/jpeg', '31a20ecdb7dd7b373e62', 0, 0),
(4, 1, 'user', 'a17/f0c1756f69f3fecbe240', 'image/jpeg', 'f0c1756f69f3fecbe240', 0, 0),
(5, 1, 'user', '91e/51485a1983e23e4228e7', 'image/jpeg', '51485a1983e23e4228e7', 0, 0),
(6, 1, 'user', '728/79ff63851ec9e5cbcf48', 'image/jpeg', '79ff63851ec9e5cbcf48', 0, 0),
(7, 1, 'user', 'ac0/f946ed01198f22a2ed94', 'image/jpeg', 'f946ed01198f22a2ed94', 0, 0),
(8, 1, 'user', '118/af2d30c4f1e0e8fec7ee', 'image/gif', 'af2d30c4f1e0e8fec7ee', 0, 0),
(9, 1, 'user', '967/6782d84d1a96cbb9ef15', 'image/gif', '6782d84d1a96cbb9ef15', 0, 0),
(10, 13, '', '075/e56cd3c4d483ca29cd26', 'image/gif', 'e56cd3c4d483ca29cd26', 0, 0),
(11, 3, 'school', '6e6/a4f369a191e9b6210ee9', 'image/gif', 'a4f369a191e9b6210ee9', 0, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `subject` tinytext NOT NULL,
  `text` text NOT NULL,
  `owner_id` bigint(20) NOT NULL default '0',
  `is_approved` enum('y','n','not_yet') NOT NULL default 'not_yet',
  `is_visible` enum('y','n') NOT NULL default 'y',
  PRIMARY KEY  (`id`),
  KEY `idx_view` (`is_approved`,`is_visible`),
  KEY `idx_owner` (`owner_id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

--
-- Дамп данных таблицы `news`
--


-- --------------------------------------------------------

--
-- Структура таблицы `partner_links`
--

CREATE TABLE IF NOT EXISTS `partner_links` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `url` text NOT NULL,
  `name` varchar(255) NOT NULL default '',
  `external_name` varchar(255) NOT NULL default '',
  `external_codepage` varchar(10) NOT NULL default '',
  `description` text NOT NULL,
  `type` enum('free','pay','pay_clicks','pay_view','pay_percent') NOT NULL default 'free',
  `free_viewed` bigint(20) NOT NULL default '0',
  `pay_end` date NOT NULL default '0000-00-00',
  `pay_clicks` bigint(20) unsigned NOT NULL default '0',
  `pay_clicked` bigint(20) unsigned NOT NULL default '0',
  `pay_views` bigint(20) unsigned NOT NULL default '0',
  `pay_viewed` bigint(20) unsigned NOT NULL default '0',
  `pay_percent_clicks` float NOT NULL default '0',
  `pay_percent_clicked` bigint(20) NOT NULL default '0',
  `pay_percent` float NOT NULL default '0',
  `position` int(10) unsigned NOT NULL default '0',
  `is_enabled` tinyint(1) NOT NULL default '0',
  `added_datetime` int(10) unsigned NOT NULL default '0',
  `added_by` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `position` (`position`),
  KEY `idx_banners` (`type`,`pay_end`,`pay_clicks`,`pay_clicked`,`pay_views`,`pay_viewed`,`pay_percent_clicks`,`pay_percent_clicked`,`pay_percent`,`is_enabled`)
) TYPE=MyISAM  AUTO_INCREMENT=8 ;

--
-- Дамп данных таблицы `partner_links`
--

INSERT INTO `partner_links` (`id`, `url`, `name`, `external_name`, `external_codepage`, `description`, `type`, `free_viewed`, `pay_end`, `pay_clicks`, `pay_clicked`, `pay_views`, `pay_viewed`, `pay_percent_clicks`, `pay_percent_clicked`, `pay_percent`, `position`, `is_enabled`, `added_datetime`, `added_by`) VALUES
(1, 'http://google.com', 'google', 'zzzz', 'UTF-8', 'search site', 'pay', 1, '2009-12-19', 2, 3, 4, 5, 6, 0, 0.5, 1, 1, 0, 0),
(2, 'http://raks.com.ua', 'raks', 'Танец ЖЫВОТА', 'cp1251', '', 'pay_view', 0, '2008-12-01', 0, 0, 1000, 104, 0, 0, 1, 2, 1, 0, 0),
(4, 'zzzzzzzzzz', '323434', '', '', '', 'pay_clicks', 0, '2008-06-07', 5, 6, 0, 0, 0, 0, 1, 3, 1, 1212858268, 0),
(7, 'http://zhitomirhost.com', 'zhitomirhost', '11', '', '', 'pay_percent', 0, '2008-06-08', 0, 0, 0, 0, 1.6, 0, 0.7, 4, 1, 1212933593, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `partner_links_config`
--

CREATE TABLE IF NOT EXISTS `partner_links_config` (
  `name` varchar(255) NOT NULL default '',
  `value` varchar(255) NOT NULL default '',
  UNIQUE KEY `name` (`name`)
) TYPE=MyISAM;

--
-- Дамп данных таблицы `partner_links_config`
--

INSERT INTO `partner_links_config` (`name`, `value`) VALUES
('visible_name', 'Портнерчики:&nbsp;');

-- --------------------------------------------------------

--
-- Структура таблицы `partner_links_stats`
--

CREATE TABLE IF NOT EXISTS `partner_links_stats` (
  `s_datetime` int(10) unsigned NOT NULL default '0',
  `s_type` varchar(10) NOT NULL default '',
  `s_id` bigint(20) NOT NULL default '0',
  `s_user_id` bigint(20) NOT NULL default '0',
  `s_referer` varchar(255) NOT NULL default '',
  `s_ip` bigint(20) NOT NULL default '0',
  KEY `s_id` (`s_id`)
) TYPE=MyISAM;

--
-- Дамп данных таблицы `partner_links_stats`
--

INSERT INTO `partner_links_stats` (`s_datetime`, `s_type`, `s_id`, `s_user_id`, `s_referer`, `s_ip`) VALUES
(1212936694, 'view', 1, 0, '', 0),
(1212936694, 'view', 2, 0, '', 0),
(1212936706, 'click', 2, 0, '', 0),
(1212936726, 'click', 2, 0, 'http://rakscom.n.wap3.com.ua/partner_links/dynamic_link.php?id=2', 0),
(1212937103, 'view', 1, 0, 'http://rakscom.n.wap3.com.ua/partner_links/?s=5a53445e4867f57', 3262021123),
(1212937103, 'view', 2, 0, 'http://rakscom.n.wap3.com.ua/partner_links/?s=5a53445e4867f57', 3262021123),
(1212937809, 'view', 1, 0, 'http://rakscom.n.wap3.com.ua/partner_links/?s=5a53445e4867f57', 3262021123),
(1212937809, 'view', 2, 0, 'http://rakscom.n.wap3.com.ua/partner_links/?s=5a53445e4867f57', 3262021123),
(1212937845, 'view', 1, 0, 'http://rakscom.n.wap3.com.ua/partner_links/?s=5a53445e4867f57&go=edit_link&id=1', 3262021123),
(1212937845, 'view', 2, 0, 'http://rakscom.n.wap3.com.ua/partner_links/?s=5a53445e4867f57&go=edit_link&id=1', 3262021123),
(1212937891, 'click', 1, 0, 'http://rakscom.n.wap3.com.ua/partner_links/1.html', 3262021123),
(1212938258, 'click', 4, 0, 'http://rakscom.n.wap3.com.ua/partner_links/1.html', 3262021123),
(1212938260, 'view', 1, 0, 'http://rakscom.n.wap3.com.ua/partner_links/index.php', 3262021123),
(1212938260, 'view', 2, 0, 'http://rakscom.n.wap3.com.ua/partner_links/index.php', 3262021123),
(1212938406, 'click', 4, 0, 'http://rakscom.n.wap3.com.ua/partner_links/1.html', 3262021123),
(1212938408, 'view', 1, 0, 'http://rakscom.n.wap3.com.ua/partner_links/?s=03413d0e0e01702', 3262021123),
(1212938408, 'view', 2, 0, 'http://rakscom.n.wap3.com.ua/partner_links/?s=03413d0e0e01702', 3262021123),
(1212938739, 'view', 1, 0, 'http://rakscom.n.wap3.com.ua/partner_links/?s=03413d0e0e01702', 3262021123),
(1212938739, 'view', 2, 0, 'http://rakscom.n.wap3.com.ua/partner_links/?s=03413d0e0e01702', 3262021123),
(1212938740, 'view', 2, 0, 'http://rakscom.n.wap3.com.ua/partner_links/?s=03413d0e0e01702&action=up&id=2', 3262021123),
(1212938740, 'view', 1, 0, 'http://rakscom.n.wap3.com.ua/partner_links/?s=03413d0e0e01702&action=up&id=2', 3262021123),
(1212938741, 'view', 1, 0, 'http://rakscom.n.wap3.com.ua/partner_links/?s=03413d0e0e01702&action=up&id=2', 3262021123),
(1212938741, 'view', 2, 0, 'http://rakscom.n.wap3.com.ua/partner_links/?s=03413d0e0e01702&action=up&id=2', 3262021123),
(1212950510, 'view', 1, 0, '', 3262021123),
(1212950510, 'view', 2, 0, '', 3262021123),
(1212953421, 'view', 1, 0, 'http://rakscom.n.wap3.com.ua/partner_links/index.php', 3262021123),
(1212953421, 'view', 2, 0, 'http://rakscom.n.wap3.com.ua/partner_links/index.php', 3262021123),
(1212953421, 'view', 1, 0, 'http://rakscom.n.wap3.com.ua/partner_links/?s=5679ab674918b4f', 3262021123),
(1212953421, 'view', 2, 0, 'http://rakscom.n.wap3.com.ua/partner_links/?s=5679ab674918b4f', 3262021123),
(1212953462, 'view', 1, 0, 'http://rakscom.n.wap3.com.ua/partner_links/index.php', 3262021123),
(1212953462, 'view', 2, 0, 'http://rakscom.n.wap3.com.ua/partner_links/index.php', 3262021123),
(1212953463, 'view', 1, 0, 'http://rakscom.n.wap3.com.ua/partner_links/?s=5679ab674918b4f', 3262021123),
(1212953463, 'view', 2, 0, 'http://rakscom.n.wap3.com.ua/partner_links/?s=5679ab674918b4f', 3262021123),
(1212953479, 'view', 1, 0, 'http://rakscom.n.wap3.com.ua/partner_links/?s=5679ab674918b4f', 3262021123),
(1212953479, 'view', 2, 0, 'http://rakscom.n.wap3.com.ua/partner_links/?s=5679ab674918b4f', 3262021123),
(1212953482, 'view', 1, 0, 'http://rakscom.n.wap3.com.ua/partner_links/?s=5679ab674918b4f', 3262021123),
(1212953482, 'view', 2, 0, 'http://rakscom.n.wap3.com.ua/partner_links/?s=5679ab674918b4f', 3262021123),
(1212953482, 'view', 1, 0, 'http://rakscom.n.wap3.com.ua/partner_links/?s=5679ab674918b4f', 3262021123),
(1212953482, 'view', 2, 0, 'http://rakscom.n.wap3.com.ua/partner_links/?s=5679ab674918b4f', 3262021123),
(1212953657, 'view', 1, 0, 'http://rakscom.n.wap3.com.ua/partner_links/?s=5679ab674918b4f', 3262021123),
(1212953657, 'view', 2, 0, 'http://rakscom.n.wap3.com.ua/partner_links/?s=5679ab674918b4f', 3262021123),
(1212953658, 'view', 1, 0, 'http://rakscom.n.wap3.com.ua/partner_links/?s=5679ab674918b4f', 3262021123),
(1212953658, 'view', 2, 0, 'http://rakscom.n.wap3.com.ua/partner_links/?s=5679ab674918b4f', 3262021123),
(1212953659, 'view', 1, 0, 'http://rakscom.n.wap3.com.ua/partner_links/?s=5679ab674918b4f', 3262021123),
(1212953659, 'view', 2, 0, 'http://rakscom.n.wap3.com.ua/partner_links/?s=5679ab674918b4f', 3262021123),
(1212953770, 'click', 4, 0, 'http://rakscom.n.wap3.com.ua/partner_links/1.html', 3262021123),
(1212953772, 'view', 1, 0, 'http://rakscom.n.wap3.com.ua/partner_links/?s=5679ab674918b4f', 3262021123),
(1212953772, 'view', 2, 0, 'http://rakscom.n.wap3.com.ua/partner_links/?s=5679ab674918b4f', 3262021123),
(1212953775, 'view', 1, 0, 'http://rakscom.n.wap3.com.ua/partner_links/?s=5679ab674918b4f', 3262021123),
(1212953775, 'view', 2, 0, 'http://rakscom.n.wap3.com.ua/partner_links/?s=5679ab674918b4f', 3262021123),
(1212953922, 'click', 4, 0, 'http://rakscom.n.wap3.com.ua/partner_links/1.html', 3262021123),
(1212953926, 'view', 1, 0, 'http://rakscom.n.wap3.com.ua/partner_links/?s=5679ab674918b4f', 3262021123),
(1212953926, 'view', 2, 0, 'http://rakscom.n.wap3.com.ua/partner_links/?s=5679ab674918b4f', 3262021123),
(1212953927, 'view', 1, 0, 'http://rakscom.n.wap3.com.ua/partner_links/?s=5679ab674918b4f', 3262021123),
(1212953927, 'view', 2, 0, 'http://rakscom.n.wap3.com.ua/partner_links/?s=5679ab674918b4f', 3262021123),
(1212954021, 'click', 7, 0, 'http://rakscom.n.wap3.com.ua/partner_links/1.html', 3262021123),
(1212954027, 'view', 1, 0, 'http://rakscom.n.wap3.com.ua/partner_links/?s=5679ab674918b4f', 3262021123),
(1212954027, 'view', 2, 0, 'http://rakscom.n.wap3.com.ua/partner_links/?s=5679ab674918b4f', 3262021123),
(1212954394, 'click', 7, 0, 'http://rakscom.n.wap3.com.ua/partner_links/1.html', 3262021123),
(1212955073, 'view', 1, 1, 'http://rakscom.n.wap3.com.ua/partner_links/?s=5679ab674918b4f', 3262021123),
(1212955073, 'view', 2, 1, 'http://rakscom.n.wap3.com.ua/partner_links/?s=5679ab674918b4f', 3262021123),
(1212955073, 'view', 7, 1, 'http://rakscom.n.wap3.com.ua/partner_links/?s=5679ab674918b4f', 3262021123),
(1212955082, 'view', 1, 1, 'http://rakscom.n.wap3.com.ua/partner_links/?s=5679ab674918b4f', 3262021123),
(1212955082, 'view', 2, 1, 'http://rakscom.n.wap3.com.ua/partner_links/?s=5679ab674918b4f', 3262021123),
(1212955082, 'view', 7, 1, 'http://rakscom.n.wap3.com.ua/partner_links/?s=5679ab674918b4f', 3262021123),
(1212955164, 'view', 1, 1, 'http://rakscom.n.wap3.com.ua/partner_links/?s=1fa0e9a68fe0488', 3262021123),
(1212955164, 'view', 2, 1, 'http://rakscom.n.wap3.com.ua/partner_links/?s=1fa0e9a68fe0488', 3262021123),
(1212955164, 'view', 7, 1, 'http://rakscom.n.wap3.com.ua/partner_links/?s=1fa0e9a68fe0488', 3262021123),
(1213697914, 'view', 1, 1, 'http://rakscom.n.wap3.com.ua/partner_links/?s=ac292bc8c5e1150', 182326927),
(1213697914, 'view', 2, 1, 'http://rakscom.n.wap3.com.ua/partner_links/?s=ac292bc8c5e1150', 182326927),
(1213697914, 'view', 7, 1, 'http://rakscom.n.wap3.com.ua/partner_links/?s=ac292bc8c5e1150', 182326927),
(1215427570, 'view', 1, 1, 'http://rakscom.n.wap3.com.ua/partner_links/?s=9ac84e2ac7bdb85', 182326927),
(1215427570, 'view', 2, 1, 'http://rakscom.n.wap3.com.ua/partner_links/?s=9ac84e2ac7bdb85', 182326927),
(1215427570, 'view', 7, 1, 'http://rakscom.n.wap3.com.ua/partner_links/?s=9ac84e2ac7bdb85', 182326927),
(1215440522, 'view', 1, 1, 'http://rakscom.n.wap3.com.ua/partner_links/?s=6d52e345bd4f395', 182326927),
(1215440522, 'view', 2, 1, 'http://rakscom.n.wap3.com.ua/partner_links/?s=6d52e345bd4f395', 182326927),
(1215440522, 'view', 7, 1, 'http://rakscom.n.wap3.com.ua/partner_links/?s=6d52e345bd4f395', 182326927),
(1215440553, 'view', 1, 1, 'http://rakscom.n.wap3.com.ua/partner_links/', 182326927),
(1215440553, 'view', 2, 1, 'http://rakscom.n.wap3.com.ua/partner_links/', 182326927),
(1215440553, 'view', 7, 1, 'http://rakscom.n.wap3.com.ua/partner_links/', 182326927),
(1215440703, 'view', 1, 1, 'http://rakscom.n.wap3.com.ua/partner_links/?s=6d52e345bd4f395', 182326927),
(1215440703, 'view', 2, 1, 'http://rakscom.n.wap3.com.ua/partner_links/?s=6d52e345bd4f395', 182326927),
(1215440703, 'view', 7, 1, 'http://rakscom.n.wap3.com.ua/partner_links/?s=6d52e345bd4f395', 182326927),
(1215440708, 'view', 1, 1, 'http://rakscom.n.wap3.com.ua/partner_links/', 182326927),
(1215440708, 'view', 2, 1, 'http://rakscom.n.wap3.com.ua/partner_links/', 182326927),
(1215440708, 'view', 7, 1, 'http://rakscom.n.wap3.com.ua/partner_links/', 182326927),
(1215440845, 'view', 1, 1, 'http://rakscom.n.wap3.com.ua/partner_links/?s=6d52e345bd4f395', 182326927),
(1215440845, 'view', 2, 1, 'http://rakscom.n.wap3.com.ua/partner_links/?s=6d52e345bd4f395', 182326927),
(1215440845, 'view', 7, 1, 'http://rakscom.n.wap3.com.ua/partner_links/?s=6d52e345bd4f395', 182326927),
(1215440850, 'view', 1, 1, 'http://rakscom.n.wap3.com.ua/partner_links/', 182326927),
(1215440850, 'view', 2, 1, 'http://rakscom.n.wap3.com.ua/partner_links/', 182326927),
(1215440850, 'view', 7, 1, 'http://rakscom.n.wap3.com.ua/partner_links/', 182326927),
(1215440859, 'view', 1, 1, 'http://rakscom.n.wap3.com.ua/partner_links/', 182326927),
(1215440859, 'view', 2, 1, 'http://rakscom.n.wap3.com.ua/partner_links/', 182326927),
(1215440859, 'view', 7, 1, 'http://rakscom.n.wap3.com.ua/partner_links/', 182326927),
(1215440890, 'view', 1, 1, 'http://rakscom.n.wap3.com.ua/partner_links/?s=6d52e345bd4f395', 182326927),
(1215440890, 'view', 2, 1, 'http://rakscom.n.wap3.com.ua/partner_links/?s=6d52e345bd4f395', 182326927),
(1215440890, 'view', 7, 1, 'http://rakscom.n.wap3.com.ua/partner_links/?s=6d52e345bd4f395', 182326927),
(1215441428, 'view', 1, 1, 'http://rakscom.n.wap3.com.ua/partner_links/', 182326927),
(1215441428, 'view', 2, 1, 'http://rakscom.n.wap3.com.ua/partner_links/', 182326927),
(1215441428, 'view', 7, 1, 'http://rakscom.n.wap3.com.ua/partner_links/', 182326927),
(1215441433, 'view', 1, 1, 'http://rakscom.n.wap3.com.ua/partner_links/', 182326927),
(1215441433, 'view', 2, 1, 'http://rakscom.n.wap3.com.ua/partner_links/', 182326927),
(1215441433, 'view', 7, 1, 'http://rakscom.n.wap3.com.ua/partner_links/', 182326927),
(1215441953, 'view', 1, 1, 'http://rakscom.n.wap3.com.ua/partner_links/', 182326927),
(1215441953, 'view', 2, 1, 'http://rakscom.n.wap3.com.ua/partner_links/', 182326927),
(1215441953, 'view', 7, 1, 'http://rakscom.n.wap3.com.ua/partner_links/', 182326927),
(1215441956, 'view', 1, 1, 'http://rakscom.n.wap3.com.ua/partner_links/', 182326927),
(1215441956, 'view', 2, 1, 'http://rakscom.n.wap3.com.ua/partner_links/', 182326927),
(1215441956, 'view', 7, 1, 'http://rakscom.n.wap3.com.ua/partner_links/', 182326927),
(1215441991, 'view', 1, 1, 'http://rakscom.n.wap3.com.ua/partner_links/', 182326927),
(1215441991, 'view', 2, 1, 'http://rakscom.n.wap3.com.ua/partner_links/', 182326927),
(1215441991, 'view', 7, 1, 'http://rakscom.n.wap3.com.ua/partner_links/', 182326927),
(1215442264, 'view', 1, 1, 'http://rakscom.n.wap3.com.ua/partner_links/', 182326927),
(1215442264, 'view', 2, 1, 'http://rakscom.n.wap3.com.ua/partner_links/', 182326927),
(1215442264, 'view', 7, 1, 'http://rakscom.n.wap3.com.ua/partner_links/', 182326927);

-- --------------------------------------------------------

--
-- Структура таблицы `payment_liqpay`
--

CREATE TABLE IF NOT EXISTS `payment_liqpay` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `order_id` bigint(20) unsigned NOT NULL,
  `type` enum('in','out') NOT NULL,
  `status` char(20) NOT NULL,
  `status_code` char(10) NOT NULL,
  `signature` text NOT NULL,
  `sent` text NOT NULL,
  `got` text NOT NULL,
  `action_time` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `idx_order` (`order_id`,`status`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

--
-- Дамп данных таблицы `payment_liqpay`
--


-- --------------------------------------------------------

--
-- Структура таблицы `payment_orders`
--

CREATE TABLE IF NOT EXISTS `payment_orders` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `payment_type` enum('sms','liqpay') NOT NULL,
  `good_id` bigint(20) unsigned NOT NULL,
  `good_type` char(25) NOT NULL,
  `amount` float NOT NULL,
  `currency` enum('USD','UAH') NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_time` int(11) NOT NULL,
  `is_payed` tinyint(4) NOT NULL default '0',
  `error_pay` text NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

--
-- Дамп данных таблицы `payment_orders`
--


-- --------------------------------------------------------

--
-- Структура таблицы `ratings`
--

CREATE TABLE IF NOT EXISTS `ratings` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `name` (`name`)
) TYPE=MyISAM  AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `ratings`
--

INSERT INTO `ratings` (`id`, `name`) VALUES
(1, 'forum_post');

-- --------------------------------------------------------

--
-- Структура таблицы `rating_history`
--

CREATE TABLE IF NOT EXISTS `rating_history` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `rating_id` bigint(20) unsigned NOT NULL default '0',
  `item_id` bigint(20) unsigned NOT NULL default '0',
  `time_add` bigint(20) unsigned NOT NULL default '0',
  `action` enum('add','delete') NOT NULL default 'add',
  `value` bigint(20) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `rating_id` (`rating_id`),
  KEY `item_id` (`item_id`)
) TYPE=MyISAM  AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `rating_history`
--

INSERT INTO `rating_history` (`id`, `rating_id`, `item_id`, `time_add`, `action`, `value`) VALUES
(1, 1, 47, 1198527487, 'add', 1),
(2, 1, 47, 1198527639, 'add', 1),
(3, 1, 47, 1198528008, 'add', 1),
(4, 1, 47, 1198528035, 'add', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `rating_values`
--

CREATE TABLE IF NOT EXISTS `rating_values` (
  `rating_id` bigint(20) NOT NULL default '0',
  `item_id` bigint(20) NOT NULL default '0',
  `value` bigint(20) NOT NULL default '0',
  UNIQUE KEY `rating_idx` (`rating_id`,`item_id`)
) TYPE=MyISAM;

--
-- Дамп данных таблицы `rating_values`
--

INSERT INTO `rating_values` (`rating_id`, `item_id`, `value`) VALUES
(1, 47, 4);

-- --------------------------------------------------------

--
-- Структура таблицы `schools`
--

CREATE TABLE IF NOT EXISTS `schools` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `description` text NOT NULL,
  `image_id` bigint(20) unsigned NOT NULL default '0',
  `owner_id` bigint(20) unsigned NOT NULL default '0',
  `city_id` bigint(20) unsigned NOT NULL default '0',
  `email` text NOT NULL,
  `icq` bigint(20) unsigned NOT NULL default '0',
  `skype` text NOT NULL,
  `forum_url` text NOT NULL,
  `url` text NOT NULL,
  `address` text NOT NULL,
  `phone_1` varchar(15) NOT NULL default '',
  `phone_2` varchar(15) NOT NULL default '',
  `created_date_time` int(11) NOT NULL default '0',
  `position` bigint(20) unsigned NOT NULL default '0',
  `payed_link_date_start` int(11) NOT NULL default '0',
  `payed_link_date_end` int(11) NOT NULL default '0',
  `last_updated_date` int(11) NOT NULL default '0',
  `is_approved` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM  AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `schools`
--

INSERT INTO `schools` (`id`, `name`, `description`, `image_id`, `owner_id`, `city_id`, `email`, `icq`, `skype`, `forum_url`, `url`, `address`, `phone_1`, `phone_2`, `created_date_time`, `position`, `payed_link_date_start`, `payed_link_date_end`, `last_updated_date`, `is_approved`) VALUES
(1, 'First', 'hmm', 20, 1, 1, 'nv-vetal@rambler.ru', 511723, '', '', '', 'zzzzzzz', '03', '', 1201036984, 1, 1201036984, 1202036984, 1211977670, 1),
(2, 'zzzzz1', 'hmmmmmm', 21, 1, 1, 'nv-vetal@rambler.ru', 0, '', '', '', 'zzzzz', '02', '', 1211981830, 0, 0, 0, 1213707603, 1),
(3, '1111', 'fg hdfhfg hfg dfgh', 11, 1, 1, 'nv-vetal@rambler.ru', 511723, 'gggg', 'http://dfg.com111', 'http://dfg.com', 'fdsh fg fgh', '345345', '435345345', 1282986668, 0, 0, 0, 1283084489, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `sessions`
--

CREATE TABLE IF NOT EXISTS `sessions` (
  `sess_id` char(16) NOT NULL default '',
  `user_id` bigint(20) unsigned NOT NULL default '0',
  `createdTime` bigint(20) unsigned NOT NULL default '0',
  `updatedTime` bigint(20) NOT NULL default '0',
  `expireTime` bigint(20) unsigned NOT NULL default '0',
  `state` enum('active','expired','closed','deleted') NOT NULL default 'active',
  `type` enum('web','wap') NOT NULL default 'web',
  `remote_addr` char(20) NOT NULL default '',
  `user_agent` char(255) NOT NULL default '',
  PRIMARY KEY  (`sess_id`),
  KEY `user_id` (`user_id`),
  KEY `remote_addr` (`remote_addr`),
  KEY `user_agent` (`user_agent`)
) TYPE=MyISAM;

--
-- Дамп данных таблицы `sessions`
--

INSERT INTO `sessions` (`sess_id`, `user_id`, `createdTime`, `updatedTime`, `expireTime`, `state`, `type`, `remote_addr`, `user_agent`) VALUES
('cbea4c82df22e16', 0, 1213289745, 1213292241, 1213295841, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.14) Gecko/20080404 Firefox/2.0.0.14'),
('9ac6f4317d6520a', 0, 1213298179, 0, 1213301779, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.14) Gecko/20080404 Firefox/2.0.0.14'),
('d2309f7625a1d0a', 0, 1213299925, 0, 1213303525, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.14) Gecko/20080404 Firefox/2.0.0.14'),
('f856d34a0477f24', 0, 1213299929, 0, 1213303529, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.14) Gecko/20080404 Firefox/2.0.0.14'),
('84703c34e038065', 0, 1213299937, 0, 1213303537, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.14) Gecko/20080404 Firefox/2.0.0.14'),
('87126b478a6c0d3', 0, 1213299965, 0, 1213303565, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.14) Gecko/20080404 Firefox/2.0.0.14'),
('cf9ced664c013f0', 0, 1213299996, 0, 1213303596, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.14) Gecko/20080404 Firefox/2.0.0.14'),
('a623a068c052608', 0, 1213300055, 1213302819, 1213306419, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.14) Gecko/20080404 Firefox/2.0.0.14'),
('6b71b87888bc2d0', 0, 1213302821, 0, 1213306421, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.14) Gecko/20080404 Firefox/2.0.0.14'),
('87e0327130e3f8b', 0, 1213302852, 0, 1213306452, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.14) Gecko/20080404 Firefox/2.0.0.14'),
('9b75a6cd3baef61', 0, 1213303433, 0, 1213307033, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.14) Gecko/20080404 Firefox/2.0.0.14'),
('ff4e7c106cef4f3', 0, 1213303437, 1213303450, 1213307050, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.14) Gecko/20080404 Firefox/2.0.0.14'),
('4283b4ad22de924', 0, 1213303455, 1213303456, 1213307056, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.14) Gecko/20080404 Firefox/2.0.0.14'),
('10a337d55d72ce1', 0, 1213303459, 1213303460, 1213307060, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.14) Gecko/20080404 Firefox/2.0.0.14'),
('d31ec1dc0b77b3d', 0, 1213303574, 0, 1213307174, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.14) Gecko/20080404 Firefox/2.0.0.14'),
('c69a5160be06b47', 0, 1213303580, 1213303994, 1213307594, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.14) Gecko/20080404 Firefox/2.0.0.14'),
('cc5b9f65cc97922', 0, 1213355465, 0, 1213359065, 'active', 'web', '10.222.22.143', 'Mozilla/5.0 (X11; U; Linux i686; ru; rv:1.8.0.12) Gecko/20070530 Fedora/1.5.0.12-1.fc6 Firefox/1.5.0.12'),
('6d42d68978bc0fb', 0, 1213355473, 1213355475, 1213359075, 'active', 'web', '10.222.22.143', 'Mozilla/5.0 (X11; U; Linux i686; ru; rv:1.8.0.12) Gecko/20070530 Fedora/1.5.0.12-1.fc6 Firefox/1.5.0.12'),
('be2f39c579a683d', 0, 1213522421, 1213522473, 1213526073, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.14) Gecko/20080404 Firefox/2.0.0.14'),
('45130a349a28730', 0, 1213544258, 1213544259, 1213547859, 'expired', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.14) Gecko/20080404 Firefox/2.0.0.14'),
('cf025b11809dc54', 1, 1213548659, 1213549638, 1213553238, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.14) Gecko/20080404 Firefox/2.0.0.14'),
('d4a0bc1df4755c9', 1, 1213697896, 1213697906, 1213701506, 'active', 'web', '10.222.22.143', 'Mozilla/5.0 (X11; U; Linux i686; ru; rv:1.8.0.12) Gecko/20070530 Fedora/1.5.0.12-1.fc6 Firefox/1.5.0.12'),
('ac292bc8c5e1150', 1, 1213697909, 1213698241, 1213701841, 'active', 'web', '10.222.22.143', 'Mozilla/5.0 (X11; U; Linux i686; ru; rv:1.8.0.12) Gecko/20070530 Fedora/1.5.0.12-1.fc6 Firefox/1.5.0.12'),
('7e4a388d7938a10', 1, 1213697914, 0, 1213701514, 'active', 'web', '10.222.22.143', 'Mozilla/5.0 (X11; U; Linux i686; ru; rv:1.8.0.12) Gecko/20070530 Fedora/1.5.0.12-1.fc6 Firefox/1.5.0.12'),
('bef5d0c6d17670f', 1, 1213700610, 1213700891, 1213704491, 'expired', 'web', '10.222.22.143', 'Mozilla/5.0 (X11; U; Linux i686; ru; rv:1.8.0.12) Gecko/20070530 Fedora/1.5.0.12-1.fc6 Firefox/1.5.0.12'),
('2707ef399b39eee', 1, 1213704690, 1213709223, 1213712823, 'expired', 'web', '10.222.22.143', 'Mozilla/5.0 (X11; U; Linux i686; ru; rv:1.8.0.12) Gecko/20070530 Fedora/1.5.0.12-1.fc6 Firefox/1.5.0.12'),
('32ff0f392889602', 1, 1213714197, 1213714272, 1213717872, 'active', 'web', '10.222.22.143', 'Mozilla/5.0 (X11; U; Linux i686; ru; rv:1.8.0.12) Gecko/20070530 Fedora/1.5.0.12-1.fc6 Firefox/1.5.0.12'),
('1729fbc4fdae1a8', 0, 1214033730, 0, 1214037330, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.14) Gecko/20080404 Firefox/2.0.0.14'),
('2dfadf35ff629d2', 0, 1214200838, 1214200843, 1214204443, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.14) Gecko/20080404 Firefox/2.0.0.14'),
('e0568cba5741c5a', 1, 1214230283, 1214230386, 1214233986, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.14) Gecko/20080404 Firefox/2.0.0.14'),
('9ac84e2ac7bdb85', 1, 1215427565, 1215427570, 1215431170, 'active', 'web', '10.222.22.143', 'Mozilla/5.0 (X11; U; Linux i686; ru; rv:1.8.0.12) Gecko/20070530 Fedora/1.5.0.12-1.fc6 Firefox/1.5.0.12'),
('433f6075f0712c3', 1, 1215427570, 0, 1215431170, 'active', 'web', '10.222.22.143', 'Mozilla/5.0 (X11; U; Linux i686; ru; rv:1.8.0.12) Gecko/20070530 Fedora/1.5.0.12-1.fc6 Firefox/1.5.0.12'),
('6d52e345bd4f395', 1, 1215440519, 1215442264, 1215445864, 'active', 'web', '10.222.22.143', 'Mozilla/5.0 (X11; U; Linux i686; ru; rv:1.8.0.12) Gecko/20070530 Fedora/1.5.0.12-1.fc6 Firefox/1.5.0.12'),
('2b660a1937976ac', 1, 1215440522, 0, 1215444122, 'active', 'web', '10.222.22.143', 'Mozilla/5.0 (X11; U; Linux i686; ru; rv:1.8.0.12) Gecko/20070530 Fedora/1.5.0.12-1.fc6 Firefox/1.5.0.12'),
('bbd0a7f90f95e62', 1, 1215440553, 0, 1215444153, 'active', 'web', '10.222.22.143', 'Mozilla/5.0 (X11; U; Linux i686; ru; rv:1.8.0.12) Gecko/20070530 Fedora/1.5.0.12-1.fc6 Firefox/1.5.0.12'),
('b2450672f9bea29', 1, 1215440703, 0, 1215444303, 'active', 'web', '10.222.22.143', 'Mozilla/5.0 (X11; U; Linux i686; ru; rv:1.8.0.12) Gecko/20070530 Fedora/1.5.0.12-1.fc6 Firefox/1.5.0.12'),
('cb0fc416091989a', 1, 1215440708, 0, 1215444308, 'active', 'web', '10.222.22.143', 'Mozilla/5.0 (X11; U; Linux i686; ru; rv:1.8.0.12) Gecko/20070530 Fedora/1.5.0.12-1.fc6 Firefox/1.5.0.12'),
('9e00fa1ee11e570', 1, 1215440845, 0, 1215444445, 'active', 'web', '10.222.22.143', 'Mozilla/5.0 (X11; U; Linux i686; ru; rv:1.8.0.12) Gecko/20070530 Fedora/1.5.0.12-1.fc6 Firefox/1.5.0.12'),
('0ddbb528b091fad', 1, 1215440850, 0, 1215444450, 'active', 'web', '10.222.22.143', 'Mozilla/5.0 (X11; U; Linux i686; ru; rv:1.8.0.12) Gecko/20070530 Fedora/1.5.0.12-1.fc6 Firefox/1.5.0.12'),
('1e5f01579f7bc66', 1, 1215440859, 0, 1215444459, 'active', 'web', '10.222.22.143', 'Mozilla/5.0 (X11; U; Linux i686; ru; rv:1.8.0.12) Gecko/20070530 Fedora/1.5.0.12-1.fc6 Firefox/1.5.0.12'),
('3b47f03d4a62721', 1, 1215440890, 0, 1215444490, 'active', 'web', '10.222.22.143', 'Mozilla/5.0 (X11; U; Linux i686; ru; rv:1.8.0.12) Gecko/20070530 Fedora/1.5.0.12-1.fc6 Firefox/1.5.0.12'),
('aaf2a72d5d93ddb', 1, 1215441428, 0, 1215445028, 'active', 'web', '10.222.22.143', 'Mozilla/5.0 (X11; U; Linux i686; ru; rv:1.8.0.12) Gecko/20070530 Fedora/1.5.0.12-1.fc6 Firefox/1.5.0.12'),
('08dca96e160d0c9', 1, 1215441433, 0, 1215445033, 'active', 'web', '10.222.22.143', 'Mozilla/5.0 (X11; U; Linux i686; ru; rv:1.8.0.12) Gecko/20070530 Fedora/1.5.0.12-1.fc6 Firefox/1.5.0.12'),
('2dca604a9f62730', 1, 1215441953, 0, 1215445553, 'active', 'web', '10.222.22.143', 'Mozilla/5.0 (X11; U; Linux i686; ru; rv:1.8.0.12) Gecko/20070530 Fedora/1.5.0.12-1.fc6 Firefox/1.5.0.12'),
('18b1fbf710c9bcd', 1, 1215441956, 0, 1215445556, 'active', 'web', '10.222.22.143', 'Mozilla/5.0 (X11; U; Linux i686; ru; rv:1.8.0.12) Gecko/20070530 Fedora/1.5.0.12-1.fc6 Firefox/1.5.0.12'),
('038322c2b3e0ab8', 1, 1215441991, 0, 1215445591, 'active', 'web', '10.222.22.143', 'Mozilla/5.0 (X11; U; Linux i686; ru; rv:1.8.0.12) Gecko/20070530 Fedora/1.5.0.12-1.fc6 Firefox/1.5.0.12'),
('9b7c9c04d11f33c', 1, 1215442264, 0, 1215445864, 'active', 'web', '10.222.22.143', 'Mozilla/5.0 (X11; U; Linux i686; ru; rv:1.8.0.12) Gecko/20070530 Fedora/1.5.0.12-1.fc6 Firefox/1.5.0.12'),
('c0700a6198ade9e', 0, 1216893398, 1216893434, 1216897034, 'active', 'web', '10.222.22.143', 'Mozilla/5.0 (X11; U; Linux i686; ru; rv:1.8.0.12) Gecko/20070530 Fedora/1.5.0.12-1.fc6 Firefox/1.5.0.12'),
('46df4d1be0e70c5', 1, 1217332826, 1217332840, 1217336440, 'active', 'web', '10.222.22.143', 'Mozilla/5.0 (X11; U; Linux i686; ru; rv:1.8.0.12) Gecko/20070530 Fedora/1.5.0.12-1.fc6 Firefox/1.5.0.12'),
('fbf4e011cf3caa7', 0, 1276855845, 0, 1276859445, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('47637ead0b189cc', 0, 1276855877, 0, 1276859477, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('a7439766085e0a1', 0, 1276858420, 0, 1276862020, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('24a5246fdda2262', 0, 1276858937, 0, 1276862537, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('42d15884ea858c1', 0, 1276858994, 0, 1276862594, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('bf10f492b7d243d', 0, 1276859010, 0, 1276862610, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('5973d169251bc26', 0, 1276859012, 0, 1276862612, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('9fb766aec2fb18f', 0, 1276859228, 0, 1276862828, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('7653fae33a50558', 0, 1276859235, 0, 1276862835, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('7bdc6f1dd872c58', 0, 1276859242, 0, 1276862842, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('4b063bb7a52ae97', 0, 1276859244, 0, 1276862844, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('0ef36307e579109', 0, 1276859277, 0, 1276862877, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('47fe1e40a62eea6', 0, 1276859279, 0, 1276862879, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('1f5f591ab7ee3d7', 0, 1276859299, 0, 1276862899, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('920c0c734bed9aa', 0, 1276859300, 0, 1276862900, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('c765cec4cfb318d', 0, 1276859325, 0, 1276862925, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('50a00cece3a6a30', 0, 1276859339, 0, 1276862939, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('cdb3671d219beb1', 0, 1276859390, 0, 1276862990, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('cdeb7c5b4220298', 0, 1276859400, 0, 1276863000, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('2f99f02d235095f', 0, 1276859410, 0, 1276863010, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('856c94b15c25944', 0, 1276859476, 0, 1276863076, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('9eafa8ae408d8a4', 0, 1276859490, 0, 1276863090, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('4c9a6c7c5a66ebf', 0, 1276859498, 0, 1276863098, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('41669b3b9da10e8', 0, 1276859511, 0, 1276863111, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('a6631fffa9cc863', 0, 1276859767, 0, 1276863367, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('47f48e79c64dbc4', 0, 1276859771, 0, 1276863371, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('432e7630fce6ef8', 0, 1276859833, 0, 1276863433, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('6c4ecd923cf37df', 0, 1276859849, 0, 1276863449, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('293a1cc519cefab', 0, 1276859862, 0, 1276863462, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('f7be993cb4619a9', 0, 1276859871, 0, 1276863471, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('d2d87bd2769cc09', 0, 1276859903, 0, 1276863503, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('80938d51096bf69', 0, 1276859933, 0, 1276863533, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('ba15d1c7c26ddae', 0, 1276859999, 0, 1276863599, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('20ec479b3055e04', 0, 1276860017, 0, 1276863617, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('032f906a1597640', 0, 1276860044, 0, 1276863644, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('c8501c72d4e56d6', 0, 1276860074, 0, 1276863674, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('527fd3c6d79e016', 0, 1276860095, 0, 1276863695, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('af8ac7ce1be3271', 0, 1276860108, 0, 1276863708, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('011a1332b66d0bd', 0, 1276860145, 0, 1276863745, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('6517548a8acec17', 0, 1276860181, 0, 1276863781, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('692eb61c5096d4a', 0, 1276860210, 0, 1276863810, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('04453a289fb068e', 0, 1276860232, 0, 1276863832, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('53a9de007cda87e', 0, 1276860261, 0, 1276863861, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('e02cb6039555fee', 0, 1276860336, 0, 1276863936, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('c12a1cb1611cbfd', 0, 1276860349, 0, 1276863949, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('99be4aac0001c85', 0, 1276860363, 0, 1276863963, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('3071c1a9bb1087e', 0, 1276860370, 0, 1276863970, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('745cf1977edeff3', 0, 1276860371, 0, 1276863971, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('5028457ee1a0d3d', 0, 1276860392, 0, 1276863992, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('fae96f9e775012e', 0, 1276860409, 0, 1276864009, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('f1f5c58ab41c1eb', 0, 1276860501, 0, 1276864101, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('05234a4bc40db12', 0, 1276860531, 0, 1276864131, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('013e634378aacb2', 0, 1276860555, 0, 1276864155, 'active', 'web', '127.0.0.1', 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 5.1; Trident/4.0; .NET CLR 2.0.50727)'),
('5b61662d8449de5', 0, 1276953425, 0, 1276957025, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('ded51a19ee34729', 0, 1276953573, 0, 1276957173, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('3e203d9f87eeca5', 0, 1276953640, 0, 1276957240, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('4de6f69f9570177', 0, 1276953668, 0, 1276957268, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('1a440eff3c72868', 0, 1276953672, 0, 1276957272, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('5c71c74f397d7d6', 0, 1276953745, 0, 1276957345, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('081b16ebadbf5fb', 0, 1276953885, 0, 1276957485, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('e6352c59df76338', 0, 1276953928, 0, 1276957528, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('e73a2310182e478', 0, 1276953985, 0, 1276957585, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('75d9d3a751d5d13', 0, 1276954044, 0, 1276957644, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('27f161a98b0444c', 0, 1276954103, 0, 1276957703, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('d0013d9f3ee8bf0', 0, 1276954115, 0, 1276957715, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('74581149cf42004', 0, 1276954127, 0, 1276957727, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('e4f58f1850ddb16', 0, 1276954168, 0, 1276957768, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('5305a562a84b8b3', 0, 1276954177, 0, 1276957777, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('33745a24e1dfa95', 0, 1276954202, 0, 1276957802, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('bc71c5e33169145', 0, 1276954216, 0, 1276957816, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('630294f3cc5f918', 0, 1276954226, 0, 1276957826, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('102369871a87d42', 0, 1276954234, 0, 1276957834, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('723a90e8d03e832', 0, 1276954247, 0, 1276957847, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('7f17e7631143370', 0, 1276954288, 0, 1276957888, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('0e47dc3448d2073', 0, 1276954306, 0, 1276957906, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('81fbf732cbf53bf', 0, 1276954313, 0, 1276957913, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('a5fb2e0c474b36e', 0, 1276954329, 0, 1276957929, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('0188032359617f9', 0, 1276954369, 0, 1276957969, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('ea7f202964858d0', 0, 1276954378, 0, 1276957978, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('d29a73f26e14503', 0, 1276954383, 0, 1276957983, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('1e2f4690e36f1b6', 0, 1276954461, 0, 1276958061, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('fb729ff1d83ce1d', 0, 1276954492, 0, 1276958092, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('893f6888c7086b3', 0, 1276954503, 0, 1276958103, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('9b2427eb1fbfa5b', 0, 1276954523, 0, 1276958123, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('202e4587aeb8a70', 0, 1276954635, 0, 1276958235, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('7f8d5b8757a6245', 0, 1276954637, 0, 1276958237, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('988d4217c747721', 0, 1276954749, 0, 1276958349, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('b0c94d5750ab26c', 0, 1276954785, 0, 1276958385, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('33066705a7f8def', 0, 1276954941, 0, 1276958541, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('8720d58d4be926a', 0, 1276954990, 0, 1276958590, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('19678c01de26f37', 0, 1276955018, 0, 1276958618, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('bd95c27cb62a67f', 0, 1276955070, 0, 1276958670, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('78dde282f8de3bf', 0, 1276955089, 0, 1276958689, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('7d2b7489a0e46df', 0, 1276955101, 0, 1276958701, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('08ef6a29d9b9143', 0, 1276955225, 0, 1276958825, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('383a0a89c6d0035', 0, 1276955287, 0, 1276958887, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('4f16c6b2617b922', 0, 1276955329, 0, 1276958929, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('d6ad3c98c4447a3', 0, 1276955374, 0, 1276958974, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('a3583facd22558c', 0, 1276955399, 0, 1276958999, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('d8f294f322434e8', 0, 1276955408, 0, 1276959008, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('32481b583b160e9', 0, 1276955419, 0, 1276959019, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('abfe99bf87526eb', 0, 1276955430, 0, 1276959030, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('78b165308b3c9fd', 0, 1276955521, 0, 1276959121, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('fe9e555ac2745d2', 0, 1276955528, 0, 1276959128, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('8b44b1b5e81fd9d', 0, 1276955549, 0, 1276959149, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('fa50f7bb00a4576', 0, 1276955561, 0, 1276959161, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('0ee337cd4662ada', 0, 1276955577, 0, 1276959177, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('8d5e34a3b5c6859', 0, 1276955584, 0, 1276959184, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('42aea7b47b686d2', 0, 1276955602, 0, 1276959202, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('78a5cb69dc08b37', 0, 1276955609, 0, 1276959209, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('c26d0016593800e', 0, 1276955642, 0, 1276959242, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('e9a2cb59993c072', 0, 1276955909, 0, 1276959509, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('ad609709631e6ff', 0, 1276956673, 0, 1276960273, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('5de0e3f836842cd', 0, 1276956691, 0, 1276960291, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('9e4c39f65c21b4c', 0, 1276957292, 0, 1276960892, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('7e9872b5c8e3070', 0, 1276959183, 0, 1276962783, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('348e0ef343d7f93', 0, 1276965809, 0, 1276969409, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('f20ac8213ada37b', 0, 1276965862, 0, 1276969462, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('2494bd6b8464957', 0, 1276965876, 0, 1276969476, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('7fe6e6ce39f8937', 0, 1276968056, 0, 1276971656, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('7c3d2a5ad562ebd', 0, 1276968082, 0, 1276971682, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('0919a7d8ab3f67a', 0, 1276968116, 0, 1276971716, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('e91ec0bd0ae12b7', 0, 1276968134, 0, 1276971734, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('31b69e2a98b3925', 0, 1276968162, 0, 1276971762, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('9e9fa4771fd95ee', 0, 1276968185, 0, 1276971785, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('fd984a0eb301cfd', 0, 1276968284, 0, 1276971884, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('d1e8f19616f28b0', 0, 1276968304, 0, 1276971904, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('972b1873a33c030', 0, 1276968322, 0, 1276971922, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('b28fca88fe27bbe', 0, 1276968379, 0, 1276971979, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('86a4e7cfa89857d', 0, 1276968391, 0, 1276971991, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('b73b5db391e13ac', 0, 1276968474, 0, 1276972074, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('fc93d65b4fd9e91', 0, 1276968487, 0, 1276972087, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('85c58066bf65607', 0, 1276968512, 0, 1276972112, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('25c356d9a62c77f', 0, 1276968520, 0, 1276972120, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('bcb3177ecf120ad', 0, 1276968547, 0, 1276972147, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('34302bde4e3daac', 0, 1276968608, 0, 1276972208, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('b7a0776e8eb56ab', 0, 1276968674, 0, 1276972274, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('de8f766652f8ed3', 0, 1276968681, 0, 1276972281, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('402c2e115706d06', 0, 1276968818, 0, 1276972418, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('3d7d2cc4594c867', 0, 1276968831, 0, 1276972431, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('b09f4167c702e02', 0, 1276968852, 0, 1276972452, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('279be32f9bf3202', 0, 1276968860, 0, 1276972460, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('d97dae25a13d06b', 0, 1276968900, 0, 1276972500, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('9ed1a8eec415302', 0, 1276968921, 0, 1276972521, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('1002c6354101c64', 0, 1276968935, 0, 1276972535, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('7657ac4660cc7d3', 0, 1276968941, 0, 1276972541, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('f3a2ee90f2b95a9', 0, 1276969018, 0, 1276972618, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('73905927e2cdce1', 0, 1276969046, 0, 1276972646, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('b4f996da2f64858', 0, 1276969130, 0, 1276972730, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('6c3b1a78355a7fd', 0, 1276969140, 0, 1276972740, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('d98f9cf0e35130c', 0, 1276969226, 0, 1276972826, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('972fd6929e41d97', 0, 1276969422, 0, 1276973022, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('2ff0bc89778fd55', 0, 1276969443, 0, 1276973043, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('16fe8d3f9750421', 0, 1276969462, 0, 1276973062, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('a50b14df802cfb6', 0, 1276969478, 0, 1276973078, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('24fcb36d013cc18', 0, 1276969494, 0, 1276973094, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('123070682ca3ae9', 0, 1276969507, 0, 1276973107, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('09b849f9af439a4', 0, 1276969535, 0, 1276973135, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('c46d195a16fe971', 0, 1276969587, 0, 1276973187, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('16512ed8811be78', 0, 1276969633, 0, 1276973233, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('84515d552c4abec', 0, 1276969953, 0, 1276973553, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('5b4d14f3fba987d', 0, 1276970330, 0, 1276973930, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('f6e128709a006f5', 0, 1276970817, 0, 1276974417, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('fa04aba3a25af86', 0, 1276970835, 0, 1276974435, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('360cb5ec471b1ae', 0, 1276970967, 0, 1276974567, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('9872a9146b603fa', 0, 1276971017, 0, 1276974617, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('5f9f26a9f468af5', 0, 1276971112, 0, 1276974712, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('f71799c8f1e8ea9', 0, 1276971155, 0, 1276974755, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('06f169ad30ac3fd', 0, 1276971177, 0, 1276974777, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('ab28118c28c2ca6', 0, 1276971190, 0, 1276974790, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('8ba32eff77e62de', 0, 1276971197, 0, 1276974797, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('f963e8acd5e4391', 0, 1276971264, 0, 1276974864, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('b63995494403ae1', 0, 1276971286, 0, 1276974886, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('da5914ddf08e36b', 0, 1276971309, 0, 1276974909, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('a475722f606e187', 0, 1276971361, 0, 1276974961, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('287b7963648464f', 0, 1276971366, 0, 1276974966, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('fabdca27b2edc3d', 0, 1276971475, 0, 1276975075, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('6595ee95d7dd923', 0, 1276971662, 0, 1276975262, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('489fcaf00b4a66f', 0, 1276971676, 0, 1276975276, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('9f8c4aa3b488bd1', 0, 1276971689, 0, 1276975289, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('9f55d0f2b8afc6f', 0, 1276971736, 0, 1276975336, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('828cbdd617d5656', 0, 1276971764, 0, 1276975364, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('2a0b55f447e43ab', 0, 1276971778, 0, 1276975378, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('a1882268fc44703', 0, 1276971870, 0, 1276975470, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('587e4e6d7db7c29', 0, 1276971885, 0, 1276975485, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('0688190b66173ff', 0, 1276971945, 0, 1276975545, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('8c028cb698a55bf', 0, 1276971956, 0, 1276975556, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('23c04afabb4f1fd', 0, 1276971972, 0, 1276975572, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('b480c60bc5f56f1', 0, 1276971983, 0, 1276975583, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('a9f0b418fe2dab7', 0, 1276971995, 0, 1276975595, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('f01fd3e2da7c4b0', 0, 1276972045, 0, 1276975645, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('99564e9eb7df57f', 0, 1276972088, 0, 1276975688, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('dedac5ebfdac2c5', 0, 1276972102, 0, 1276975702, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('e65874ba1f76d8a', 0, 1276972110, 0, 1276975710, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('f18793aeacdc1df', 0, 1276972684, 0, 1276976284, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('58dec601772faaf', 0, 1276972870, 0, 1276976470, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('84dec7ec7543841', 0, 1276972893, 0, 1276976493, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('7529ee26343d771', 0, 1276972910, 0, 1276976510, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('f546f964550fe95', 0, 1276973064, 0, 1276976664, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('bbd9cfdc3a6865e', 0, 1276973080, 0, 1276976680, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('4f5f0b6696c00e5', 0, 1276973172, 0, 1276976772, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('7bdb24b16034583', 0, 1276973230, 0, 1276976830, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('335891b28af3d4d', 0, 1276973251, 0, 1276976851, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('c9b472d89243c09', 0, 1276973282, 0, 1276976882, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('a7cdd33c8ccd4a2', 0, 1276973293, 0, 1276976893, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('e0e0a1e63d37b5d', 0, 1276973307, 0, 1276976907, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('c9a42efe75c55dc', 0, 1276973355, 0, 1276976955, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('83cbe06c6352d79', 0, 1276973399, 0, 1276976999, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('71dd7df4193cce5', 0, 1276973430, 0, 1276977030, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('2f1bec7984bf827', 0, 1276973442, 0, 1276977042, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('d884dfad764bc3d', 0, 1276973477, 0, 1276977077, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('f65c962cd5d911a', 0, 1276973513, 0, 1276977113, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('2e6ce3a1430d675', 0, 1276973519, 0, 1276977119, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('388cfe9a6c9924c', 0, 1276973538, 0, 1276977138, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('3f565045bc316f1', 0, 1276973631, 0, 1276977231, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('3b49719a750e8c4', 0, 1276973716, 0, 1276977316, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('bbbcf8e7ac5c1c3', 0, 1276973731, 0, 1276977331, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('1c3acb371a8f0b7', 0, 1276973748, 0, 1276977348, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('f795267da6bd7ad', 0, 1276973754, 0, 1276977354, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('668fe276889049d', 0, 1276973766, 0, 1276977366, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('d65f063991c37aa', 0, 1276973772, 0, 1276977372, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('c0a426a641e8dc6', 0, 1276973781, 0, 1276977381, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('2bbded6fe67f125', 0, 1276973825, 0, 1276977425, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('fac3ccb57c708e9', 0, 1276973877, 0, 1276977477, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('fc75bd73b52400e', 0, 1276973906, 0, 1276977506, 'active', 'web', '127.0.0.1', 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 5.1; Trident/4.0; .NET CLR 2.0.50727)'),
('020d2866370b433', 0, 1276973989, 0, 1276977589, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('f1464b092bd0dcc', 0, 1276974012, 0, 1276977612, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('824cc3fe33d9bed', 0, 1276974030, 0, 1276977630, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('eec863bbdfcaf3c', 0, 1276974052, 0, 1276977652, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('fbdee38509d6e94', 0, 1276974060, 0, 1276977660, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('0d64c09287be115', 0, 1276974074, 0, 1276977674, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('4b17a746015ffd7', 0, 1276974096, 0, 1276977696, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('d55433876100092', 0, 1276974104, 0, 1276977704, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('0c1320d14d02087', 0, 1276974117, 0, 1276977717, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('26ab8ef0de92b59', 0, 1276974279, 0, 1276977879, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('95be60f846e7a4e', 0, 1276974290, 0, 1276977890, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('fd5b68e8b0c169d', 0, 1276974635, 0, 1276978235, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('e152abcf6aefdf3', 0, 1277030395, 0, 1277033995, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('c15a0ebbe6a59f3', 0, 1277030656, 0, 1277034256, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('70f4b1d39c1dec6', 0, 1277030667, 0, 1277034267, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('7a37842f25cd4cb', 0, 1277030685, 0, 1277034285, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3');
INSERT INTO `sessions` (`sess_id`, `user_id`, `createdTime`, `updatedTime`, `expireTime`, `state`, `type`, `remote_addr`, `user_agent`) VALUES
('eb33b557f392e02', 0, 1277030716, 0, 1277034316, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('34cbf0f7af0160f', 0, 1277030727, 0, 1277034327, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('0d993339c09afbc', 0, 1277030754, 0, 1277034354, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('81a0d4a59c07ec7', 0, 1277030779, 0, 1277034379, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('4aa78618afe9be1', 0, 1277030797, 0, 1277034397, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('3d85744a57eb1a6', 0, 1277030810, 0, 1277034410, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('612b093933935c5', 0, 1277030854, 0, 1277034454, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('534b7ef2159ca3c', 0, 1277030863, 0, 1277034463, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('e5290f475c5222f', 0, 1277030943, 0, 1277034543, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('6434551808efddc', 0, 1277030953, 0, 1277034553, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('0bae0863c37d03b', 0, 1277031027, 0, 1277034627, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('3cd037b28cb0ddc', 0, 1277031042, 0, 1277034642, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('c23f69097c2d3a3', 0, 1277031058, 0, 1277034658, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('6d957084b78e8bd', 0, 1277031092, 0, 1277034692, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('7922018eba926f1', 0, 1277031121, 0, 1277034721, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('4f99bc86764deb6', 0, 1277031164, 0, 1277034764, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('8eab2a8de553df3', 0, 1277031236, 0, 1277034836, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('3684d548df0e66e', 0, 1277031275, 0, 1277034875, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('4c0612d14417ca3', 0, 1277031311, 0, 1277034911, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('16e184bdda018d9', 0, 1277031325, 0, 1277034925, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('d0fc6e795f1e334', 0, 1277031339, 0, 1277034939, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('9004cb04e75ab25', 0, 1277031349, 0, 1277034949, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('b6b81bbf990c0a9', 0, 1277031449, 0, 1277035049, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('b65e85a8c2f968e', 0, 1277031459, 0, 1277035059, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('39b464735410145', 0, 1277031478, 0, 1277035078, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('23e629f8841faff', 0, 1277031490, 0, 1277035090, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('16689995578f787', 0, 1277031499, 0, 1277035099, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('b62d0bdb5b7e1be', 0, 1277031561, 0, 1277035161, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('52804b90b2d0e14', 0, 1277031598, 0, 1277035198, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('06e24fcc5d7973e', 0, 1277031651, 0, 1277035251, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('35366b0bfbd8110', 0, 1277031881, 0, 1277035481, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('b66db0517cf05b1', 0, 1277031893, 0, 1277035493, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('0a5bec7802ee63e', 0, 1277031905, 0, 1277035505, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('54ce3332d19b546', 0, 1277031930, 0, 1277035530, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('eb233ce9ad7899f', 0, 1277031968, 0, 1277035568, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('3b6f2826617addc', 0, 1277031986, 0, 1277035586, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('994a94fc365ac58', 0, 1277032076, 0, 1277035676, 'active', 'web', '127.0.0.1', 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 5.1; Trident/4.0; .NET CLR 2.0.50727)'),
('e82d5f54d89d214', 0, 1277032249, 0, 1277035849, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('4683246bf536ae4', 0, 1277032287, 0, 1277035887, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('1a2bb1aaa6b03ef', 0, 1277032295, 0, 1277035895, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('34e2a1b494d16ff', 0, 1277032317, 0, 1277035917, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('1e55e5a43b5d1e0', 0, 1277032329, 0, 1277035929, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('e04ab6fa9b1419d', 0, 1277032336, 0, 1277035936, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('3b5bfbd320ca91e', 0, 1277032344, 0, 1277035944, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('857cea3d39a345c', 0, 1277032355, 0, 1277035955, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('b75c9ce9897990b', 0, 1277032382, 0, 1277035982, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('a0a298c9a977b79', 0, 1277032405, 0, 1277036005, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('feb43a5765b6345', 0, 1277032436, 0, 1277036036, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('8b2849de0aff025', 0, 1277032447, 0, 1277036047, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('640574e459c7299', 0, 1277032468, 0, 1277036068, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('9a6f62b9217cc31', 0, 1277032476, 0, 1277036076, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('402e581d1a8a050', 0, 1277032501, 0, 1277036101, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('09548308c395357', 0, 1277032514, 0, 1277036114, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('25025a76383c709', 0, 1277032552, 0, 1277036152, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('635312195856edf', 0, 1277032571, 0, 1277036171, 'active', 'web', '127.0.0.1', 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 5.1; Trident/4.0; .NET CLR 2.0.50727)'),
('0dc613315974fe4', 0, 1277032588, 0, 1277036188, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('2c4306d47f249ee', 0, 1277032606, 0, 1277036206, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('dc178be9e065ad6', 0, 1277032629, 0, 1277036229, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('950d491a77d5b95', 0, 1277032658, 0, 1277036258, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('dbe5c30ab586873', 0, 1277032665, 0, 1277036265, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('dda47c768f1a0e3', 0, 1277032896, 0, 1277036496, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('b3bb6070d2b315e', 0, 1277032914, 0, 1277036514, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('7355c9b4c78072a', 0, 1277032932, 0, 1277036532, 'active', 'web', '127.0.0.1', 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 5.1; Trident/4.0; .NET CLR 2.0.50727)'),
('d7fb2ab86d7d738', 0, 1277033175, 0, 1277036775, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('d277aeb7a42d083', 0, 1277033188, 0, 1277036788, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('33e94df1c25030c', 0, 1277033205, 0, 1277036805, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('cbcdcea349716d0', 0, 1277033216, 0, 1277036816, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('ad5a2a350069cab', 0, 1277033230, 0, 1277036830, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('7c1c9bc00f310d1', 0, 1277033472, 0, 1277037072, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('5c43c362e567ce4', 0, 1277033701, 0, 1277037301, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('2b9aab857ea7dc5', 0, 1277033777, 0, 1277037377, 'active', 'web', '127.0.0.1', 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 5.1; Trident/4.0; .NET CLR 2.0.50727)'),
('684a2e4dbb7397f', 0, 1277033800, 0, 1277037400, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('727fec38f945880', 0, 1277033808, 0, 1277037408, 'active', 'web', '127.0.0.1', 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 5.1; Trident/4.0; .NET CLR 2.0.50727)'),
('876b67747e60d2d', 0, 1277035709, 0, 1277039309, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('19bdd4b4f880f4c', 0, 1277036347, 0, 1277039947, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('e5a8d32de6ad71f', 0, 1277036359, 0, 1277039959, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('2b7d979569f287d', 0, 1277036403, 0, 1277040003, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('71b5df4ec4582ed', 0, 1277036412, 0, 1277040012, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('421e4184ea2b882', 0, 1277036424, 0, 1277040024, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('63f75d769f1f871', 0, 1277036436, 0, 1277040036, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('7fa9e21167ede21', 0, 1277036445, 0, 1277040045, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('4ba903b734c4250', 0, 1277036697, 0, 1277040297, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('aa28e7b0ea22d49', 0, 1277036728, 0, 1277040328, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('d5cb533cc499a45', 0, 1277036758, 0, 1277040358, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('fc24b949d187d84', 0, 1277036786, 0, 1277040386, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('4824a7df7f0891b', 0, 1277036790, 0, 1277040390, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('7e2338ae1eab0e2', 0, 1277036823, 0, 1277040423, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('f98f859cca76c74', 0, 1277036838, 0, 1277040438, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('b4363de1e6436d4', 0, 1277036846, 0, 1277040446, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('bcca2621c4abba7', 0, 1277036869, 0, 1277040469, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('82204199de721e2', 0, 1277036895, 0, 1277040495, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('ca3a658d1c8fb82', 0, 1277036902, 0, 1277040502, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('6b37d79bef17137', 0, 1277036912, 0, 1277040512, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('c58517e94f7c8b6', 0, 1277036946, 0, 1277040546, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('4681727ef253f19', 0, 1277036983, 0, 1277040583, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('8934a142bfa7818', 0, 1277037004, 0, 1277040604, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('9d8286adc569b26', 0, 1277037016, 0, 1277040616, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('2296a20d0a65554', 0, 1277037059, 0, 1277040659, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('7d06b08be0e1724', 0, 1277037088, 0, 1277040688, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('ebb95cd053716c2', 0, 1277037106, 0, 1277040706, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('79a161b4e6f28d3', 0, 1277037124, 0, 1277040724, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('a76bfc28933b393', 0, 1277037136, 0, 1277040736, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('9282e4c4feafb2f', 0, 1277037157, 0, 1277040757, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('dd761be10273a9d', 0, 1277037167, 0, 1277040767, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('e143caa00a5b5ff', 0, 1277037245, 0, 1277040845, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('4a007020fc24508', 0, 1277037379, 0, 1277040979, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('7362172ea7d67fd', 0, 1277037389, 0, 1277040989, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('d877822c8796532', 0, 1277037398, 0, 1277040998, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('cdc9fa2f090e4e7', 0, 1277037405, 0, 1277041005, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('caac5e6064e73d2', 0, 1277037444, 0, 1277041044, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('b6d1b64761431d3', 0, 1277037452, 0, 1277041052, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('d53f89a7e2938ae', 0, 1277037459, 0, 1277041059, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('06cc4eafa358c4c', 0, 1277037577, 0, 1277041177, 'active', 'web', '127.0.0.1', 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 5.1; Trident/4.0; .NET CLR 2.0.50727)'),
('2621df9bdddf7a3', 0, 1277037586, 0, 1277041186, 'active', 'web', '127.0.0.1', 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 5.1; Trident/4.0; .NET CLR 2.0.50727)'),
('93dcb0d2dbb61e4', 0, 1277037589, 0, 1277041189, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('77c4e3c8d07a45f', 0, 1277037607, 0, 1277041207, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('865bac65265aae4', 0, 1277037611, 0, 1277041211, 'active', 'web', '127.0.0.1', 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 5.1; Trident/4.0; .NET CLR 2.0.50727)'),
('73dcfff78408b10', 0, 1277037618, 0, 1277041218, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('58eaa07d7edec00', 0, 1277037621, 0, 1277041221, 'active', 'web', '127.0.0.1', 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 5.1; Trident/4.0; .NET CLR 2.0.50727)'),
('3b7fceda7cc6656', 0, 1277037647, 0, 1277041247, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('879fc7d8e0733b0', 0, 1277037650, 0, 1277041250, 'active', 'web', '127.0.0.1', 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 5.1; Trident/4.0; .NET CLR 2.0.50727)'),
('8c220fd4f14e5e8', 0, 1277037707, 0, 1277041307, 'active', 'web', '127.0.0.1', 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 5.1; Trident/4.0; .NET CLR 2.0.50727)'),
('afdfb125ae03072', 0, 1277037719, 0, 1277041319, 'active', 'web', '127.0.0.1', 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 5.1; Trident/4.0; .NET CLR 2.0.50727)'),
('db5dd7d05b4c231', 0, 1277037733, 0, 1277041333, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('2d62a01956fd3f4', 0, 1277037753, 0, 1277041353, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('503534aa5684c92', 0, 1277037766, 0, 1277041366, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('b8e3aebfef3ccc7', 0, 1277037775, 0, 1277041375, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('6b214f1becd60da', 0, 1277037788, 0, 1277041388, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('05aceccec807b60', 0, 1277037794, 0, 1277041394, 'active', 'web', '127.0.0.1', 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 5.1; Trident/4.0; .NET CLR 2.0.50727)'),
('08bd9e518d0c642', 0, 1277038198, 0, 1277041798, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('b83f588803c487d', 0, 1277038328, 0, 1277041928, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('86eb4cf591b7f22', 0, 1277038351, 0, 1277041951, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('c3358acb320e4b7', 0, 1277038361, 0, 1277041961, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('2463cb84bee915f', 0, 1277038387, 0, 1277041987, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('ec72338252c8c96', 0, 1277038421, 0, 1277042021, 'active', 'web', '127.0.0.1', 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 5.1; Trident/4.0; .NET CLR 2.0.50727)'),
('89323a0672d19cb', 0, 1277038481, 0, 1277042081, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('8fb9bb983b9b6d1', 0, 1277038485, 0, 1277042085, 'active', 'web', '127.0.0.1', 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 5.1; Trident/4.0; .NET CLR 2.0.50727)'),
('d322ce7a724f589', 0, 1277038495, 0, 1277042095, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('f9e97ea7c25d044', 0, 1277038508, 0, 1277042108, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('7ccb37942585821', 0, 1277038533, 0, 1277042133, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('2759bebbd1fd00d', 0, 1277038538, 0, 1277042138, 'active', 'web', '127.0.0.1', 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 5.1; Trident/4.0; .NET CLR 2.0.50727)'),
('2ba375de7a5076e', 0, 1277038656, 0, 1277042256, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('5dcd8ebec19ef60', 0, 1277038684, 0, 1277042284, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('ae3535beeccb584', 0, 1277038694, 0, 1277042294, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('75afac4cbc7f0cd', 0, 1277038877, 0, 1277042477, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('33c0e845b656136', 0, 1277038942, 0, 1277042542, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('5ce0b60b9e8f4f7', 0, 1277038948, 0, 1277042548, 'active', 'web', '127.0.0.1', 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 5.1; Trident/4.0; .NET CLR 2.0.50727)'),
('ee44364b5b8a932', 0, 1277038976, 0, 1277042576, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('26e3c130e586723', 0, 1277038985, 0, 1277042585, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('a4d7d40f977cadd', 0, 1277039030, 0, 1277042630, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('bdb91009a4f6681', 0, 1277039036, 0, 1277042636, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('053fcc34aba9925', 0, 1277039044, 0, 1277042644, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('9dc943e64be2bdc', 0, 1277039057, 0, 1277042657, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('66796b45d9ab8cd', 0, 1277039064, 0, 1277042664, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('3eca6caf87eeb7b', 0, 1277039079, 0, 1277042679, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('24b3503afb4765a', 0, 1277039095, 0, 1277042695, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('0666c2786a2355d', 0, 1277039126, 0, 1277042726, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('80b9c27df5ab8f8', 0, 1277039134, 0, 1277042734, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('dc5114e110f2840', 0, 1277039148, 0, 1277042748, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('13b5039fdec5a33', 0, 1277039163, 0, 1277042763, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('625eea04c626ce5', 0, 1277039175, 0, 1277042775, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('c0ada8bde12d14c', 0, 1277039194, 0, 1277042794, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('52d6513e8c29979', 0, 1277039202, 0, 1277042802, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('056ac2da75159f1', 0, 1277039208, 0, 1277042808, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('83b2263f30b7523', 0, 1277039216, 0, 1277042816, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('4f20546d074e77b', 0, 1277039232, 0, 1277042832, 'active', 'web', '127.0.0.1', 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 5.1; Trident/4.0; .NET CLR 2.0.50727)'),
('643a400ce737ef6', 0, 1277039477, 0, 1277043077, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('325610365e8208f', 0, 1277039487, 0, 1277043087, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('e360f4fbbdedd70', 0, 1277039574, 0, 1277043174, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('e13bf35efc8b431', 0, 1277039582, 0, 1277043182, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('92b5808b8354c52', 0, 1277039585, 0, 1277043185, 'active', 'web', '127.0.0.1', 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 5.1; Trident/4.0; .NET CLR 2.0.50727)'),
('901d8a2d667e9c5', 0, 1277039631, 0, 1277043231, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('799be8396d43c9d', 0, 1277039644, 0, 1277043244, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('2b63e4e17decf00', 0, 1277039658, 0, 1277043258, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('2bc9ce016db4603', 0, 1277039679, 0, 1277043279, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('a1a1afdd92ce8fd', 0, 1277039725, 0, 1277043325, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('35d1c07b98c8d74', 0, 1277039736, 0, 1277043336, 'active', 'web', '127.0.0.1', 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 5.1; Trident/4.0; .NET CLR 2.0.50727)'),
('e69189149671ce7', 0, 1277054961, 0, 1277058561, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('b456c3732b08d06', 0, 1277054972, 0, 1277058572, 'active', 'web', '127.0.0.1', 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 5.1; Trident/4.0; .NET CLR 2.0.50727)'),
('e4e05bae556319a', 0, 1277054983, 0, 1277058583, 'active', 'web', '127.0.0.1', 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 5.1; Trident/4.0; .NET CLR 2.0.50727)'),
('e2c07ec14a499e2', 0, 1277055005, 0, 1277058605, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('e0c0aeadd1480bd', 0, 1277055010, 0, 1277058610, 'active', 'web', '127.0.0.1', 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 5.1; Trident/4.0; .NET CLR 2.0.50727)'),
('29b3329017b13b1', 0, 1277055022, 0, 1277058622, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('eeb91087c232329', 0, 1277055030, 0, 1277058630, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('635f56fbad94006', 0, 1277055039, 0, 1277058639, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('84a38adbec0282a', 0, 1277055047, 0, 1277058647, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('9d7b1fe448f1195', 0, 1277055052, 0, 1277058652, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('4f9575ac05f21a2', 0, 1277055073, 0, 1277058673, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('835bbbe48765515', 0, 1277055080, 0, 1277058680, 'active', 'web', '127.0.0.1', 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 5.1; Trident/4.0; .NET CLR 2.0.50727)'),
('cb517256c3c5d50', 0, 1277055115, 0, 1277058715, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('12966796cf81fd7', 0, 1277055129, 0, 1277058729, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('452c1b721c5922f', 0, 1277055132, 0, 1277058732, 'active', 'web', '127.0.0.1', 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 5.1; Trident/4.0; .NET CLR 2.0.50727)'),
('cac233c12acc96a', 0, 1277055544, 0, 1277059144, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('34aef0e69851a43', 0, 1277056077, 0, 1277059677, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('9be0d5f78885a4d', 0, 1277056148, 0, 1277059748, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('c3071fa8cba27d4', 0, 1277056156, 0, 1277059756, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('d243339fe3d1b1d', 0, 1277056164, 0, 1277059764, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('c03c92f38b41583', 0, 1277056178, 0, 1277059778, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('ded1c19e64d4897', 0, 1277056196, 0, 1277059796, 'active', 'web', '127.0.0.1', 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 5.1; Trident/4.0; .NET CLR 2.0.50727)'),
('631c859f59ffa25', 0, 1277056214, 0, 1277059814, 'active', 'web', '127.0.0.1', 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 5.1; Trident/4.0; .NET CLR 2.0.50727)'),
('425d2860ae7550c', 0, 1277057801, 0, 1277061401, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('a4bcdc98a95ebd1', 0, 1277098907, 0, 1277102507, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('2c740cc7128d927', 0, 1277098916, 0, 1277102516, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('6652537b7876786', 0, 1277099184, 0, 1277102784, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('bcc29b93d061151', 0, 1277099588, 0, 1277103188, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('9c04d00386fa6b9', 0, 1277099604, 0, 1277103204, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('fd0360190f94619', 0, 1277099896, 0, 1277103496, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('fb4113dd994d29e', 0, 1277099908, 0, 1277103508, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('f5c9c5b9165b426', 0, 1277099914, 0, 1277103514, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('523581b7dad6b7c', 0, 1277100113, 0, 1277103713, 'active', 'web', '127.0.0.1', 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 5.1; Trident/4.0; .NET CLR 2.0.50727)'),
('39bd081a8acad24', 0, 1277100175, 0, 1277103775, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('04f278635a0bc7d', 0, 1277100213, 0, 1277103813, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('35adc06baaa44a7', 0, 1277100245, 0, 1277103845, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('ff65e05d91a43e5', 0, 1277100251, 0, 1277103851, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('726dde4e9ef93d1', 0, 1277100264, 0, 1277103864, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('fe6168f60ad7ec1', 0, 1277100269, 0, 1277103869, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('7117344869b7f94', 0, 1277100276, 0, 1277103876, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('8be902bd40cc414', 0, 1277100413, 0, 1277104013, 'active', 'web', '127.0.0.1', 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 5.1; Trident/4.0; .NET CLR 2.0.50727)'),
('5a8ffd94bf0e9be', 0, 1277101112, 0, 1277104712, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('c28ce20ff489779', 0, 1277101214, 0, 1277104814, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('d84c105b84c0299', 0, 1277101229, 0, 1277104829, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('900eb1fb04514a8', 0, 1277101305, 0, 1277104905, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('34a0951c4e48ae8', 0, 1277101315, 0, 1277104915, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('9e4a99bcae27b28', 0, 1277101349, 0, 1277104949, 'active', 'web', '127.0.0.1', 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 5.1; Trident/4.0; .NET CLR 2.0.50727)'),
('323295111adb5e2', 0, 1277101428, 0, 1277105028, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('8176223927c842b', 0, 1277101786, 0, 1277105386, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('ff01487ec40b3f5', 0, 1277101820, 0, 1277105420, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('9774ba466b192fd', 0, 1277101858, 0, 1277105458, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('7472e2af9344e45', 0, 1277101867, 0, 1277105467, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('88a861ac0bc4949', 0, 1277101883, 0, 1277105483, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('a5ac549e01f1906', 0, 1277101916, 0, 1277105516, 'active', 'web', '127.0.0.1', 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 5.1; Trident/4.0; .NET CLR 2.0.50727)'),
('ecc224a096ebfd9', 0, 1277101949, 0, 1277105549, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('34bd5fff5624529', 0, 1277102134, 0, 1277105734, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('4e8ec0cadded5dc', 0, 1277102156, 0, 1277105756, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('b5517919f587760', 0, 1277102178, 0, 1277105778, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('8fc2fcb1e121a9e', 0, 1277102187, 0, 1277105787, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('7ca62971a671cdf', 0, 1277102203, 0, 1277105803, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('020b65f7056253a', 0, 1277102222, 0, 1277105822, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('5b5596d9c6389c8', 0, 1277102235, 0, 1277105835, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('ce384779bb84a72', 0, 1277102245, 0, 1277105845, 'active', 'web', '127.0.0.1', 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 5.1; Trident/4.0; .NET CLR 2.0.50727)'),
('3fe6e5ed16ee19c', 0, 1277102267, 0, 1277105867, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('dc7b6f9422bec8c', 0, 1277102299, 0, 1277105899, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('ec65e4e03c6a139', 0, 1277102654, 0, 1277106254, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('6fc3653ce238544', 0, 1277102675, 0, 1277106275, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('0b078bd3353a390', 0, 1277102709, 0, 1277106309, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('a5fc3aa1d34b23c', 0, 1277102724, 0, 1277106324, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('7cbba854d6a70a5', 0, 1277102731, 0, 1277106331, 'active', 'web', '127.0.0.1', 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 5.1; Trident/4.0; .NET CLR 2.0.50727)'),
('5c7b4e38e7acf63', 0, 1277103073, 0, 1277106673, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('47a6f6144155971', 0, 1277103082, 0, 1277106682, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('28ea0463af7a201', 0, 1277103094, 0, 1277106694, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('7e9ee5a828a6841', 0, 1277144029, 0, 1277147629, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('4ab565c584a5f66', 0, 1277184659, 0, 1277188259, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('441f213dc118340', 0, 1277185187, 0, 1277188787, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('fb5fb3b46527901', 0, 1277185246, 0, 1277188846, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('0e16c724c06a50e', 0, 1277185270, 0, 1277188870, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('8ac75fe5dc5df36', 0, 1277185291, 0, 1277188891, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('12a1f5bc4adea6f', 0, 1277185357, 0, 1277188957, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('0d273b550236aa1', 0, 1277185364, 0, 1277188964, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('b27ec5052a2255e', 0, 1277185387, 0, 1277188987, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('0a4390fbbd72148', 0, 1277185407, 0, 1277189007, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('c456dd14ae2714a', 0, 1277185420, 0, 1277189020, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('518379a69dc12ec', 0, 1277185495, 0, 1277189095, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('2eca9d31c9117b8', 0, 1277185497, 0, 1277189097, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('ef928e18aec2393', 0, 1277185564, 0, 1277189164, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('f2b35c257fb0507', 0, 1277185599, 0, 1277189199, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('990bcc6ea095e51', 0, 1277185708, 0, 1277189308, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('a005a5740dbee7d', 0, 1277185800, 0, 1277189400, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('fbd19b24e1d52e1', 0, 1277185895, 0, 1277189495, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('4aa89df839d0dc9', 0, 1277185900, 0, 1277189500, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('282c2df7bafdee3', 0, 1277185907, 0, 1277189507, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('45c37358f451a39', 0, 1277185914, 0, 1277189514, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('5df1d664732bd1b', 0, 1277185919, 0, 1277189519, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('db2699640d00ec6', 0, 1277185948, 0, 1277189548, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('84474153a082a8b', 0, 1277186549, 0, 1277190149, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('64f8d2a02aaee20', 0, 1277186557, 0, 1277190157, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('b2f1046bc5facb2', 0, 1277186576, 0, 1277190176, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('cb983c6b3b7c164', 0, 1277186631, 0, 1277190231, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('369cf33c28969ac', 0, 1277186638, 0, 1277190238, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('66b1bda9a23476b', 0, 1277186657, 0, 1277190257, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('61c92ea8b0ed5d9', 0, 1277186675, 0, 1277190275, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('ee8d7d784460bfc', 0, 1277187886, 0, 1277191486, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('bc7661e562d518b', 0, 1277187929, 0, 1277191529, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('391ada63ec4ed44', 0, 1277187980, 0, 1277191580, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('e5c371b2696701f', 0, 1277188339, 0, 1277191939, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('c5958357dce0816', 0, 1277188492, 0, 1277192092, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('44380f0ac10f67f', 0, 1277188554, 0, 1277192154, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('fd0dda4481da9e4', 0, 1277188660, 0, 1277192260, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('028a234e97112f2', 0, 1277188701, 0, 1277192301, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('92eb049f7dd8da3', 0, 1277188934, 0, 1277192534, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('d419aa0931735d6', 0, 1277189003, 0, 1277192603, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('22fbef2f152aced', 0, 1277189029, 0, 1277192629, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('f1233b83ed1366e', 0, 1277189042, 0, 1277192642, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('72df5ea47f57c63', 0, 1277189051, 0, 1277192651, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('4e0937c061e7d2f', 0, 1277226382, 0, 1277229982, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('061f3c88aefea53', 0, 1277270802, 0, 1277274402, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3'),
('9a38a4e2c17d1ae', 0, 1277405939, 0, 1277409539, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.4) Gecko/20100611 Firefox/3.6.4'),
('d7c1af7ac7a924e', 0, 1280064227, 0, 1280067827, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8');
INSERT INTO `sessions` (`sess_id`, `user_id`, `createdTime`, `updatedTime`, `expireTime`, `state`, `type`, `remote_addr`, `user_agent`) VALUES
('349686ac038162c', 0, 1280064579, 0, 1280068179, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('a88bf86bff32756', 0, 1280065296, 0, 1280068896, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('6d670fe0f89e49a', 0, 1280065317, 0, 1280068917, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('9525147664bee06', 0, 1280065344, 0, 1280068944, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('7c6db2a67301fc1', 0, 1280065363, 0, 1280068963, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('0db2e86cc5dd5bd', 0, 1280065377, 0, 1280068977, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('d372a0e70aa0d01', 0, 1280065409, 0, 1280069009, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('376c54626cc6e0d', 0, 1280065446, 0, 1280069046, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('58a1c5ec1bd7763', 0, 1280065457, 0, 1280069057, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('638fccffa5a9d4e', 0, 1280065486, 0, 1280069086, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('0c256b135e31216', 0, 1280065883, 0, 1280069483, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('369d4f0f7287b5a', 0, 1280065905, 0, 1280069505, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('f949a3a6580117e', 0, 1280065919, 0, 1280069519, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('17a5e35b2da37a1', 0, 1280065928, 0, 1280069528, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('689dffa9b43d4fd', 0, 1280066061, 0, 1280069661, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('5330d568d7a28e3', 0, 1280066076, 0, 1280069676, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('f975a463127d243', 0, 1280066104, 0, 1280069704, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('08df071d01b7030', 0, 1280066121, 0, 1280069721, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('cbbc52908b89df2', 0, 1280066137, 0, 1280069737, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('8dca08560f969a8', 0, 1280066161, 0, 1280069761, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('56650f97302ba62', 0, 1280066178, 0, 1280069778, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('dada9e5a5d12117', 0, 1280066186, 0, 1280069786, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('9acc8732e980e54', 0, 1280066209, 0, 1280069809, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('e6cb3213f166779', 0, 1280066220, 0, 1280069820, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('eb72b43bf5632d1', 0, 1280066233, 0, 1280069833, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('76750e88d002cee', 0, 1280066259, 0, 1280069859, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('c0b33382cb2398d', 0, 1280066269, 0, 1280069869, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('5873e3981afd275', 0, 1280066279, 0, 1280069879, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('9abdd06974a3af1', 0, 1280066291, 0, 1280069891, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('d581bb0a1f8ec8f', 0, 1280066306, 0, 1280069906, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('61204e3b74fe9ad', 0, 1280066313, 0, 1280069913, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('9022c33ad0846c0', 0, 1280066321, 0, 1280069921, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('5c6715e629e7d7a', 0, 1280066332, 0, 1280069932, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('8018d072e1e4a09', 0, 1280125981, 0, 1280129581, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('e3e0fa85c8fcd18', 0, 1280126687, 0, 1280130287, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('bc10dc896e07761', 0, 1280126727, 0, 1280130327, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('daaa88b2de90934', 0, 1280126761, 0, 1280130361, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('59bf9dca859b0c1', 0, 1280126814, 0, 1280130414, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('095fafbd2c25769', 0, 1280127543, 0, 1280131143, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('6ee22edd6792c76', 0, 1280127839, 0, 1280131439, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('3fb7e0679d9191c', 0, 1280662518, 0, 1280666118, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('d101ae9aaf3fde1', 0, 1280663606, 1280664221, 1280667821, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('6a54a01d3713c49', 0, 1280664227, 1280668511, 1280672111, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('f22d95b14606f6f', 0, 1280668720, 1280669917, 1280673517, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('cbf8a286676defa', 1, 1280669923, 1280674961, 1280678561, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('b01fb6e52e515c6', 1, 1280674970, 1280675798, 1280679398, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('3ae5996def5af20', 1, 1280675813, 1280675944, 1280679544, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('1fb82694f914bdf', 1, 1280676209, 1280677551, 1280681151, 'expired', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('dcaccc91a98a5cb', 1, 1280727787, 0, 1280731387, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('a6c8e5479d9bf70', 1, 1280766740, 0, 1280770340, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('13daf8e13ad967f', 1, 1282753138, 1282755526, 1282759126, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('c916ce8d905f8c9', 1, 1282756338, 1282756348, 1282759948, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('4fe770d420035b8', 1, 1282799638, 1282806159, 1282809759, 'expired', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('167bccbea81f5c6', 1, 1282842656, 0, 1282846256, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('23a3c4f2bc81c34', 1, 1282842666, 0, 1282846266, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('356bcc546583020', 1, 1282842693, 0, 1282846293, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('d34af1acc84eaa4', 1, 1282842731, 0, 1282846331, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('5c845ce608d9884', 1, 1282842886, 0, 1282846486, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('83ab0b2afae51da', 1, 1282842914, 1282848206, 1282851806, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('d9a235e38754721', 1, 1282883496, 1282887840, 1282891440, 'expired', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('beae3a5c2741f02', 1, 1282892488, 0, 1282896088, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('c174c793d6e9c50', 1, 1282892501, 0, 1282896101, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('0ad0db1e10a0f1c', 1, 1282892728, 0, 1282896328, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('109b0e3b9b74da8', 1, 1282892787, 0, 1282896387, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('c934b7993198ee1', 1, 1282892805, 0, 1282896405, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('cf10979b900be2c', 1, 1282892805, 0, 1282896405, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('fa75105b240a85e', 1, 1282892814, 0, 1282896414, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('c9d6a8af4a19fbc', 1, 1282892814, 0, 1282896414, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('3d55babfa6085da', 1, 1282892819, 0, 1282896419, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('697e7828ba6c076', 1, 1282892824, 0, 1282896424, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('7a1e79bcbb313ae', 1, 1282892826, 0, 1282896426, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('a7e4f26731543c7', 1, 1282927105, 0, 1282930705, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('2e5b443ae691b9d', 1, 1282927524, 0, 1282931124, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('b476c8f8f1d465b', 1, 1282927530, 0, 1282931130, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('1e397e259988ba5', 1, 1282927536, 0, 1282931136, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('a2425a230ce71e5', 1, 1282928335, 0, 1282931935, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('df740ff81d5786c', 1, 1282928520, 0, 1282932120, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('d466a43f7acbcb0', 1, 1282928547, 0, 1282932147, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('8a202ead1278119', 1, 1282929284, 0, 1282932884, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('5b7834f9f58b955', 1, 1282929295, 0, 1282932895, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('9ac4db01f14e475', 1, 1282929864, 0, 1282933464, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('cab4d1099f7c827', 1, 1282929901, 0, 1282933501, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('7fae5acecf20497', 1, 1282929938, 0, 1282933538, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('1e2aedee356ef82', 1, 1282930167, 0, 1282933767, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('ace992e88e6afff', 1, 1282930170, 0, 1282933770, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('3eb696c5b406b26', 1, 1282930172, 0, 1282933772, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('9faf3d4bfd2ac24', 1, 1282930211, 0, 1282933811, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('ad444691e7afc2c', 1, 1282930504, 0, 1282934104, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('b15aac56647962a', 1, 1282930519, 0, 1282934119, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('bce93c16de29394', 1, 1282930528, 0, 1282934128, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('d24bbfc1afaab1a', 1, 1282930558, 0, 1282934158, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('6725964175c1d87', 1, 1282930562, 0, 1282934162, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('3a1c8b08ede79eb', 1, 1282930584, 0, 1282934184, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('481d8ba794fc8d5', 1, 1282930915, 0, 1282934515, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('0de500b7837ab82', 1, 1282931177, 0, 1282934777, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('70484636b8d83c8', 1, 1282931269, 0, 1282934869, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('b4b40c6a1155215', 1, 1282931296, 0, 1282934896, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('53f06b3e4b8d847', 1, 1282931341, 0, 1282934941, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('b09af758adb3000', 1, 1282931382, 0, 1282934982, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('7dfbc47e67ba577', 1, 1282931395, 0, 1282934995, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('858aeee9688e2b1', 1, 1282931415, 0, 1282935015, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('2f683aaae80df07', 1, 1282931589, 0, 1282935189, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('5b05e621fe28bf3', 1, 1282931621, 0, 1282935221, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('b2b253da5403bc7', 1, 1282931636, 0, 1282935236, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('dead965447e4076', 1, 1282931692, 0, 1282935292, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('43b4a4c60b34978', 1, 1282931710, 0, 1282935310, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('59398b5086ed65b', 1, 1282931726, 0, 1282935326, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('cb1d02cb3297cf3', 1, 1282931761, 0, 1282935361, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('d231de320ce0310', 1, 1282931766, 0, 1282935366, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('55d8b973879637d', 1, 1282931809, 0, 1282935409, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('57fcc523d30d3cd', 1, 1282983804, 0, 1282987404, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('94607d423bace2c', 1, 1282983851, 0, 1282987451, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('15759e44198b912', 1, 1282984568, 1282992589, 1282996189, 'expired', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('77dc9c8a327589e', 1, 1283076716, 0, 1283080316, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('e4c9f087fa34a5a', 1, 1283077252, 0, 1283080852, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('5e271857b1921b5', 1, 1283077289, 0, 1283080889, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('d126323938c96cc', 1, 1283077317, 1283077738, 1283081338, 'expired', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('d50252238e8e56e', 1, 1283084476, 1283085131, 1283088731, 'expired', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('cb6d403ee55ea18', 1, 1283090096, 0, 1283093696, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('fc08e34dedc5613', 1, 1283091991, 0, 1283095591, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('c5104cd62944cf6', 1, 1283092002, 1283092020, 1283095620, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('9a9de07120a8ff7', 1, 1283092047, 1283092239, 1283095839, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('efa380412ce7fc6', 1, 1283092255, 0, 1283095855, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('34a259f0ba640da', 1, 1283092451, 1283092561, 1283096161, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('433bd0f8ace8872', 1, 1283092575, 0, 1283096175, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('824e240207ea41b', 1, 1283093787, 0, 1283097387, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('36be1354d46e281', 1, 1283093797, 0, 1283097397, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('8b89b71bc91372d', 1, 1283108874, 1283108893, 1283112493, 'expired', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('eb39c9b10552231', 1, 1283142699, 1283143707, 1283147307, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('53c9d30f5b49d18', 1, 1283147227, 0, 1283150827, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('26bcdffff72db22', 1, 1283147269, 0, 1283150869, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('0a06aa8dd844394', 1, 1283147354, 0, 1283150954, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('eea6816f2cd31c5', 1, 1283147393, 0, 1283150993, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('b97bc55e7cce417', 1, 1283147404, 0, 1283151004, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('7297556aca2b535', 1, 1283147698, 0, 1283151298, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('a22a1fe45dc8449', 1, 1283147803, 0, 1283151403, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('b036aabccf04758', 1, 1283147861, 0, 1283151461, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('5b480988c2fdca7', 1, 1283147887, 0, 1283151487, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('e0e399cfa14fbc4', 1, 1283148192, 0, 1283151792, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('ce3a1fad05f8be8', 1, 1283148397, 0, 1283151997, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('e86cd5a8e2e5076', 1, 1283148424, 0, 1283152024, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('0ee95f30d3c8543', 1, 1283148468, 0, 1283152068, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('c073d7433755950', 1, 1283148535, 0, 1283152135, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('ad0b95c95a730d0', 1, 1283148542, 0, 1283152142, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8'),
('2572d1c2aec909a', 1, 1283148549, 0, 1283152149, 'active', 'web', '127.0.0.1', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8');

-- --------------------------------------------------------

--
-- Структура таблицы `sessions_data`
--

CREATE TABLE IF NOT EXISTS `sessions_data` (
  `sess_id` char(16) NOT NULL default '',
  `s_param` char(100) NOT NULL default '',
  `s_value` char(255) NOT NULL default '',
  UNIQUE KEY `sess_id_2` (`sess_id`,`s_param`)
) TYPE=MyISAM;

--
-- Дамп данных таблицы `sessions_data`
--

INSERT INTO `sessions_data` (`sess_id`, `s_param`, `s_value`) VALUES
('cf025b11809dc54', 'is_logged', '1'),
('d4a0bc1df4755c9', 'is_logged', '1'),
('ac292bc8c5e1150', 'is_logged', '1'),
('7e4a388d7938a10', 'is_logged', '1'),
('bef5d0c6d17670f', 'is_logged', '1'),
('2707ef399b39eee', 'is_logged', '1'),
('32ff0f392889602', 'is_logged', '1'),
('e0568cba5741c5a', 'is_logged', '1'),
('9ac84e2ac7bdb85', 'is_logged', '1'),
('433f6075f0712c3', 'is_logged', '1'),
('6d52e345bd4f395', 'is_logged', '1'),
('2b660a1937976ac', 'is_logged', '1'),
('bbd0a7f90f95e62', 'is_logged', '1'),
('b2450672f9bea29', 'is_logged', '1'),
('cb0fc416091989a', 'is_logged', '1'),
('9e00fa1ee11e570', 'is_logged', '1'),
('0ddbb528b091fad', 'is_logged', '1'),
('1e5f01579f7bc66', 'is_logged', '1'),
('3b47f03d4a62721', 'is_logged', '1'),
('aaf2a72d5d93ddb', 'is_logged', '1'),
('08dca96e160d0c9', 'is_logged', '1'),
('2dca604a9f62730', 'is_logged', '1'),
('18b1fbf710c9bcd', 'is_logged', '1'),
('038322c2b3e0ab8', 'is_logged', '1'),
('9b7c9c04d11f33c', 'is_logged', '1'),
('46df4d1be0e70c5', 'is_logged', '1'),
('cbf8a286676defa', 'is_logged', '1'),
('b01fb6e52e515c6', 'is_logged', '1'),
('3ae5996def5af20', 'is_logged', '1'),
('1fb82694f914bdf', 'is_logged', '1'),
('dcaccc91a98a5cb', 'is_logged', '1'),
('a6c8e5479d9bf70', 'is_logged', '1'),
('13daf8e13ad967f', 'is_logged', '1'),
('c916ce8d905f8c9', 'is_logged', '1'),
('4fe770d420035b8', 'is_logged', '1'),
('167bccbea81f5c6', 'is_logged', '1'),
('23a3c4f2bc81c34', 'is_logged', '1'),
('356bcc546583020', 'is_logged', '1'),
('d34af1acc84eaa4', 'is_logged', '1'),
('5c845ce608d9884', 'is_logged', '1'),
('83ab0b2afae51da', 'is_logged', '1'),
('d9a235e38754721', 'is_logged', '1'),
('beae3a5c2741f02', 'is_logged', '1'),
('c174c793d6e9c50', 'is_logged', '1'),
('0ad0db1e10a0f1c', 'is_logged', '1'),
('109b0e3b9b74da8', 'is_logged', '1'),
('c934b7993198ee1', 'is_logged', '1'),
('cf10979b900be2c', 'is_logged', '1'),
('fa75105b240a85e', 'is_logged', '1'),
('c9d6a8af4a19fbc', 'is_logged', '1'),
('3d55babfa6085da', 'is_logged', '1'),
('697e7828ba6c076', 'is_logged', '1'),
('7a1e79bcbb313ae', 'is_logged', '1'),
('a7e4f26731543c7', 'is_logged', '1'),
('2e5b443ae691b9d', 'is_logged', '1'),
('b476c8f8f1d465b', 'is_logged', '1'),
('1e397e259988ba5', 'is_logged', '1'),
('a2425a230ce71e5', 'is_logged', '1'),
('df740ff81d5786c', 'is_logged', '1'),
('d466a43f7acbcb0', 'is_logged', '1'),
('8a202ead1278119', 'is_logged', '1'),
('5b7834f9f58b955', 'is_logged', '1'),
('9ac4db01f14e475', 'is_logged', '1'),
('cab4d1099f7c827', 'is_logged', '1'),
('7fae5acecf20497', 'is_logged', '1'),
('1e2aedee356ef82', 'is_logged', '1'),
('ace992e88e6afff', 'is_logged', '1'),
('3eb696c5b406b26', 'is_logged', '1'),
('9faf3d4bfd2ac24', 'is_logged', '1'),
('ad444691e7afc2c', 'is_logged', '1'),
('b15aac56647962a', 'is_logged', '1'),
('bce93c16de29394', 'is_logged', '1'),
('d24bbfc1afaab1a', 'is_logged', '1'),
('6725964175c1d87', 'is_logged', '1'),
('3a1c8b08ede79eb', 'is_logged', '1'),
('481d8ba794fc8d5', 'is_logged', '1'),
('0de500b7837ab82', 'is_logged', '1'),
('70484636b8d83c8', 'is_logged', '1'),
('b4b40c6a1155215', 'is_logged', '1'),
('53f06b3e4b8d847', 'is_logged', '1'),
('b09af758adb3000', 'is_logged', '1'),
('7dfbc47e67ba577', 'is_logged', '1'),
('858aeee9688e2b1', 'is_logged', '1'),
('2f683aaae80df07', 'is_logged', '1'),
('5b05e621fe28bf3', 'is_logged', '1'),
('b2b253da5403bc7', 'is_logged', '1'),
('dead965447e4076', 'is_logged', '1'),
('43b4a4c60b34978', 'is_logged', '1'),
('59398b5086ed65b', 'is_logged', '1'),
('cb1d02cb3297cf3', 'is_logged', '1'),
('d231de320ce0310', 'is_logged', '1'),
('55d8b973879637d', 'is_logged', '1'),
('57fcc523d30d3cd', 'is_logged', '1'),
('94607d423bace2c', 'is_logged', '1'),
('15759e44198b912', 'is_logged', '1'),
('77dc9c8a327589e', 'is_logged', '1'),
('e4c9f087fa34a5a', 'is_logged', '1'),
('5e271857b1921b5', 'is_logged', '1'),
('d126323938c96cc', 'is_logged', '1'),
('d50252238e8e56e', 'is_logged', '1'),
('cb6d403ee55ea18', 'is_logged', '1'),
('fc08e34dedc5613', 'is_logged', '1'),
('c5104cd62944cf6', 'is_logged', '1'),
('9a9de07120a8ff7', 'is_logged', '1'),
('efa380412ce7fc6', 'is_logged', '1'),
('34a259f0ba640da', 'is_logged', '1'),
('433bd0f8ace8872', 'is_logged', '1'),
('824e240207ea41b', 'is_logged', '1'),
('36be1354d46e281', 'is_logged', '1'),
('8b89b71bc91372d', 'is_logged', '1'),
('eb39c9b10552231', 'is_logged', '1'),
('53c9d30f5b49d18', 'is_logged', '1'),
('26bcdffff72db22', 'is_logged', '1'),
('0a06aa8dd844394', 'is_logged', '1'),
('eea6816f2cd31c5', 'is_logged', '1'),
('b97bc55e7cce417', 'is_logged', '1'),
('7297556aca2b535', 'is_logged', '1'),
('a22a1fe45dc8449', 'is_logged', '1'),
('b036aabccf04758', 'is_logged', '1'),
('5b480988c2fdca7', 'is_logged', '1'),
('e0e399cfa14fbc4', 'is_logged', '1'),
('ce3a1fad05f8be8', 'is_logged', '1'),
('e86cd5a8e2e5076', 'is_logged', '1'),
('0ee95f30d3c8543', 'is_logged', '1'),
('c073d7433755950', 'is_logged', '1'),
('ad0b95c95a730d0', 'is_logged', '1'),
('2572d1c2aec909a', 'is_logged', '1');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` bigint(20) unsigned NOT NULL auto_increment,
  `login` varchar(20) NOT NULL default '',
  `password` varchar(32) NOT NULL default '',
  `email` text NOT NULL,
  `type` enum('guest','user','vip_user','moderator','admin') NOT NULL default 'guest',
  `state` enum('not_active','active','banned') NOT NULL default 'not_active',
  `is_autologin` tinyint(4) NOT NULL default '0',
  `createdTime` int(11) NOT NULL default '0',
  `lastEnterTime` bigint(11) NOT NULL default '0',
  PRIMARY KEY  (`user_id`),
  KEY `login` (`login`),
  KEY `password` (`password`)
) TYPE=MyISAM  AUTO_INCREMENT=7 ;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`user_id`, `login`, `password`, `email`, `type`, `state`, `is_autologin`, `createdTime`, `lastEnterTime`) VALUES
(1, 'nvvetal', 'e10adc3949ba59abbe56e057f20f883e', 'nvvetal@rambler.ru', 'user', 'active', 1, 0, 1198312361),
(6, 'zzzz', '827ccb0eea8a706c4c34a16891f84e7b', 'xcgfsdf@DD.COM', 'user', 'active', 1, 0, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `users_data`
--

CREATE TABLE IF NOT EXISTS `users_data` (
  `user_id` bigint(20) unsigned NOT NULL default '0',
  `u_param` char(100) NOT NULL default '',
  `u_value` char(255) NOT NULL default '',
  UNIQUE KEY `user_id_2` (`user_id`,`u_param`)
) TYPE=MyISAM;

--
-- Дамп данных таблицы `users_data`
--

INSERT INTO `users_data` (`user_id`, `u_param`, `u_value`) VALUES
(1, 'p_sex', 'male'),
(1, 'p_first_name', 'Виталий'),
(1, 'p_last_name', 'Гринчишин1'),
(1, 'p_from_location', 'Житомир'),
(1, 'p_birthday', '2007-12-23'),
(1, 'p_profession', 'программист'),
(1, 'p_hobby', 'Карточные игры'),
(1, 'p_url', 'zhitomirhost.com'),
(1, 'p_icq', '511723'),
(1, 'p_skype', 'nvvetal'),
(1, 'cookie_session', 'b01fb6e52e515c6'),
(1, 'cookie_session_key', '2bc1d0ab54642a3e720da7ea0f3c4f8a'),
(1, 'cookie_session_time', '12806753431850064791'),
(1, 'image_id', '9'),
(1, 'admin_partner_links', '1'),
(1, 'admin_schools', '1'),
(6, 'p_sex', 'female');
