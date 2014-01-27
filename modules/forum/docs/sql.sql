-- phpMyAdmin SQL Dump
-- version 3.1.3
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Апр 20 2010 г., 18:01
-- Версия сервера: 5.1.32
-- Версия PHP: 5.2.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- База данных: `rakscom`
--

-- --------------------------------------------------------

--
-- Структура таблицы `advertise`
--

CREATE TABLE IF NOT EXISTS `advertise` (
  `a_time` bigint(20) NOT NULL DEFAULT '0',
  `a_type` varchar(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `a_value` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  KEY `a_type` (`a_type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `advertise`
--


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

--
-- Дамп данных таблицы `banners_ip`
--

INSERT INTO `banners_ip` (`id`, `ip`, `time_showed`) VALUES
(1, 3262021221, 1254930746),
(2, 3262021221, 1254930751),
(3, 3262021221, 1254930816),
(4, 3262021221, 1254930899),
(5, 3262021221, 1254931127),
(6, 3262021221, 1254931166),
(7, 3262021221, 1254931174),
(8, 3262021221, 1254931201),
(9, 3262021221, 1254931209),
(10, 3262021221, 1254931241),
(11, 3262021221, 1254931963),
(12, 3262021221, 1254931966),
(13, 3262021221, 1254931984),
(14, 3262021221, 1254931987),
(15, 3262021221, 1254931991),
(16, 3262021221, 1254932008),
(17, 3262021221, 1254932107),
(18, 3262021221, 1254932115),
(19, 3262021221, 1254932118),
(20, 3262021221, 1254932620),
(21, 3262021221, 1254932621),
(22, 3262021221, 1254932627),
(23, 3262021221, 1254932725),
(24, 3262021221, 1254932727),
(25, 3262021221, 1254932734),
(26, 3262021221, 1254932753),
(27, 3262021221, 1254932755),
(28, 3262021221, 1254932779),
(29, 3262021221, 1254933395),
(30, 3262021221, 1254933403),
(31, 3262021221, 1254933413),
(32, 3262021221, 1254933442),
(33, 3262021221, 1254933502),
(34, 1834360178, 1254936572),
(35, 1572323468, 1254938515),
(36, 1572323468, 1254938549),
(37, 1572323468, 1254938551),
(38, 1572323468, 1254938551),
(39, 1834360178, 1254940679);

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

--
-- Дамп данных таблицы `blog_firm`
--


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

--
-- Дамп данных таблицы `blog_firm_posts`
--


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

--
-- Дамп данных таблицы `blog_firm_tags`
--


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

--
-- Дамп данных таблицы `calendar`
--

INSERT INTO `calendar` (`id`, `bdate`, `city_id`, `address`, `category_id`, `small_info`, `full_info`, `creator_id`, `organizator_name`, `is_approved`) VALUES
(11, '2009-03-21', 1, 'sdfsdfd', 1, 'sdfdsf', 'sdfd', 1, 'dsfdffds', 1),
(10, '2009-03-21', 1, 'cbvcv', 2, 'cvbcv22', 'cvbvc333', 1, 'bvccbvtertre4544', 1),
(12, '2009-05-29', 1, 'gggghghh', 2, 'Летний лагерь танцовщиц', 'Приходите в гости к нам', 1, 'Юлька', 0);

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

--
-- Дамп данных таблицы `calendar_additional_info`
--

INSERT INTO `calendar_additional_info` (`id`, `calendar_id`, `name`, `value`) VALUES
(95, 10, 'web0', ' dgdfg'),
(93, 10, 'image1', '22'),
(110, 11, 'image0', '23'),
(111, 11, 'image1', '30'),
(92, 10, 'image0', '20'),
(94, 10, 'lfm0', ' dfg'),
(97, 10, 'phone0', 'dfgf222'),
(96, 10, 'email0', ' dfgdfgdf');

-- --------------------------------------------------------

--
-- Структура таблицы `calendar_categories`
--

CREATE TABLE IF NOT EXISTS `calendar_categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `calendar_categories`
--

INSERT INTO `calendar_categories` (`id`, `name`) VALUES
(1, 'dance'),
(2, 'dance II');

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
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `config`
--


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
  `firm_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `createTime` bigint(20) NOT NULL DEFAULT '0',
  `state` enum('not_active','active','vip','banned') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'not_active',
  PRIMARY KEY (`firm_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Дамп данных таблицы `firms`
--


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

--
-- Дамп данных таблицы `firms_data`
--


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

--
-- Дамп данных таблицы `i18n_admin`
--

INSERT INTO `i18n_admin` (`id`, `lang`, `name`, `value`) VALUES
(1, 'ru', 'Mailer', '[Mailer]'),
(2, 'ru', 'Advertise', '[Advertise]'),
(3, 'ru', 'School', '[School]'),
(4, 'ru', 'Schools', '[Schools]'),
(5, 'ru', 'Schools Deleted', '[Schools Deleted]'),
(6, 'ru', 'School Messages', '[School Messages]'),
(7, 'ru', 'All messages', '[All messages]'),
(8, 'ru', 'Deleted Messages', '[Deleted Messages]'),
(123, 'ru', 'Partner Links', '[Partner Links]'),
(10, 'ru', 'Calendar', '[Calendar]'),
(11, 'ru', 'Calendars', '[Calendars]'),
(12, 'ru', 'Calendars Deleted', '[Calendars Deleted]'),
(13, 'ru', 'Main', '[Main]'),
(14, 'ru', 'Users', '[Users]'),
(15, 'ru', 'Images', '[Images]'),
(16, 'ru', 'User (5)', '[User (5)]'),
(17, 'ru', 'School (2)', '[School (2)]'),
(18, 'ru', 'Calendar (0)', '[Calendar (0)]'),
(19, 'ru', 'Translate', '[Translate]'),
(86, 'ru', 'admin', '[admin]'),
(21, 'ru', 'default', '[default]'),
(22, 'ru', 'Main Page', '[Main Page]'),
(23, 'ru', 'Admin Menu Order', '[Admin Menu Order]'),
(24, 'ru', 'ID', '[ID]'),
(25, 'ru', 'City', '[City]'),
(26, 'ru', 'Name', '[Name]'),
(27, 'ru', 'Info', '[Info]'),
(28, 'ru', 'Operations', '[Operations]'),
(146, 'ru', '??????????', '[??????????]'),
(30, 'ru', 'Edit', '[Edit]'),
(31, 'ru', 'Disable', '[Disable]'),
(32, 'ru', 'Delete', '[Delete]'),
(34, 'ru', 'Enable', '[Enable]'),
(35, 'ru', 'Other countries', '[Other countries]'),
(36, 'ru', 'Unknown city', '[Unknown city]'),
(37, 'ru', 'Ukraine', '[Ukraine]'),
(39, 'ru', 'URL', '[URL]'),
(40, 'ru', 'Email', '[Email]'),
(41, 'ru', 'ICQ', '[ICQ]'),
(42, 'ru', 'School phone 1', '[School phone 1]'),
(43, 'ru', 'School phone 2', '[School phone 2]'),
(44, 'ru', 'Address', '[Address]'),
(45, 'ru', 'School description', '[School description]'),
(46, 'ru', 'Current School Image', '[Current School Image]'),
(47, 'ru', 'School Image', '[School Image]'),
(48, 'ru', 'School Image upload', '[School Image upload]'),
(49, 'ru', 'Edit school', '[Edit school]'),
(50, 'ru', 'Back', '[Back]'),
(51, 'ru', 'Search', '[Search]'),
(52, 'ru', 'Login', '[Login]'),
(53, 'ru', 'Type', '[Type]'),
(54, 'ru', 'State', '[State]'),
(55, 'ru', 'Created', '[Created]'),
(56, 'ru', 'Last Login', '[Last Login]'),
(57, 'ru', 'Actions', '[Actions]'),
(58, 'ru', 'Edit User Profile', '[Edit User Profile]'),
(59, 'ru', 'Profile Image', '[Profile Image]'),
(60, 'ru', 'Your Profile Image', '[Your Profile Image]'),
(61, 'ru', 'Avatar upload', '[Avatar upload]'),
(62, 'ru', 'Sex', '[Sex]'),
(63, 'ru', 'Sex Unknown', '[Sex Unknown]'),
(64, 'ru', 'Sex Male', '[Sex Male]'),
(65, 'ru', 'Sex Female', '[Sex Female]'),
(66, 'ru', 'Reputation', '[Reputation]'),
(67, 'ru', 'First Name', '[First Name]'),
(68, 'ru', 'Last Name', '[Last Name]'),
(69, 'ru', 'From where?', '[From where?]'),
(70, 'ru', 'Birthday Date', '[Birthday Date]'),
(71, 'ru', 'Profession', '[Profession]'),
(72, 'ru', 'Hobby', '[Hobby]'),
(73, 'ru', 'Skype', '[Skype]'),
(74, 'ru', 'User Type', '[User Type]'),
(75, 'ru', 'Guest', '[Guest]'),
(76, 'ru', 'User', '[User]'),
(77, 'ru', 'Vip User', '[Vip User]'),
(78, 'ru', 'Moderator', '[Moderator]'),
(80, 'ru', 'Not active', '[Not active]'),
(81, 'ru', 'Active', '[Active]'),
(82, 'ru', 'Banned', '[Banned]'),
(83, 'ru', 'Save profile', '[Save profile]'),
(89, 'ru', 'Key', '[Key]'),
(90, 'ru', 'Value', '[Value]'),
(91, 'ru', 'No words', '[No words]'),
(92, 'ru', 'Password', '[Password]'),
(93, 'ru', 'Is autologin?', '[Is autologin?]'),
(94, 'ru', 'Log In', '[Log In]'),
(100, 'ru', 'Example', '[Example]'),
(101, 'ru', 'Visible_name', '[Visible_name]'),
(102, 'ru', 'Set', '[Set]'),
(103, 'ru', 'Add link', '[Add link]'),
(104, 'ru', 'Operation', '[Operation]'),
(105, 'ru', 'Byed Value', '[Byed Value]'),
(106, 'ru', 'Is enabled', '[Is enabled]'),
(107, 'ru', 'Position', '[Position1]'),
(108, 'ru', 'free', '[free]'),
(109, 'ru', 'None', '[None]'),
(110, 'ru', 'Down', '[Down]'),
(111, 'ru', 'pay_view', '[pay_view]'),
(112, 'ru', 'Up', '[Up]'),
(113, 'ru', 'pay_clicks', '[pay_clicks]'),
(114, 'ru', 'pay', '[pay]'),
(115, 'ru', 'All', '[All]'),
(122, 'ru', 'Not translated', '[Not translated22]'),
(117, 'ru', 'Change Filter', '[Change Filter]'),
(118, 'ru', 'Lang', '[Lang]'),
(119, 'ru', 'Search By', '[Search By]'),
(120, 'ru', 'Edit Key', '[Edit Key]'),
(121, 'ru', 'Save', '[Save]'),
(124, 'ru', 'Link url', '[Link url]'),
(125, 'ru', 'Link name', '[Link name]'),
(126, 'ru', 'Link external name', '[Link external name]'),
(127, 'ru', 'Link external codepage', '[Link external codepage]'),
(128, 'ru', 'Link description', '[Link description]'),
(129, 'ru', 'Link type', '[Link type]'),
(130, 'ru', 'Link type free', '[Link type free]'),
(131, 'ru', 'Link type pay', '[Link type pay]'),
(132, 'ru', 'Link type pay clicks', '[Link type pay clicks]'),
(133, 'ru', 'Link type pay view', '[Link type pay view]'),
(134, 'ru', 'Link type pay percent', '[Link type pay percent]'),
(135, 'ru', 'Link free viewed', '[Link free viewed]'),
(136, 'ru', 'Link pay end (type - pay)', '[Link pay end (type - pay)]'),
(137, 'ru', 'Link pay clicks', '[Link pay clicks]'),
(138, 'ru', 'Link pay clicked', '[Link pay clicked]'),
(139, 'ru', 'Link pay views', '[Link pay views]'),
(140, 'ru', 'Link pay viewed', '[Link pay viewed]'),
(141, 'ru', 'Link pay percent (koeficient, like 0.7)', '[Link pay percent (koeficient, like 0.7)]'),
(142, 'ru', 'Link pay percent clicks', '[Link pay percent clicks]'),
(143, 'ru', 'Link pay percent clicked', '[Link pay percent clicked]'),
(144, 'ru', 'Link is enabled', '[Link is enabled]'),
(145, 'ru', 'No schools found', '[No schools found]'),
(147, 'ru', 'Message', '[Message]'),
(148, 'ru', 'Author', '[Author]'),
(149, 'ru', 'Created Date', '[Created Date]'),
(150, 'ru', 'Approved status', '[Approved status]'),
(151, 'ru', 'Approved Date', '[Approved Date]'),
(152, 'ru', 'Approved', '[Approved]'),
(153, 'ru', 'Not Approved', '[Not Approved]'),
(154, 'ru', 'Waiting for approve', '[Waiting for approve]');

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

--
-- Дамп данных таблицы `i18n_default`
--

INSERT INTO `i18n_default` (`id`, `lang`, `name`, `value`) VALUES
(1, 'ru', 'Hello', '[Hello]'),
(2, 'ru', 'My Profile', '[My Profile]'),
(3, 'ru', 'My Schools', '[My Schools]'),
(39, 'ru', 'Main page', '[Main page]'),
(5, 'ru', 'Links page', '[Links page]'),
(6, 'ru', 'Schools page', '[Schools page]'),
(7, 'ru', 'Calendar page', '[Calendar page]'),
(8, 'ru', 'Dancing Schools', '[Dancing Schools]'),
(9, 'ru', 'Calendar Actions', '[Calendar Actions]'),
(10, 'ru', 'Forum', '[Forum]'),
(11, 'ru', 'Last forum messages', '[Last forum messages]'),
(12, 'ru', 'Login', '[Login]'),
(13, 'ru', 'Password', '[Password]'),
(14, 'ru', 'Is autologin?', '[Is autologin?]'),
(15, 'ru', 'Log In', '[Log In]'),
(16, 'ru', 'Mailer', '[Mailer]'),
(17, 'ru', 'Advertise', '[Advertise]'),
(18, 'ru', 'School', '[School]'),
(19, 'ru', 'Schools', '[Schools]'),
(20, 'ru', 'Schools Deleted', '[Schools Deleted]'),
(21, 'ru', 'School Messages', '[School Messages]'),
(22, 'ru', 'All messages', '[All messages]'),
(23, 'ru', 'Deleted Messages', '[Deleted Messages]'),
(24, 'ru', 'Partner Links', '[Partner Links]'),
(25, 'ru', 'Calendar', '[Calendar]'),
(26, 'ru', 'Calendars', '[Calendars]'),
(27, 'ru', 'Calendars Deleted', '[Calendars Deleted]'),
(28, 'ru', 'Main', '[Main]'),
(29, 'ru', 'Users', '[Users]'),
(30, 'ru', 'Images', '[Images]'),
(61, 'ru', 'User is not existing!', '[User is not existing!]'),
(33, 'ru', 'Calendar (0)', '[Calendar (0)]'),
(34, 'ru', 'Translate', '[Translate]'),
(35, 'ru', 'admin', '[admin]'),
(36, 'ru', 'default', '[default]'),
(38, 'ru', 'Admin Menu Order', '[Admin Menu Order]'),
(40, 'ru', 'Register', '[Register]'),
(41, 'ru', 'Edit My profile', '[Edit My profile]'),
(42, 'ru', 'Your Profile Image', '[Your Profile Image]'),
(43, 'ru', 'Avatar upload', '[Avatar upload]'),
(44, 'ru', 'Sex', '[Sex]'),
(45, 'ru', 'Sex Unknown', '[Sex Unknown]'),
(46, 'ru', 'Sex Male', '[Sex Male]'),
(47, 'ru', 'Sex Female', '[Sex Female]'),
(48, 'ru', 'Reputation', '[Reputation]'),
(49, 'ru', 'First Name', '[First Name]'),
(50, 'ru', 'Last Name', '[Last Name]'),
(51, 'ru', 'From where?', '[From where?]'),
(52, 'ru', 'Birthday Date', '[Birthday Date]'),
(53, 'ru', 'Profession', '[Profession]'),
(54, 'ru', 'Hobby', '[Hobby]'),
(55, 'ru', 'URL', '[URL]'),
(56, 'ru', 'ICQ', '[ICQ]'),
(57, 'ru', 'Skype', '[Skype]'),
(58, 'ru', 'Email', '[Email]'),
(59, 'ru', 'Save profile', '[Save profile]'),
(60, 'ru', 'User registered sucessfully!', '[User registered sucessfully!]'),
(62, 'ru', 'User profile', '[User profile]'),
(63, 'ru', 'User Image', '[User Image]'),
(64, 'ru', 'unknown', '[unknown]'),
(65, 'ru', 'Login errors', '[Login errors]'),
(66, 'ru', 'Login is not valid to is_dns!', '[Login is not valid to is_dns!]');

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

--
-- Дамп данных таблицы `images`
--

INSERT INTO `images` (`id`, `owner_id`, `owner_type`, `path`, `img_type`, `fname`, `approve_state`, `is_public`) VALUES
(1, 2, '', '2bb/d0e9dfd5967ef5bd1ad1', 'image/jpeg', 'd0e9dfd5967ef5bd1ad1', 0, 0),
(2, 2, '', 'eb5/6c112428a6d2bb225841', 'image/jpeg', '6c112428a6d2bb225841', 0, 0),
(3, 3, '', 'd24/7566ba60b73dedec2bac', 'image/jpeg', '7566ba60b73dedec2bac', 0, 0),
(4, 3, '', 'e84/2d439f5f170115ef6622', 'image/jpeg', '2d439f5f170115ef6622', 0, 0),
(5, 4, '', '94b/95c423dee25f7ba4a35a', 'image/jpeg', '95c423dee25f7ba4a35a', 0, 0),
(6, 4, '', '5a5/f1d46bccf95919e7c88d', 'image/jpeg', 'f1d46bccf95919e7c88d', 0, 0),
(7, 5, '', '5bc/f77700b8137306e12445', 'image/jpeg', 'f77700b8137306e12445', 0, 0),
(8, 5, '', 'f56/0c0962ed1e456f1a0f46', 'image/jpeg', '0c0962ed1e456f1a0f46', 0, 0),
(9, 6, 'calendar', 'f6e/86d5ee43f55a89116de2', 'image/jpeg', '86d5ee43f55a89116de2', 0, 0),
(10, 1, 'user', 'e93/74ed7ab9b223e34e8ffe', 'image/jpeg', '74ed7ab9b223e34e8ffe', 0, 0),
(11, 7, 'calendar', '28d/c035449adcea65677eda', 'image/jpeg', 'c035449adcea65677eda', 0, 0),
(12, 9, 'calendar', '0b9/312657fdcdf7f18c763f', 'image/jpeg', '312657fdcdf7f18c763f', 0, 0),
(13, 9, 'calendar', '0f1/e7b647c15009b45c055d', 'image/jpeg', 'e7b647c15009b45c055d', 0, 0),
(14, 3, 'school', '8a8/c2a2f087c905b2fd9d87', 'image/jpeg', 'c2a2f087c905b2fd9d87', 0, 0),
(15, 1, 'user', 'ad1/db9b0ad10bb9bf21b502', 'image/jpeg', 'db9b0ad10bb9bf21b502', 0, 0),
(16, 10, 'calendar', 'e1c/abb6942e23894ab25a3c', 'image/jpeg', 'abb6942e23894ab25a3c', 0, 0),
(17, 10, 'calendar', '6b4/0f127eed7a8aea6245ad', 'image/jpeg', '0f127eed7a8aea6245ad', 0, 0),
(18, 10, 'calendar', 'ec5/8b6242cb4577e1567402', 'image/jpeg', '8b6242cb4577e1567402', 0, 0),
(19, 10, 'calendar', '2d2/82e2fd873fa4f2bf091b', 'image/jpeg', '82e2fd873fa4f2bf091b', 0, 0),
(20, 10, 'calendar', '136/7db4b3b26a0f296ed7df', 'image/jpeg', '7db4b3b26a0f296ed7df', 0, 0),
(21, 10, 'calendar', 'df9/9c6d1509ed7e11c4e9d3', 'image/jpeg', '9c6d1509ed7e11c4e9d3', 0, 0),
(22, 10, 'calendar', 'de6/c8c168b6d56ebfed0e27', 'image/jpeg', 'c8c168b6d56ebfed0e27', 0, 0),
(23, 11, 'calendar', 'bea/fcb5f53723ed9b54070e', 'image/jpeg', 'fcb5f53723ed9b54070e', 0, 0),
(24, 11, 'calendar', '2a4/793e61ba89fe09948052', 'image/jpeg', '793e61ba89fe09948052', 0, 0),
(25, 11, 'calendar', 'c87/675dbd34a21b1fa6385d', 'image/jpeg', '675dbd34a21b1fa6385d', 0, 0),
(26, 11, 'calendar', 'eb8/bad0e0305f4678f4a98c', 'image/jpeg', 'bad0e0305f4678f4a98c', 0, 0),
(27, 11, 'calendar', 'c49/a1cb03cf178be0b8bc93', 'image/jpeg', 'a1cb03cf178be0b8bc93', 0, 0),
(28, 11, 'calendar', '187/3f8b36a0cba48294e0ee', 'image/jpeg', '3f8b36a0cba48294e0ee', 0, 0),
(30, 11, 'calendar', 'e49/dad9a5cc07b8784f26e7', 'image/jpeg', 'dad9a5cc07b8784f26e7', 0, 0),
(31, 6, 'user', '040/c6f74fdbaf73c9a95f19', 'image/gif', 'c6f74fdbaf73c9a95f19', 0, 0),
(32, 6, 'user', '412/213a70ef1a275421cfa2', 'image/jpeg', '213a70ef1a275421cfa2', 0, 0),
(33, 7, 'user', '65c/3419d6a1a8d94409e433', 'image/jpeg', '3419d6a1a8d94409e433', 0, 0);

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

--
-- Дамп данных таблицы `members`
--


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

--
-- Дамп данных таблицы `news`
--


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

--
-- Дамп данных таблицы `partner_links`
--

INSERT INTO `partner_links` (`id`, `url`, `name`, `external_name`, `external_codepage`, `description`, `type`, `free_viewed`, `pay_end`, `pay_clicks`, `pay_clicked`, `pay_views`, `pay_viewed`, `pay_percent_clicks`, `pay_percent_clicked`, `pay_percent`, `position`, `is_enabled`, `added_datetime`, `added_by`) VALUES
(1, 'http://google.com', 'google', 'zzzz', 'UTF-8', 'search site', 'pay', 1, '2009-12-19', 2, 3, 4, 5, 6, 0, 0.5, 5, 1, 0, 0),
(2, 'http://raks.com.ua', 'raks', 'Танец ЖЫВОТА', 'cp1251', '', 'pay_view', 0, '2009-12-01', 0, 0, 1000, 177, 0, 0, 1, 3, 1, 0, 0),
(4, 'zzzzzzzzzz', '323434', '', '', '', 'pay_clicks', 0, '2008-06-07', 5, 6, 0, 0, 0, 0, 1, 4, 1, 1212858268, 0),
(8, 'http://google.com', 'ahaha', 'hmmm', 'UTF-8', 'ololo', 'pay_view', 0, '2010-04-27', 0, 0, 1000, 63, 0, 0, 1, 2, 1, 1240835535, 0),
(10, 'sdfsdfsf', 'sdfsdfsdf', 'sd', 'UTF-8', '', 'free', 55, '2009-04-27', 0, 0, 0, 0, 0, 0, 1, 1, 1, 1240835687, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `partner_links_config`
--

CREATE TABLE IF NOT EXISTS `partner_links_config` (
  `name` varchar(255) NOT NULL DEFAULT '',
  `value` varchar(255) NOT NULL DEFAULT '',
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `partner_links_config`
--

INSERT INTO `partner_links_config` (`name`, `value`) VALUES
('visible_name', 'Друзья:&nbsp;');

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
(1215442264, 'view', 7, 1, 'http://rakscom.n.wap3.com.ua/partner_links/', 182326927),
(1223898351, 'view', 1, 1, 'http://rakscom.n.wap3.com.ua/partner_links/?s=39e618a898e53ac', 1299848055),
(1223898351, 'view', 2, 1, 'http://rakscom.n.wap3.com.ua/partner_links/?s=39e618a898e53ac', 1299848055),
(1223898351, 'view', 7, 1, 'http://rakscom.n.wap3.com.ua/partner_links/?s=39e618a898e53ac', 1299848055),
(1240831027, 'view', 1, 1, 'http://rakscom.n.wap3.com.ua/partner_links/?s=9fa87c0c3055ec2', 3262021123),
(1240831027, 'view', 2, 1, 'http://rakscom.n.wap3.com.ua/partner_links/?s=9fa87c0c3055ec2', 3262021123),
(1240831027, 'view', 7, 1, 'http://rakscom.n.wap3.com.ua/partner_links/?s=9fa87c0c3055ec2', 3262021123),
(1240832321, 'view', 1, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?a_id=partner_links&a_sid=p_links&s=f399eb828ceb01e', 3262021123),
(1240832321, 'view', 2, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?a_id=partner_links&a_sid=p_links&s=f399eb828ceb01e', 3262021123),
(1240832321, 'view', 7, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?a_id=partner_links&a_sid=p_links&s=f399eb828ceb01e', 3262021123),
(1240832333, 'view', 1, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?a_id=partner_links&a_sid=p_links&s=f399eb828ceb01e', 3262021123),
(1240832333, 'view', 2, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?a_id=partner_links&a_sid=p_links&s=f399eb828ceb01e', 3262021123),
(1240832333, 'view', 7, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?a_id=partner_links&a_sid=p_links&s=f399eb828ceb01e', 3262021123),
(1240833196, 'click', 7, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?a_id=partner_links&a_sid=p_links&s=f399eb828ceb01e', 3262021123),
(1240833198, 'view', 1, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?a_id=partner_links&a_sid=p_links&s=f399eb828ceb01e', 3262021123),
(1240833198, 'view', 2, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?a_id=partner_links&a_sid=p_links&s=f399eb828ceb01e', 3262021123),
(1240833310, 'view', 1, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?a_id=partner_links&a_sid=p_links&s=f399eb828ceb01e', 3262021123),
(1240833310, 'view', 2, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?a_id=partner_links&a_sid=p_links&s=f399eb828ceb01e', 3262021123),
(1240833335, 'click', 2, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?a_id=partner_links&a_sid=p_links&s=f399eb828ceb01e', 3262021123),
(1240833336, 'view', 1, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?a_id=partner_links&a_sid=p_links&s=f399eb828ceb01e', 3262021123),
(1240833336, 'view', 2, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?a_id=partner_links&a_sid=p_links&s=f399eb828ceb01e', 3262021123),
(1240833338, 'click', 2, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?a_id=partner_links&a_sid=p_links&s=f399eb828ceb01e', 3262021123),
(1240833340, 'view', 1, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?a_id=partner_links&a_sid=p_links&s=f399eb828ceb01e', 3262021123),
(1240833340, 'view', 2, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?a_id=partner_links&a_sid=p_links&s=f399eb828ceb01e', 3262021123),
(1240833958, 'view', 1, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&a_id=partner_links&a_sid=p_links', 3262021123),
(1240833958, 'view', 2, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&a_id=partner_links&a_sid=p_links', 3262021123),
(1240834023, 'view', 1, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&a_id=partner_links&a_sid=p_links', 3262021123),
(1240834023, 'view', 2, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&a_id=partner_links&a_sid=p_links', 3262021123),
(1240835541, 'view', 1, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?a_id=partner_links&a_sid=p_links&s=f399eb828ceb01e', 3262021123),
(1240835541, 'view', 2, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?a_id=partner_links&a_sid=p_links&s=f399eb828ceb01e', 3262021123),
(1240835541, 'view', 8, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?a_id=partner_links&a_sid=p_links&s=f399eb828ceb01e', 3262021123),
(1240835687, 'view', 1, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php', 3262021123),
(1240835687, 'view', 2, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php', 3262021123),
(1240835687, 'view', 8, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php', 3262021123),
(1240835796, 'view', 1, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&a_id=partner_links&a_sid=p_links', 3262021123),
(1240835796, 'view', 2, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&a_id=partner_links&a_sid=p_links', 3262021123),
(1240835796, 'view', 8, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&a_id=partner_links&a_sid=p_links', 3262021123),
(1240835951, 'view', 1, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?a_id=partner_links&a_sid=p_links&s=f399eb828ceb01e', 3262021123),
(1240835951, 'view', 2, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?a_id=partner_links&a_sid=p_links&s=f399eb828ceb01e', 3262021123),
(1240835951, 'view', 8, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?a_id=partner_links&a_sid=p_links&s=f399eb828ceb01e', 3262021123),
(1240836015, 'view', 1, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?a_id=partner_links&a_sid=p_links&s=f399eb828ceb01e', 3262021123),
(1240836015, 'view', 2, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?a_id=partner_links&a_sid=p_links&s=f399eb828ceb01e', 3262021123),
(1240836015, 'view', 8, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?a_id=partner_links&a_sid=p_links&s=f399eb828ceb01e', 3262021123),
(1240836024, 'view', 1, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?a_id=partner_links&a_sid=p_links&s=f399eb828ceb01e', 3262021123),
(1240836024, 'view', 2, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?a_id=partner_links&a_sid=p_links&s=f399eb828ceb01e', 3262021123),
(1240836024, 'view', 8, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?a_id=partner_links&a_sid=p_links&s=f399eb828ceb01e', 3262021123),
(1240836031, 'view', 1, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php', 3262021123),
(1240836031, 'view', 2, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php', 3262021123),
(1240836031, 'view', 8, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php', 3262021123),
(1240836115, 'view', 1, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php', 3262021123),
(1240836115, 'view', 2, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php', 3262021123),
(1240836115, 'view', 8, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php', 3262021123),
(1240836465, 'view', 1, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php', 3262021123),
(1240836465, 'view', 2, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php', 3262021123),
(1240836465, 'view', 8, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php', 3262021123),
(1240836465, 'view', 10, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php', 3262021123),
(1240836725, 'view', 1, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php', 3262021123),
(1240836725, 'view', 2, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php', 3262021123),
(1240836725, 'view', 8, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php', 3262021123),
(1240836725, 'view', 10, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php', 3262021123),
(1240836729, 'view', 1, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php', 3262021123),
(1240836729, 'view', 2, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php', 3262021123),
(1240836729, 'view', 8, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php', 3262021123),
(1240836729, 'view', 10, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php', 3262021123),
(1240836740, 'view', 1, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php', 3262021123),
(1240836740, 'view', 2, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php', 3262021123),
(1240836740, 'view', 8, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php', 3262021123),
(1240836740, 'view', 10, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php', 3262021123),
(1240836769, 'view', 1, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=delete_link&id=9&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836769, 'view', 2, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=delete_link&id=9&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836769, 'view', 8, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=delete_link&id=9&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836769, 'view', 10, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=delete_link&id=9&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836784, 'view', 1, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=delete_link&id=9&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836784, 'view', 2, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=delete_link&id=9&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836784, 'view', 8, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=delete_link&id=9&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836784, 'view', 10, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=delete_link&id=9&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836791, 'view', 1, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=up&id=10&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836791, 'view', 2, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=up&id=10&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836791, 'view', 8, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=up&id=10&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836791, 'view', 10, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=up&id=10&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836792, 'view', 1, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=up&id=10&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836792, 'view', 2, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=up&id=10&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836792, 'view', 8, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=up&id=10&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836792, 'view', 10, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=up&id=10&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836794, 'view', 1, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=up&id=10&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836794, 'view', 2, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=up&id=10&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836794, 'view', 8, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=up&id=10&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836794, 'view', 10, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=up&id=10&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836794, 'view', 1, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=up&id=10&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836794, 'view', 2, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=up&id=10&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836794, 'view', 8, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=up&id=10&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836794, 'view', 10, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=up&id=10&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836819, 'view', 1, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=up&id=10&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836819, 'view', 2, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=up&id=10&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836819, 'view', 10, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=up&id=10&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836819, 'view', 8, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=up&id=10&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836821, 'view', 1, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=up&id=8&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836821, 'view', 2, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=up&id=8&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836821, 'view', 8, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=up&id=8&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836821, 'view', 10, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=up&id=8&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836822, 'view', 1, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=up&id=8&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836822, 'view', 2, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=up&id=8&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836822, 'view', 8, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=up&id=8&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836822, 'view', 10, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=up&id=8&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836828, 'view', 1, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=up&id=7&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836828, 'view', 2, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=up&id=7&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836828, 'view', 8, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=up&id=7&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836828, 'view', 10, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=up&id=7&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836834, 'view', 1, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=down&id=7&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836834, 'view', 2, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=down&id=7&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836834, 'view', 8, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=down&id=7&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836834, 'view', 10, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=down&id=7&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836855, 'view', 1, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=down&id=1&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836855, 'view', 2, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=down&id=1&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836855, 'view', 8, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=down&id=1&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836855, 'view', 10, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=down&id=1&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836865, 'view', 2, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=down&id=1&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836865, 'view', 1, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=down&id=1&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836865, 'view', 8, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=down&id=1&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836865, 'view', 10, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=down&id=1&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836866, 'view', 2, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=down&id=1&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836866, 'view', 1, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=down&id=1&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836866, 'view', 8, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=down&id=1&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836866, 'view', 10, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=down&id=1&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836869, 'view', 2, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=up&id=1&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836869, 'view', 1, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=up&id=1&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836869, 'view', 8, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=up&id=1&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836869, 'view', 10, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=up&id=1&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836899, 'view', 2, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=up&id=10&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836899, 'view', 1, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=up&id=10&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836899, 'view', 8, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=up&id=10&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836899, 'view', 10, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=up&id=10&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836900, 'view', 2, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=up&id=10&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836900, 'view', 1, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=up&id=10&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836900, 'view', 10, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=up&id=10&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836900, 'view', 8, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=up&id=10&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836902, 'view', 2, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=up&id=10&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836902, 'view', 1, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=up&id=10&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836902, 'view', 10, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=up&id=10&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836902, 'view', 8, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=up&id=10&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836903, 'view', 2, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=up&id=10&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836903, 'view', 10, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=up&id=10&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836903, 'view', 1, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=up&id=10&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836903, 'view', 8, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=up&id=10&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836905, 'view', 10, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=up&id=10&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836905, 'view', 2, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=up&id=10&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836905, 'view', 1, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=up&id=10&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836905, 'view', 8, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=up&id=10&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836907, 'view', 10, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=up&id=1&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836907, 'view', 1, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=up&id=1&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836907, 'view', 2, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=up&id=1&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836907, 'view', 8, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=up&id=1&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836908, 'view', 1, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=up&id=1&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836908, 'view', 10, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=up&id=1&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836908, 'view', 2, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=up&id=1&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836908, 'view', 8, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=up&id=1&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836910, 'view', 1, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=up&id=1&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836910, 'view', 10, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=up&id=1&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836910, 'view', 2, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=up&id=1&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836910, 'view', 8, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=up&id=1&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836911, 'view', 10, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=down&id=1&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836911, 'view', 1, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=down&id=1&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836911, 'view', 2, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=down&id=1&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836911, 'view', 8, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=down&id=1&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836912, 'view', 10, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=down&id=1&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836912, 'view', 2, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=down&id=1&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836912, 'view', 1, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=down&id=1&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836912, 'view', 8, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=down&id=1&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836914, 'view', 10, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=down&id=1&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836914, 'view', 2, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=down&id=1&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836914, 'view', 1, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=down&id=1&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836914, 'view', 8, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=down&id=1&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836916, 'view', 10, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=down&id=1&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836916, 'view', 2, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=down&id=1&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836916, 'view', 8, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=down&id=1&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836916, 'view', 1, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=down&id=1&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836918, 'view', 10, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=down&id=1&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836918, 'view', 2, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=down&id=1&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836918, 'view', 8, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=down&id=1&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836918, 'view', 1, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=down&id=1&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836919, 'view', 10, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=down&id=1&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836919, 'view', 2, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=down&id=1&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836919, 'view', 8, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=down&id=1&a_id=partner_links&a_sid=p_links', 3262021123),
(1240836919, 'view', 1, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=f399eb828ceb01e&action=down&id=1&a_id=partner_links&a_sid=p_links', 3262021123),
(1240858477, 'view', 10, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?a_id=partner_links&a_sid=p_links&s=d581d2b77be351f', 3262021123),
(1240858477, 'view', 2, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?a_id=partner_links&a_sid=p_links&s=d581d2b77be351f', 3262021123),
(1240858477, 'view', 8, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?a_id=partner_links&a_sid=p_links&s=d581d2b77be351f', 3262021123),
(1240858477, 'view', 1, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?a_id=partner_links&a_sid=p_links&s=d581d2b77be351f', 3262021123),
(1240858478, 'view', 10, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=d581d2b77be351f&ago=edit_link&id=10&a_id=partner_links&a_sid=p_links', 3262021123),
(1240858478, 'view', 2, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=d581d2b77be351f&ago=edit_link&id=10&a_id=partner_links&a_sid=p_links', 3262021123),
(1240858478, 'view', 8, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=d581d2b77be351f&ago=edit_link&id=10&a_id=partner_links&a_sid=p_links', 3262021123),
(1240858478, 'view', 1, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=d581d2b77be351f&ago=edit_link&id=10&a_id=partner_links&a_sid=p_links', 3262021123),
(1240858480, 'view', 10, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=d581d2b77be351f&ago=edit_link&id=10&a_id=partner_links&a_sid=p_links', 3262021123),
(1240858480, 'view', 2, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=d581d2b77be351f&ago=edit_link&id=10&a_id=partner_links&a_sid=p_links', 3262021123),
(1240858480, 'view', 8, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=d581d2b77be351f&ago=edit_link&id=10&a_id=partner_links&a_sid=p_links', 3262021123),
(1240858480, 'view', 1, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=d581d2b77be351f&ago=edit_link&id=10&a_id=partner_links&a_sid=p_links', 3262021123),
(1240858481, 'view', 10, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=d581d2b77be351f&ago=edit_link&id=10&a_id=partner_links&a_sid=p_links', 3262021123),
(1240858481, 'view', 2, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=d581d2b77be351f&ago=edit_link&id=10&a_id=partner_links&a_sid=p_links', 3262021123),
(1240858481, 'view', 8, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=d581d2b77be351f&ago=edit_link&id=10&a_id=partner_links&a_sid=p_links', 3262021123),
(1240858481, 'view', 1, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=d581d2b77be351f&ago=edit_link&id=10&a_id=partner_links&a_sid=p_links', 3262021123),
(1240858546, 'view', 10, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=d581d2b77be351f&a_id=partner_links&a_sid=p_links', 3262021123),
(1240858546, 'view', 2, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=d581d2b77be351f&a_id=partner_links&a_sid=p_links', 3262021123),
(1240858546, 'view', 8, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=d581d2b77be351f&a_id=partner_links&a_sid=p_links', 3262021123),
(1240858546, 'view', 1, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=d581d2b77be351f&a_id=partner_links&a_sid=p_links', 3262021123),
(1240858617, 'view', 10, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?a_id=partner_links&a_sid=p_links&s=d581d2b77be351f', 3262021123),
(1240858617, 'view', 2, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?a_id=partner_links&a_sid=p_links&s=d581d2b77be351f', 3262021123),
(1240858617, 'view', 8, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?a_id=partner_links&a_sid=p_links&s=d581d2b77be351f', 3262021123),
(1240858617, 'view', 1, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?a_id=partner_links&a_sid=p_links&s=d581d2b77be351f', 3262021123),
(1240858621, 'view', 10, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=d581d2b77be351f&a_id=partner_links&a_sid=p_links', 3262021123),
(1240858621, 'view', 2, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=d581d2b77be351f&a_id=partner_links&a_sid=p_links', 3262021123),
(1240858621, 'view', 8, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=d581d2b77be351f&a_id=partner_links&a_sid=p_links', 3262021123),
(1240858621, 'view', 1, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=d581d2b77be351f&a_id=partner_links&a_sid=p_links', 3262021123),
(1240916913, 'view', 10, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?a_id=partner_links&a_sid=p_links&s=89d6840e77d8d86', 3262021123),
(1240916913, 'view', 2, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?a_id=partner_links&a_sid=p_links&s=89d6840e77d8d86', 3262021123),
(1240916913, 'view', 8, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?a_id=partner_links&a_sid=p_links&s=89d6840e77d8d86', 3262021123),
(1240916913, 'view', 1, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?a_id=partner_links&a_sid=p_links&s=89d6840e77d8d86', 3262021123),
(1240916917, 'view', 10, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=89d6840e77d8d86&action=delete_link&id=7&a_id=partner_links&a_sid=p_links', 3262021123),
(1240916917, 'view', 2, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=89d6840e77d8d86&action=delete_link&id=7&a_id=partner_links&a_sid=p_links', 3262021123),
(1240916917, 'view', 8, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=89d6840e77d8d86&action=delete_link&id=7&a_id=partner_links&a_sid=p_links', 3262021123),
(1240916917, 'view', 1, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=89d6840e77d8d86&action=delete_link&id=7&a_id=partner_links&a_sid=p_links', 3262021123),
(1240916919, 'view', 10, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=89d6840e77d8d86&action=up&id=8&a_id=partner_links&a_sid=p_links', 3262021123),
(1240916919, 'view', 2, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=89d6840e77d8d86&action=up&id=8&a_id=partner_links&a_sid=p_links', 3262021123),
(1240916919, 'view', 8, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=89d6840e77d8d86&action=up&id=8&a_id=partner_links&a_sid=p_links', 3262021123),
(1240916919, 'view', 1, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=89d6840e77d8d86&action=up&id=8&a_id=partner_links&a_sid=p_links', 3262021123),
(1240916921, 'view', 10, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=89d6840e77d8d86&action=up&id=8&a_id=partner_links&a_sid=p_links', 3262021123),
(1240916921, 'view', 8, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=89d6840e77d8d86&action=up&id=8&a_id=partner_links&a_sid=p_links', 3262021123),
(1240916921, 'view', 2, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=89d6840e77d8d86&action=up&id=8&a_id=partner_links&a_sid=p_links', 3262021123),
(1240916921, 'view', 1, 1, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=89d6840e77d8d86&action=up&id=8&a_id=partner_links&a_sid=p_links', 3262021123),
(1241008125, 'view', 10, 0, 'http://rakscom.s.wap3.com.ua/admin/index.php?a_id=partner_links&a_sid=p_links&s=97fa9f8819542fc', 1044411390),
(1241008125, 'view', 8, 0, 'http://rakscom.s.wap3.com.ua/admin/index.php?a_id=partner_links&a_sid=p_links&s=97fa9f8819542fc', 1044411390),
(1241008125, 'view', 2, 0, 'http://rakscom.s.wap3.com.ua/admin/index.php?a_id=partner_links&a_sid=p_links&s=97fa9f8819542fc', 1044411390),
(1241008125, 'view', 1, 0, 'http://rakscom.s.wap3.com.ua/admin/index.php?a_id=partner_links&a_sid=p_links&s=97fa9f8819542fc', 1044411390),
(1241086302, 'view', 10, 0, 'http://rakscom.n.wap3.com.ua/admin/index.php?a_id=partner_links&a_sid=p_links&s=b9b3931811d7187', 3262021123),
(1241086302, 'view', 8, 0, 'http://rakscom.n.wap3.com.ua/admin/index.php?a_id=partner_links&a_sid=p_links&s=b9b3931811d7187', 3262021123),
(1241086302, 'view', 2, 0, 'http://rakscom.n.wap3.com.ua/admin/index.php?a_id=partner_links&a_sid=p_links&s=b9b3931811d7187', 3262021123),
(1241086302, 'view', 1, 0, 'http://rakscom.n.wap3.com.ua/admin/index.php?a_id=partner_links&a_sid=p_links&s=b9b3931811d7187', 3262021123),
(1241086305, 'view', 10, 0, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=b9b3931811d7187&a_id=partner_links&a_sid=p_links', 3262021123),
(1241086305, 'view', 8, 0, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=b9b3931811d7187&a_id=partner_links&a_sid=p_links', 3262021123),
(1241086305, 'view', 2, 0, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=b9b3931811d7187&a_id=partner_links&a_sid=p_links', 3262021123),
(1241086305, 'view', 1, 0, 'http://rakscom.n.wap3.com.ua/admin/index.php?s=b9b3931811d7187&a_id=partner_links&a_sid=p_links', 3262021123),
(1243253633, 'view', 10, 0, 'http://rakscom.n.wap3.com.ua/admin/index.php?a_id=partner_links&a_sid=p_links&s=2f5eb4d993804c8', 3262021123),
(1243253633, 'view', 8, 0, 'http://rakscom.n.wap3.com.ua/admin/index.php?a_id=partner_links&a_sid=p_links&s=2f5eb4d993804c8', 3262021123),
(1243253633, 'view', 2, 0, 'http://rakscom.n.wap3.com.ua/admin/index.php?a_id=partner_links&a_sid=p_links&s=2f5eb4d993804c8', 3262021123),
(1243253633, 'view', 1, 0, 'http://rakscom.n.wap3.com.ua/admin/index.php?a_id=partner_links&a_sid=p_links&s=2f5eb4d993804c8', 3262021123),
(1243254224, 'view', 10, 0, 'http://rakscom.n.wap3.com.ua/admin/index.php?a_id=partner_links&a_sid=p_links&s=2f5eb4d993804c8', 3262021123),
(1243254224, 'view', 8, 0, 'http://rakscom.n.wap3.com.ua/admin/index.php?a_id=partner_links&a_sid=p_links&s=2f5eb4d993804c8', 3262021123),
(1243254224, 'view', 2, 0, 'http://rakscom.n.wap3.com.ua/admin/index.php?a_id=partner_links&a_sid=p_links&s=2f5eb4d993804c8', 3262021123),
(1243254224, 'view', 1, 0, 'http://rakscom.n.wap3.com.ua/admin/index.php?a_id=partner_links&a_sid=p_links&s=2f5eb4d993804c8', 3262021123),
(1243255189, 'view', 10, 0, 'http://rakscom.n.wap3.com.ua/admin/index.php?a_id=partner_links&a_sid=p_links&s=2f5eb4d993804c8', 3262021123),
(1243255189, 'view', 8, 0, 'http://rakscom.n.wap3.com.ua/admin/index.php?a_id=partner_links&a_sid=p_links&s=2f5eb4d993804c8', 3262021123),
(1243255189, 'view', 2, 0, 'http://rakscom.n.wap3.com.ua/admin/index.php?a_id=partner_links&a_sid=p_links&s=2f5eb4d993804c8', 3262021123),
(1243255189, 'view', 1, 0, 'http://rakscom.n.wap3.com.ua/admin/index.php?a_id=partner_links&a_sid=p_links&s=2f5eb4d993804c8', 3262021123),
(1243255194, 'view', 10, 0, 'http://rakscom.n.wap3.com.ua/admin/index.php?a_id=partner_links&a_sid=p_links&s=2f5eb4d993804c8', 3262021123),
(1243255194, 'view', 8, 0, 'http://rakscom.n.wap3.com.ua/admin/index.php?a_id=partner_links&a_sid=p_links&s=2f5eb4d993804c8', 3262021123),
(1243255194, 'view', 2, 0, 'http://rakscom.n.wap3.com.ua/admin/index.php?a_id=partner_links&a_sid=p_links&s=2f5eb4d993804c8', 3262021123),
(1243255194, 'view', 1, 0, 'http://rakscom.n.wap3.com.ua/admin/index.php?a_id=partner_links&a_sid=p_links&s=2f5eb4d993804c8', 3262021123),
(1243255603, 'view', 10, 0, 'http://rakscom.n.wap3.com.ua/partner_links/?s=ee4e7835d89f62b', 3262021123),
(1243255603, 'view', 8, 0, 'http://rakscom.n.wap3.com.ua/partner_links/?s=ee4e7835d89f62b', 3262021123),
(1243255603, 'view', 2, 0, 'http://rakscom.n.wap3.com.ua/partner_links/?s=ee4e7835d89f62b', 3262021123),
(1243255603, 'view', 1, 0, 'http://rakscom.n.wap3.com.ua/partner_links/?s=ee4e7835d89f62b', 3262021123),
(1245136414, 'view', 10, 0, 'http://rakscom.s.wap3.com.ua/partner_links/?s=8365060e5626cc6', 3257668217),
(1245136414, 'view', 8, 0, 'http://rakscom.s.wap3.com.ua/partner_links/?s=8365060e5626cc6', 3257668217),
(1245136414, 'view', 2, 0, 'http://rakscom.s.wap3.com.ua/partner_links/?s=8365060e5626cc6', 3257668217),
(1245136414, 'view', 1, 0, 'http://rakscom.s.wap3.com.ua/partner_links/?s=8365060e5626cc6', 3257668217),
(1245136434, 'view', 10, 0, 'http://rakscom.s.wap3.com.ua/partner_links/?s=8365060e5626cc6', 3257668217),
(1245136434, 'view', 8, 0, 'http://rakscom.s.wap3.com.ua/partner_links/?s=8365060e5626cc6', 3257668217),
(1245136434, 'view', 2, 0, 'http://rakscom.s.wap3.com.ua/partner_links/?s=8365060e5626cc6', 3257668217),
(1245136434, 'view', 1, 0, 'http://rakscom.s.wap3.com.ua/partner_links/?s=8365060e5626cc6', 3257668217),
(1245136465, 'view', 10, 0, 'http://rakscom.s.wap3.com.ua/partner_links/?s=8365060e5626cc6', 3257668217),
(1245136465, 'view', 8, 0, 'http://rakscom.s.wap3.com.ua/partner_links/?s=8365060e5626cc6', 3257668217),
(1245136465, 'view', 2, 0, 'http://rakscom.s.wap3.com.ua/partner_links/?s=8365060e5626cc6', 3257668217),
(1245136465, 'view', 1, 0, 'http://rakscom.s.wap3.com.ua/partner_links/?s=8365060e5626cc6', 3257668217);

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
  `rating_id` bigint(20) NOT NULL DEFAULT '0',
  `item_id` bigint(20) NOT NULL DEFAULT '0',
  `value` bigint(20) NOT NULL DEFAULT '0',
  UNIQUE KEY `rating_idx` (`rating_id`,`item_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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

--
-- Дамп данных таблицы `schools`
--

INSERT INTO `schools` (`id`, `name`, `description`, `image_id`, `owner_id`, `city_id`, `email`, `icq`, `url`, `address`, `phone_1`, `phone_2`, `created_date_time`, `position`, `payed_link_date_start`, `payed_link_date_end`, `last_updated_date`, `is_approved`) VALUES
(4, 'Баядера1', 'Бест скул', 0, 7, 1, 'khalisy@mail.ru', 0, '', 'киев', '11111', '111', 1241009417, 0, 0, 0, 1243253861, 1),
(2, 'zzzzz1', 'hmmmmmm', 21, 1, 1, 'nv-vetal@rambler.ru', 0, '', 'zzzzz', '02', '', 1211981830, 0, 0, 0, 1240916837, 0),
(3, 'zzzzzzzzzz12', 'sadfdf', 14, 1, 1, 'sdfdsf@1.com', 0, 'dsfsdf', 'dfsgdfgdfgdfg', '22222222222222', '22222222', 1237632784, 0, 0, 0, 1240916840, 0);

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

--
-- Дамп данных таблицы `school_blog`
--

INSERT INTO `school_blog` (`id`, `pid`, `school_id`, `text`, `author_id`, `created_date`, `is_approved`, `moderator_id`, `approve_date`) VALUES
(1, 0, 2, 'sadfsadf', 1, '0000-00-00 00:00:00', 'y', 0, '0000-00-00 00:00:00'),
(2, 1, 1, 'haha', 6, '0000-00-00 00:00:00', 'y', 0, '0000-00-00 00:00:00'),
(3, 0, 1, 'еще раз бла-бла-бла', 1, '0000-00-00 00:00:00', 'y', 0, '0000-00-00 00:00:00'),
(4, 0, 2, 'fgf', 1, '0000-00-00 00:00:00', 'y', 0, '0000-00-00 00:00:00'),
(5, 1, 2, 'xczcxc', 1, '0000-00-00 00:00:00', 'y', 0, '0000-00-00 00:00:00'),
(6, 5, 2, 'xccc', 1, '0000-00-00 00:00:00', 'y', 0, '0000-00-00 00:00:00'),
(7, 0, 2, 'CU!', 1, '0000-00-00 00:00:00', 'y', 0, '0000-00-00 00:00:00'),
(8, 6, 2, 'huy', 1, '0000-00-00 00:00:00', 'y', 0, '0000-00-00 00:00:00'),
(9, 8, 2, 'ttt', 1, '0000-00-00 00:00:00', 'y', 0, '0000-00-00 00:00:00'),
(10, 8, 2, 'cvbcvb', 1, '0000-00-00 00:00:00', 'n', 0, '0000-00-00 00:00:00'),
(11, 8, 2, '111', 1, '0000-00-00 00:00:00', 'y', 0, '0000-00-00 00:00:00'),
(12, 2, 2, 'tutu', 1, '0000-00-00 00:00:00', 'y', 0, '0000-00-00 00:00:00'),
(13, 1, 2, 'upyachka', 1, '0000-00-00 00:00:00', 'y', 0, '0000-00-00 00:00:00'),
(14, 0, 2, 'fvbnbn', 1, '0000-00-00 00:00:00', 'y', 0, '0000-00-00 00:00:00'),
(15, 0, 3, 'jojo', 1, '0000-00-00 00:00:00', 'p', 7, '0000-00-00 00:00:00'),
(16, 15, 3, 'hmmm', 1, '0000-00-00 00:00:00', 'y', 0, '0000-00-00 00:00:00');

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

--
-- Дамп данных таблицы `sessions`
--

INSERT INTO `sessions` (`sess_id`, `user_id`, `createdTime`, `updatedTime`, `expireTime`, `state`, `type`, `remote_addr`, `user_agent`) VALUES
('746c8445d2f790c', 0, 1238345641, 0, 1238349241, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.7) Gecko/2009021910 Firefox/3.0.7'),
('dc413d875106167', 0, 1238345647, 0, 1238349247, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.7) Gecko/2009021910 Firefox/3.0.7'),
('f7fcc62c7f63c3b', 1, 1238345647, 1238345666, 1238349266, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.7) Gecko/2009021910 Firefox/3.0.7'),
('c80959e829a7ac2', 0, 1238345670, 0, 1238349270, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.7) Gecko/2009021910 Firefox/3.0.7'),
('c4d439b0413d15c', 0, 1238345681, 0, 1238349281, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.7) Gecko/2009021910 Firefox/3.0.7'),
('fb9a557c5780000', 0, 1238346671, 0, 1238350271, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.7) Gecko/2009021910 Firefox/3.0.7'),
('6f9e7dd0bb2f0e0', 0, 1238347621, 0, 1238351221, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.7) Gecko/2009021910 Firefox/3.0.7'),
('d4bf9e29332bae5', 0, 1238347621, 0, 1238351221, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.7) Gecko/2009021910 Firefox/3.0.7'),
('4d6c088c7b58687', 0, 1238347693, 0, 1238351293, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.7) Gecko/2009021910 Firefox/3.0.7'),
('f41393eecda7a2b', 0, 1238347785, 0, 1238351385, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.7) Gecko/2009021910 Firefox/3.0.7'),
('fdf3f3a6ca30dad', 0, 1238348188, 0, 1238351788, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.7) Gecko/2009021910 Firefox/3.0.7'),
('6fed5a3db8e1399', 0, 1238350344, 0, 1238353944, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.7) Gecko/2009021910 Firefox/3.0.7'),
('d0bfd4c069175d1', 0, 1238350524, 0, 1238354124, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.7) Gecko/2009021910 Firefox/3.0.7'),
('a41590b33f6d466', 0, 1238858493, 0, 1238862093, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.8) Gecko/2009032609 Firefox/3.0.8'),
('50c470e15a3396c', 0, 1238858493, 0, 1238862093, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.8) Gecko/2009032609 Firefox/3.0.8'),
('04a99d1198d878b', 0, 1238858498, 0, 1238862098, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.8) Gecko/2009032609 Firefox/3.0.8'),
('f702c3bfbc5f049', 0, 1238858498, 0, 1238862098, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.8) Gecko/2009032609 Firefox/3.0.8'),
('fb8ff5801f376a0', 0, 1238859084, 0, 1238862684, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.8) Gecko/2009032609 Firefox/3.0.8'),
('9193f0862fd6b3d', 1, 1238859086, 1238859093, 1238862693, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.8) Gecko/2009032609 Firefox/3.0.8'),
('c0156af4983e759', 0, 1238859112, 0, 1238862712, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.8) Gecko/2009032609 Firefox/3.0.8'),
('d5665d378fd756c', 1, 1238859114, 1238859126, 1238862726, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.8) Gecko/2009032609 Firefox/3.0.8'),
('dcb098db4e89c22', 1, 1238859130, 1238861125, 1238864725, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.8) Gecko/2009032609 Firefox/3.0.8'),
('01813ccab35033a', 1, 1238866622, 1238869534, 1238873134, 'expired', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.8) Gecko/2009032609 Firefox/3.0.8'),
('ab4e70df8d833b8', 1, 1238916903, 1238916912, 1238920512, 'expired', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.8) Gecko/2009032609 Firefox/3.0.8'),
('5d4801a4530b4ba', 1, 1238927539, 0, 1238931139, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.8) Gecko/2009032609 Firefox/3.0.8'),
('30c73b4c4a647c3', 0, 1238944748, 0, 1238948348, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.8) Gecko/2009032609 Firefox/3.0.8'),
('ed33ae82cacf9a2', 1, 1238944754, 0, 1238948354, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.8) Gecko/2009032609 Firefox/3.0.8'),
('f70873c5314ed49', 1, 1238944759, 0, 1238948359, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.8) Gecko/2009032609 Firefox/3.0.8'),
('846a7f770ca708d', 1, 1238944759, 0, 1238948359, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.8) Gecko/2009032609 Firefox/3.0.8'),
('00bb3af509e78e1', 1, 1238944760, 0, 1238948360, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.8) Gecko/2009032609 Firefox/3.0.8'),
('7a70c59ea823321', 1, 1238944760, 0, 1238948360, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.8) Gecko/2009032609 Firefox/3.0.8'),
('962813260aeaa64', 1, 1238944760, 0, 1238948360, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.8) Gecko/2009032609 Firefox/3.0.8'),
('c8f4b7e1a3ed4fd', 1, 1238944760, 0, 1238948360, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.8) Gecko/2009032609 Firefox/3.0.8'),
('958e7ef37d41fef', 1, 1238944817, 0, 1238948417, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.8) Gecko/2009032609 Firefox/3.0.8'),
('4b07a715e44ef57', 1, 1238944858, 0, 1238948458, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.8) Gecko/2009032609 Firefox/3.0.8'),
('ae361b69c9af7fe', 1, 1238944876, 0, 1238948476, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.8) Gecko/2009032609 Firefox/3.0.8'),
('ee9f6be61c7e05d', 1, 1238945025, 0, 1238948625, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.8) Gecko/2009032609 Firefox/3.0.8'),
('9a44b4bfe1d4a52', 1, 1238945041, 0, 1238948641, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.8) Gecko/2009032609 Firefox/3.0.8'),
('dc9ae90339c2edb', 1, 1238945055, 0, 1238948655, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.8) Gecko/2009032609 Firefox/3.0.8'),
('f62a8b1ad2d560f', 1, 1238945185, 1238949553, 1238953153, 'expired', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.8) Gecko/2009032609 Firefox/3.0.8'),
('825bc9338c88a79', 1, 1238997486, 1239004678, 1239008278, 'expired', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.8) Gecko/2009032609 Firefox/3.0.8'),
('c325763978aa09b', 1, 1239032680, 1239035091, 1239038691, 'expired', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.8) Gecko/2009032609 Firefox/3.0.8'),
('a5402b8dab92102', 1, 1239040067, 1239040068, 1239043668, 'expired', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.8) Gecko/2009032609 Firefox/3.0.8'),
('6c6c954d1fb77b9', 1, 1239080734, 0, 1239084334, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.8) Gecko/2009032609 Firefox/3.0.8'),
('cfa27644b68837a', 1, 1239788338, 1239788486, 1239792086, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.8) Gecko/2009032609 Firefox/3.0.8'),
('c4eb53857e38d79', 1, 1239789189, 1239791375, 1239794975, 'expired', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.8) Gecko/2009032609 Firefox/3.0.8'),
('ea16d442b12bc01', 1, 1239799512, 1239801048, 1239804648, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.8) Gecko/2009032609 Firefox/3.0.8'),
('489d64caceb9d17', 0, 1240036117, 1240036240, 1240039840, 'active', 'web', '80.73.6.161', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.8) Gecko/2009032609 MRA 5.4 (build 02647) Firefox/3.0.8'),
('62bd1d1d0a32896', 1, 1240473779, 1240473806, 1240477406, 'expired', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.8) Gecko/2009032609 Firefox/3.0.8'),
('2f17bfd84d4e498', 1, 1240477534, 1240484222, 1240487822, 'expired', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.8) Gecko/2009032609 Firefox/3.0.8'),
('d4e35599531ebdf', 1, 1240491302, 1240491307, 1240494907, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.8) Gecko/2009032609 Firefox/3.0.8'),
('5999148894c3c84', 0, 1240826878, 0, 1240830478, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.9) Gecko/2009040821 Firefox/3.0.9'),
('f399eb828ceb01e', 1, 1240826883, 1240846998, 1240850598, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.9) Gecko/2009040821 Firefox/3.0.9'),
('77f28747d4fdcf5', 1, 1240829871, 0, 1240833471, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.9) Gecko/2009040821 Firefox/3.0.9'),
('9fa87c0c3055ec2', 1, 1240830984, 1240831027, 1240834627, 'expired', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.9) Gecko/2009040821 Firefox/3.0.9'),
('178ac1c4ec4bfec', 1, 1240831027, 0, 1240834627, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.9) Gecko/2009040821 Firefox/3.0.9'),
('2693fcb1d46bc9a', 1, 1240832321, 0, 1240835921, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.9) Gecko/2009040821 Firefox/3.0.9'),
('e8aefc04416defc', 1, 1240832333, 0, 1240835933, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.9) Gecko/2009040821 Firefox/3.0.9'),
('107a61b18c43483', 1, 1240833196, 0, 1240836796, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.9) Gecko/2009040821 Firefox/3.0.9'),
('56fcac753e4a942', 1, 1240833198, 0, 1240836798, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.9) Gecko/2009040821 Firefox/3.0.9'),
('45f7ac9d50ff795', 1, 1240833310, 0, 1240836910, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.9) Gecko/2009040821 Firefox/3.0.9'),
('c374a8e9519146e', 1, 1240833335, 0, 1240836935, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.9) Gecko/2009040821 Firefox/3.0.9'),
('629210ad937a1fa', 1, 1240833336, 0, 1240836936, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.9) Gecko/2009040821 Firefox/3.0.9'),
('d9c523092c80cf5', 1, 1240833338, 0, 1240836938, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.9) Gecko/2009040821 Firefox/3.0.9'),
('b42b119e4e0766c', 1, 1240833340, 0, 1240836940, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.9) Gecko/2009040821 Firefox/3.0.9'),
('7dd4dcf8950914f', 1, 1240833958, 0, 1240837558, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.9) Gecko/2009040821 Firefox/3.0.9'),
('fc4340c0dcee9db', 1, 1240834023, 0, 1240837623, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.9) Gecko/2009040821 Firefox/3.0.9'),
('b5bff56e04f00aa', 0, 1240835439, 0, 1240839039, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.9) Gecko/2009040821 Firefox/3.0.9'),
('f72ebc6292abc50', 0, 1240835535, 0, 1240839135, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.9) Gecko/2009040821 Firefox/3.0.9'),
('97a3b25490dc092', 1, 1240835541, 0, 1240839141, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.9) Gecko/2009040821 Firefox/3.0.9'),
('a9347883332a587', 0, 1240835553, 0, 1240839153, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.9) Gecko/2009040821 Firefox/3.0.9'),
('b698688fd5b2e44', 1, 1240835687, 0, 1240839287, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.9) Gecko/2009040821 Firefox/3.0.9'),
('86b09e9a7a3e1f1', 1, 1240835796, 0, 1240839396, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.9) Gecko/2009040821 Firefox/3.0.9'),
('a1420299ff9a819', 1, 1240835951, 0, 1240839551, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.9) Gecko/2009040821 Firefox/3.0.9'),
('db55e179105fcb8', 1, 1240836015, 0, 1240839615, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.9) Gecko/2009040821 Firefox/3.0.9'),
('62d0be2db5c78a8', 1, 1240836024, 0, 1240839624, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.9) Gecko/2009040821 Firefox/3.0.9'),
('e40e1841ac9f308', 1, 1240836031, 0, 1240839631, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.9) Gecko/2009040821 Firefox/3.0.9'),
('0d5d0e626e2f9d4', 1, 1240836115, 0, 1240839715, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.9) Gecko/2009040821 Firefox/3.0.9'),
('11c003aaab5746e', 1, 1240836465, 0, 1240840065, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.9) Gecko/2009040821 Firefox/3.0.9'),
('cfd55b6e7830f5f', 1, 1240836725, 0, 1240840325, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.9) Gecko/2009040821 Firefox/3.0.9'),
('b1a28d521191705', 1, 1240836729, 0, 1240840329, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.9) Gecko/2009040821 Firefox/3.0.9'),
('c09deb99dbc42d9', 1, 1240836740, 0, 1240840340, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.9) Gecko/2009040821 Firefox/3.0.9'),
('ec3f65d671de564', 1, 1240836769, 0, 1240840369, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.9) Gecko/2009040821 Firefox/3.0.9'),
('b351eee96af6196', 1, 1240836784, 0, 1240840384, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.9) Gecko/2009040821 Firefox/3.0.9'),
('5e06f4658894876', 1, 1240836791, 0, 1240840391, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.9) Gecko/2009040821 Firefox/3.0.9'),
('a7f692652ae5616', 1, 1240836792, 0, 1240840392, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.9) Gecko/2009040821 Firefox/3.0.9'),
('7b6b59e436e798e', 1, 1240836794, 0, 1240840394, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.9) Gecko/2009040821 Firefox/3.0.9'),
('194306a47815d7c', 1, 1240836794, 0, 1240840394, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.9) Gecko/2009040821 Firefox/3.0.9'),
('4e4834abc1b16de', 1, 1240836819, 0, 1240840419, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.9) Gecko/2009040821 Firefox/3.0.9'),
('6d9688379acdfeb', 1, 1240836821, 0, 1240840421, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.9) Gecko/2009040821 Firefox/3.0.9'),
('0e7354c63ade6ff', 1, 1240836822, 0, 1240840422, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.9) Gecko/2009040821 Firefox/3.0.9'),
('d503ce6843c6584', 1, 1240836828, 0, 1240840428, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.9) Gecko/2009040821 Firefox/3.0.9'),
('abe1a622ecb4b9a', 1, 1240836834, 0, 1240840434, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.9) Gecko/2009040821 Firefox/3.0.9'),
('015b8db029ebef6', 1, 1240836855, 0, 1240840455, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.9) Gecko/2009040821 Firefox/3.0.9'),
('befa6122a706e8b', 1, 1240836865, 0, 1240840465, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.9) Gecko/2009040821 Firefox/3.0.9'),
('c9e50910292de5d', 1, 1240836866, 0, 1240840466, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.9) Gecko/2009040821 Firefox/3.0.9'),
('8b7fe33bf27b17f', 1, 1240836869, 0, 1240840469, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.9) Gecko/2009040821 Firefox/3.0.9'),
('c5f3a31d314ffe1', 1, 1240836899, 0, 1240840499, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.9) Gecko/2009040821 Firefox/3.0.9'),
('38d897035ec0114', 1, 1240836900, 0, 1240840500, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.9) Gecko/2009040821 Firefox/3.0.9'),
('022c405dc5f718d', 1, 1240836902, 0, 1240840502, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.9) Gecko/2009040821 Firefox/3.0.9'),
('625a3bbf366f271', 1, 1240836903, 0, 1240840503, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.9) Gecko/2009040821 Firefox/3.0.9'),
('6632997e8ae2552', 1, 1240836905, 0, 1240840505, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.9) Gecko/2009040821 Firefox/3.0.9'),
('c53ab000fb72187', 1, 1240836907, 0, 1240840507, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.9) Gecko/2009040821 Firefox/3.0.9'),
('42316eaeed0f05e', 1, 1240836908, 0, 1240840508, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.9) Gecko/2009040821 Firefox/3.0.9'),
('0dea827e33d0146', 1, 1240836910, 0, 1240840510, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.9) Gecko/2009040821 Firefox/3.0.9'),
('24014adb8e45d99', 1, 1240836911, 0, 1240840511, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.9) Gecko/2009040821 Firefox/3.0.9'),
('9256408c759ba3f', 1, 1240836912, 0, 1240840512, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.9) Gecko/2009040821 Firefox/3.0.9'),
('dd47b7d3fa72bcc', 1, 1240836914, 0, 1240840514, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.9) Gecko/2009040821 Firefox/3.0.9'),
('f574def60badcbf', 1, 1240836916, 0, 1240840516, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.9) Gecko/2009040821 Firefox/3.0.9'),
('6d5740f27f46d64', 1, 1240836918, 0, 1240840518, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.9) Gecko/2009040821 Firefox/3.0.9'),
('7d5be38db0e65b3', 1, 1240836919, 0, 1240840519, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.9) Gecko/2009040821 Firefox/3.0.9'),
('1fb05d06721539e', 1, 1240838385, 1240838418, 1240842018, 'expired', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.9) Gecko/2009040821 Firefox/3.0.9'),
('118754db4e7ce9a', 1, 1240853370, 0, 1240856970, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.9) Gecko/2009040821 Firefox/3.0.9'),
('d581d2b77be351f', 1, 1240854894, 1240859049, 1240862649, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.9) Gecko/2009040821 Firefox/3.0.9'),
('3f23798980e515f', 1, 1240858477, 0, 1240862077, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.9) Gecko/2009040821 Firefox/3.0.9'),
('35b98d4f5cf65f7', 1, 1240858478, 0, 1240862078, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.9) Gecko/2009040821 Firefox/3.0.9'),
('6bc11b44d2012e9', 1, 1240858480, 0, 1240862080, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.9) Gecko/2009040821 Firefox/3.0.9'),
('b2958869e38cca2', 1, 1240858481, 0, 1240862081, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.9) Gecko/2009040821 Firefox/3.0.9'),
('717314add99200e', 1, 1240858546, 0, 1240862146, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.9) Gecko/2009040821 Firefox/3.0.9'),
('406558447f5f501', 1, 1240858617, 0, 1240862217, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.9) Gecko/2009040821 Firefox/3.0.9'),
('b9f2b495441b35e', 1, 1240858621, 0, 1240862221, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.9) Gecko/2009040821 Firefox/3.0.9'),
('89d6840e77d8d86', 1, 1240916820, 1240916964, 1240920564, 'expired', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.9) Gecko/2009040821 Firefox/3.0.9'),
('8087469f1be45b7', 1, 1240916913, 0, 1240920513, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.9) Gecko/2009040821 Firefox/3.0.9'),
('40f7ffce800f697', 1, 1240916917, 0, 1240920517, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.9) Gecko/2009040821 Firefox/3.0.9'),
('eccbd86ba5eaa5d', 1, 1240916919, 0, 1240920519, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.9) Gecko/2009040821 Firefox/3.0.9'),
('b8a31211fc0410e', 1, 1240916921, 0, 1240920521, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.9) Gecko/2009040821 Firefox/3.0.9'),
('8315c259631ea98', 0, 1240927573, 0, 1240931173, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.10) Gecko/2009042316 Firefox/3.0.10'),
('1930ab4cd345e65', 1, 1240930851, 0, 1240934451, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.10) Gecko/2009042316 Firefox/3.0.10'),
('88c29364772e0af', 1, 1240930894, 0, 1240934494, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.10) Gecko/2009042316 Firefox/3.0.10'),
('7eff360c81d0755', 1, 1240930992, 0, 1240934592, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.10) Gecko/2009042316 Firefox/3.0.10'),
('cd1f4b84ee6f511', 1, 1240931000, 0, 1240934600, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.10) Gecko/2009042316 Firefox/3.0.10'),
('c9861582a9f0130', 1, 1240931077, 0, 1240934677, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.10) Gecko/2009042316 Firefox/3.0.10'),
('6ba1462d6b7a018', 1, 1240931089, 0, 1240934689, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.10) Gecko/2009042316 Firefox/3.0.10'),
('d02952f9e4587cf', 1, 1240931138, 0, 1240934738, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.10) Gecko/2009042316 Firefox/3.0.10'),
('717ae74dbe56e4d', 1, 1240931152, 0, 1240934752, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.10) Gecko/2009042316 Firefox/3.0.10'),
('b8c23323fe815b2', 1, 1240931235, 0, 1240934835, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.10) Gecko/2009042316 Firefox/3.0.10'),
('83fbd195dffd8d0', 1, 1240931297, 0, 1240934897, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.10) Gecko/2009042316 Firefox/3.0.10'),
('d639e9c8a37af33', 1, 1240931430, 0, 1240935030, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.10) Gecko/2009042316 Firefox/3.0.10'),
('c05f5e3aa05f2b8', 1, 1240931481, 0, 1240935081, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.10) Gecko/2009042316 Firefox/3.0.10'),
('434c7cb8ce98363', 1, 1240931585, 0, 1240935185, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.10) Gecko/2009042316 Firefox/3.0.10'),
('f489f2253d46954', 1, 1240931600, 0, 1240935200, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.10) Gecko/2009042316 Firefox/3.0.10'),
('10c8525fe6b7995', 1, 1240931867, 0, 1240935467, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.10) Gecko/2009042316 Firefox/3.0.10'),
('4266aff51db0cfa', 1, 1240931953, 0, 1240935553, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.10) Gecko/2009042316 Firefox/3.0.10'),
('61157a59a0c6c52', 1, 1240932644, 1240932935, 1240936535, 'expired', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.10) Gecko/2009042316 Firefox/3.0.10'),
('3ab185703a8195b', 1, 1240981679, 0, 1240985279, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.10) Gecko/2009042316 Firefox/3.0.10'),
('80deaf4ae2cb35d', 0, 1240993227, 0, 1240996827, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.10) Gecko/2009042316 Firefox/3.0.10'),
('e3cebe95e944bac', 0, 1240993240, 0, 1240996840, 'active', 'web', '62.64.115.254', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.10) Gecko/2009042316 Firefox/3.0.10'),
('cbbdbc4e0255e7a', 0, 1240993413, 0, 1240997013, 'active', 'web', '62.64.115.254', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.10) Gecko/2009042316 Firefox/3.0.10'),
('387f5d69859928d', 1, 1240993527, 1240993552, 1240997152, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.10) Gecko/2009042316 Firefox/3.0.10'),
('16114341d26143a', 0, 1240993705, 1240993708, 1240997308, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.10) Gecko/2009042316 Firefox/3.0.10'),
('5f4b74c3b57d9e3', 1, 1241000426, 1241023374, 1241026974, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.10) Gecko/2009042316 Firefox/3.0.10'),
('97fa9f8819542fc', 1, 1241007930, 1241008164, 1241011764, 'active', 'web', '62.64.115.254', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.10) Gecko/2009042316 Firefox/3.0.10'),
('ff71af0dd9035df', 1, 1241007990, 1241007995, 1241011595, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.10) Gecko/2009042316 Firefox/3.0.10'),
('66a432bf68acc26', 0, 1241008125, 0, 1241011725, 'active', 'web', '62.64.115.254', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.10) Gecko/2009042316 Firefox/3.0.10'),
('b6a483693ca7154', 1, 1241008274, 1241009184, 1241012784, 'active', 'web', '62.64.115.254', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.10) Gecko/2009042316 Firefox/3.0.10'),
('64b224853023510', 0, 1241008818, 1241008860, 1241012460, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.10) Gecko/2009042316 Firefox/3.0.10'),
('fd10ae38df689ee', 7, 1241009205, 1241009484, 1241013084, 'active', 'web', '62.64.115.254', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.10) Gecko/2009042316 Firefox/3.0.10'),
('6e22767e8895f9b', 0, 1241010855, 0, 1241014455, 'active', 'web', '62.64.115.254', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.10) Gecko/2009042316 Firefox/3.0.10'),
('307dd55c6ff15a2', 0, 1241010926, 0, 1241014526, 'active', 'web', '77.122.160.118', 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET CLR 2.0.50727; .NET CLR 3.0.04506.30; GreenBrowser)'),
('efefe53421926eb', 0, 1241011732, 0, 1241015332, 'active', 'web', '77.122.160.118', 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET CLR 2.0.50727; .NET CLR 3.0.04506.30; GreenBrowser)'),
('bd3701b4bf4c133', 1, 1241015693, 0, 1241019293, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.10) Gecko/2009042316 Firefox/3.0.10'),
('01e809ea45a4198', 0, 1241070236, 0, 1241073836, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.10) Gecko/2009042316 Firefox/3.0.10'),
('91c0ffdffa46e19', 1, 1241070247, 1241076681, 1241080281, 'expired', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.10) Gecko/2009042316 Firefox/3.0.10'),
('aeb04a5ada90dee', 0, 1241083038, 0, 1241086638, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.8) Gecko/2009032609 Firefox/3.0.8'),
('b9b3931811d7187', 1, 1241083043, 1241087866, 1241091466, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.8) Gecko/2009032609 Firefox/3.0.8'),
('584d56a323b1cb2', 8, 1241086111, 1241086131, 1241089731, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.8) Gecko/2009032609 Firefox/3.0.8'),
('3ac36d9d40387d2', 0, 1241086302, 0, 1241089902, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.8) Gecko/2009032609 Firefox/3.0.8'),
('23a685bfa0bf464', 0, 1241086305, 0, 1241089905, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.8) Gecko/2009032609 Firefox/3.0.8'),
('b90d3b827b27ea1', 1, 1241110335, 0, 1241113935, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.10) Gecko/2009042316 Firefox/3.0.10'),
('1f8020f90e5f681', 0, 1243252482, 0, 1243256082, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.10) Gecko/2009042316 Firefox/3.0.10'),
('2f5eb4d993804c8', 1, 1243252485, 1243256404, 1243260004, 'expired', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.10) Gecko/2009042316 Firefox/3.0.10'),
('c071d8f1aec893b', 0, 1243253633, 0, 1243257233, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.10) Gecko/2009042316 Firefox/3.0.10'),
('b8170b2aea932b0', 0, 1243254224, 0, 1243257824, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.10) Gecko/2009042316 Firefox/3.0.10'),
('bc9a5b58c9a4e1b', 0, 1243255189, 0, 1243258789, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.10) Gecko/2009042316 Firefox/3.0.10'),
('c82fb842dcda122', 0, 1243255194, 0, 1243258794, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.10) Gecko/2009042316 Firefox/3.0.10'),
('ee4e7835d89f62b', 1, 1243255376, 1243255619, 1243259219, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.10) Gecko/2009042316 Firefox/3.0.10'),
('6d74fcfb617fa3e', 0, 1243255603, 0, 1243259203, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.10) Gecko/2009042316 Firefox/3.0.10'),
('ee738f970be475d', 0, 1243264309, 0, 1243267909, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.10) Gecko/2009042316 Firefox/3.0.10'),
('095887d34001e5e', 0, 1243264354, 0, 1243267954, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.10) Gecko/2009042316 Firefox/3.0.10'),
('d58bd985c3fbdfb', 1, 1243264375, 1243266509, 1243270109, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.10) Gecko/2009042316 Firefox/3.0.10'),
('e252fdfa82a1b37', 0, 1243277526, 0, 1243281126, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.10) Gecko/2009042316 Firefox/3.0.10'),
('9129c94b8693749', 1, 1243277538, 1243277549, 1243281149, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.10) Gecko/2009042316 Firefox/3.0.10'),
('76c28fbf06cb9fe', 0, 1243586582, 0, 1243590182, 'active', 'web', '194.110.126.3', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.10) Gecko/2009042316 Firefox/3.0.10'),
('d3cc555f69a47c0', 1, 1243587133, 1243587316, 1243590916, 'active', 'web', '62.64.115.253', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.10) Gecko/2009042316 Firefox/3.0.10'),
('7499099af23db24', 0, 1244641069, 0, 1244644669, 'active', 'web', '62.64.115.254', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.10) Gecko/2009042316 Firefox/3.0.10'),
('86b10f60f7e8cfd', 0, 1244641106, 0, 1244644706, 'active', 'web', '93.74.243.53', 'Opera/9.60 (Windows NT 5.1; U; ru) Presto/2.1.1'),
('fc4e30d90074cb0', 0, 1244641247, 0, 1244644847, 'active', 'web', '93.74.243.53', 'Opera/9.60 (Windows NT 5.1; U; ru) Presto/2.1.1'),
('acc9e440e24a2ec', 0, 1244642235, 1244642272, 1244645872, 'active', 'web', '10.222.22.11', 'Mozilla/5.0 (X11; U; Linux i686; ru; rv:1.9.0.10) Gecko/2009060513 Gentoo Firefox/3.0.10 GTB5'),
('8365060e5626cc6', 1, 1245136356, 1245136474, 1245140074, 'active', 'web', '194.44.18.121', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.11) Gecko/2009060215 Firefox/3.0.11'),
('23333e4601fe636', 0, 1245136414, 0, 1245140014, 'active', 'web', '194.44.18.121', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.11) Gecko/2009060215 Firefox/3.0.11'),
('e72d572df53c333', 0, 1245136434, 0, 1245140034, 'active', 'web', '194.44.18.121', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.11) Gecko/2009060215 Firefox/3.0.11'),
('c101aa178f98126', 0, 1245136465, 0, 1245140065, 'active', 'web', '194.44.18.121', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.11) Gecko/2009060215 Firefox/3.0.11'),
('c587c14722b37aa', 0, 1246438086, 0, 1246441686, 'active', 'web', '62.64.115.254', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.11) Gecko/2009060215 Firefox/3.0.11'),
('f75b39180f6d8e2', 0, 1246448873, 1246448954, 1246452554, 'active', 'web', '217.27.159.40', 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; WebMoney Advisor; .NET CLR 1.1.4322; .NET CLR 2.0.50727)'),
('4776bf4f9a07dab', 0, 1246524651, 0, 1246528251, 'active', 'web', '217.27.159.40', 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; WebMoney Advisor; .NET CLR 1.1.4322; .NET CLR 2.0.50727)'),
('76c892e1d58ccc1', 0, 1246525444, 1246525752, 1246529352, 'active', 'web', '217.27.159.40', 'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10.5; uk; rv:1.9.0.11) Gecko/2009060214 Firefox/3.0.11 GTB5'),
('04dd653627c0cc5', 0, 1246542510, 0, 1246546110, 'active', 'web', '217.27.159.40', 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; WebMoney Advisor; .NET CLR 1.1.4322; .NET CLR 2.0.50727)'),
('1da6432e2b89722', 0, 1252764270, 0, 1252767870, 'active', 'web', '109.86.56.149', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.13) Gecko/2009073022 MRA 5.5 (build 02842) Firefox/3.0.13'),
('9f45636d9a9985f', 0, 1252764296, 0, 1252767896, 'active', 'web', '109.86.87.194', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.1.3) Gecko/20090824 Firefox/2.0.0.14;MEGAUPLOAD 1.0'),
('5b4e9482b01216e', 1, 1254918709, 1254918756, 1254922356, 'expired', 'web', '91.206.218.51', 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET CLR 1.1.4322; .NET CLR 2.0.50727; .NET CLR 3.0.04506.648; .NET CLR 3.5.21022; AskTB5.4)'),
('dc1f984e32f1baa', 0, 1254918919, 0, 1254922519, 'active', 'web', '62.64.115.253', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.14) Gecko/2009082707 Firefox/3.0.14'),
('e173aa79709c3dc', 0, 1256206609, 0, 1256210209, 'active', 'web', '62.64.115.253', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.0.14) Gecko/2009082707 Firefox/3.0.14'),
('ef302905441eedf', 0, 1256206653, 0, 1256210253, 'active', 'web', '62.80.179.107', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.1.3) Gecko/20090824 Firefox/3.5.3'),
('a70903e054b50d6', 0, 1256226236, 0, 1256229836, 'active', 'web', '62.80.179.107', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.1.3) Gecko/20090824 Firefox/3.5.3'),
('04b33c9cc4b4a55', 0, 1256281112, 0, 1256284712, 'active', 'web', '62.80.179.107', 'Mozilla/5.0 (Windows; U; Windows NT 5.1; ru; rv:1.9.1.3) Gecko/20090824 Firefox/3.5.3'),
('980030284dd9c90', 0, 1257180953, 0, 1257184553, 'active', 'web', '95.133.53.242', 'Mozilla/5.0 (Windows; U; Windows NT 6.0; ru; rv:1.9.1.4) Gecko/20091016 Firefox/3.5.4'),
('e1d47b82f472363', 0, 1263987624, 1263987663, 1263991263, 'active', 'web', '109.86.73.179', 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 5.1; Trident/4.0; Pivim Multibar; MRA 5.5 (build 02842); InfoPath.2)');

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
('6e8862dd4273426', 'is_logged', '1'),
('11dc0ae455d4a24', 'is_logged', '1'),
('ed0a6a4d83b80a2', 'is_logged', '1'),
('a613486cec76a18', 'is_logged', '1'),
('3920b2513022785', 'is_logged', '1'),
('05189c1030fb5c5', 'is_logged', '1'),
('a815d0f0bb497c9', 'is_logged', '1'),
('bc6aa325b8cf12b', 'is_logged', '1'),
('64790e069534428', 'is_logged', '1'),
('6f36d2fdee188ec', 'is_logged', '1'),
('c2de8d2a99d5fb7', 'is_logged', '1'),
('8bab5b22ffb7934', 'is_logged', '1'),
('7af9fabac4769bc', 'is_logged', '1'),
('39e618a898e53ac', 'is_logged', '1'),
('710018438c80eb3', 'is_logged', '1'),
('40cd679f8221c26', 'is_logged', '1'),
('7299caa0b3d4393', 'is_logged', '1'),
('3f00a878ab65c33', 'is_logged', '1'),
('879af72bd464d60', 'is_logged', '1'),
('538c9e3ed479ab6', 'is_logged', '1'),
('f5c440a21bdeb77', 'is_logged', '1'),
('c83bf44760f36fd', 'is_logged', '1'),
('379d02de67a9c84', 'is_logged', '1'),
('abf669c44c5270e', 'is_logged', '1'),
('029a1da0d46dc33', 'is_logged', '1'),
('c0fcf08d78c1caf', 'is_logged', '1'),
('005282c81478a76', 'is_logged', '1'),
('86279df9f8265fe', 'is_logged', '1'),
('d7a8e561c0f3ce7', 'is_logged', '1'),
('885d1bebc45a7f2', 'is_logged', '1'),
('b7391a914ddc64d', 'is_logged', '1'),
('57351a7fa45c0c6', 'is_logged', '1'),
('f26c829ec8f3681', 'is_logged', '1'),
('912cc95e4ecb6f9', 'is_logged', '1'),
('edea55ddefab739', 'is_logged', '1'),
('a7c51b22cf2d87a', 'is_logged', '1'),
('f618e06b31dadcf', 'is_logged', '1'),
('57ce5785f398e88', 'is_logged', '1'),
('0205d344ff546ea', 'is_logged', '1'),
('ee7cb842ff3c4a4', 'is_logged', '1'),
('7b292f82e418563', 'is_logged', '1'),
('a57148c559b0c4e', 'is_logged', '1'),
('006a2bf63d584b3', 'is_logged', '1'),
('00ecdeb09547416', 'is_logged', '1'),
('ea9fc34152257d3', 'is_logged', '1'),
('9569dabb7502c15', 'is_logged', '1'),
('a911d45221d8642', 'is_logged', '1'),
('ab338af56980e4c', 'login_bad_attempts', '1'),
('ab338af56980e4c', 'is_logged', '1'),
('e15b19c99f0cdee', 'is_logged', '1'),
('22beccbe71d2a6e', 'is_logged', '1'),
('2a605744580d664', 'is_logged', '1'),
('304db8491251541', 'is_logged', '1'),
('261bdc635366f3c', 'is_logged', '1'),
('bc1c542e7c3c58f', 'is_logged', '1'),
('5be4de4617830bb', 'is_logged', '1'),
('61aab9a702b9e70', 'is_logged', '1'),
('8a788a40250740c', 'is_logged', '1'),
('b564de5b39028dc', 'is_logged', '1'),
('145a519bfdeb577', 'is_logged', '1'),
('a5ecedb00889d6b', 'is_logged', '1'),
('bd2a3e37482ef8e', 'is_logged', '1'),
('a541ea19da2f3ff', 'is_logged', '1'),
('91a8e56b118537b', 'is_logged', '1'),
('e7d196120c6e418', 'is_logged', '1'),
('826805b84c715d0', 'is_logged', '1'),
('371d2adc9b5c8c8', 'is_logged', '1'),
('a6bbd457bea5923', 'is_logged', '1'),
('e879f53d8087b68', 'is_logged', '1'),
('57922a4849cf65e', 'is_logged', '1'),
('e81f7eae16f0fbf', 'is_logged', '1'),
('17c6b1d4e048763', 'is_logged', '1'),
('abe8c09209aa34f', 'is_logged', '1'),
('4261581ed4cc7da', 'is_logged', '1'),
('7e430412b9a9cdc', 'is_logged', '1'),
('e643ec62de67985', 'is_logged', '1'),
('424f55aea6c3663', 'is_logged', '1'),
('468abe9e37e1823', 'is_logged', '1'),
('b828ea227080d63', 'is_logged', '1'),
('8ce56c3a6a3a455', 'is_logged', '1'),
('698bf7ed7ac9e83', 'is_logged', '1'),
('52d6af9ca693683', 'is_logged', '1'),
('200e9b4b26ab7e5', 'is_logged', '1'),
('fd1eb28d539f972', 'is_logged', '1'),
('2d4e356978b43d5', 'is_logged', '1'),
('479df3b30a134eb', 'is_logged', '1'),
('69f41ee494b318a', 'is_logged', '1'),
('', 'is_logged', '1'),
('', 'login_bad_attempts', '7'),
('3045a8eb57fbcbb', 'is_logged', '1'),
('3045a8eb57fbcbb', 'login_bad_attempts', '1'),
('2c1b4b2cc7f7279', 'is_logged', '1'),
('2c1b4b2cc7f7279', 'login_bad_attempts', '1'),
('66444f3dcf72b26', 'is_logged', '1'),
('a452960facd269e', 'is_logged', '1'),
('6fcd27dba3d4fa7', 'is_logged', '1'),
('27da6465f56495a', 'is_logged', '1'),
('c475e881ac7ba3e', 'is_logged', '1'),
('cab334e8fb2d0d1', 'is_logged', '1'),
('6b7010d69806dc5', 'is_logged', '1'),
('b2ef18f8412dce4', 'is_logged', '1'),
('b39af0ae59a8ee8', 'is_logged', '1'),
('e76a543218358b3', 'is_logged', '1'),
('a25a71210dc30fc', 'is_logged', '1'),
('5a74ee750d8643c', 'is_logged', '1'),
('b9aea259c269b09', 'is_logged', '1'),
('0e8e4046e3100d3', 'is_logged', '1'),
('67a7fb7c5ca19e3', 'is_logged', '1'),
('28187ab7322616a', 'is_logged', '1'),
('05acb479ea6fc1f', 'is_logged', '1'),
('1f2e1236ac75c39', 'is_logged', '1'),
('99e50bb1fd46755', 'is_logged', '1'),
('e98fe3888171fa6', 'is_logged', '1'),
('4baa7a380344275', 'is_logged', '1'),
('619e594c5d23b07', 'is_logged', '1'),
('40535c611727cb1', 'is_logged', '1'),
('b74f945924aafa5', 'is_logged', '1'),
('cc85e8fb0710923', 'is_logged', '1'),
('c914968922df2a9', 'is_logged', '1'),
('9140b5623ffb8a5', 'is_logged', '1'),
('1dc3c8b9869867c', 'is_logged', '1'),
('457c774f9a5d19f', 'is_logged', '1'),
('59067d0d29498c6', 'is_logged', '1'),
('6ea13dbb8424dc0', 'is_logged', '1'),
('dec8e10d3e7a457', 'is_logged', '1'),
('2fc6fe4e06413ad', 'is_logged', '1'),
('33e7bb6b4a4316e', 'is_logged', '1'),
('9d685a5bccc9dca', 'is_logged', '1'),
('1125d73e789a41b', 'is_logged', '1'),
('d1dc87c32baa82e', 'is_logged', '1'),
('3663b29b83a344c', 'is_logged', '1'),
('4635474ccc9712f', 'is_logged', '1'),
('126ff44788e8c92', 'is_logged', '1'),
('a1a52d4751278c9', 'is_logged', '1'),
('489b3808574db75', 'is_logged', '1'),
('d04acf0f6b2bf89', 'is_logged', '1'),
('8e764b5697d4d3b', 'is_logged', '1'),
('83d49df7fe5f5ae', 'is_logged', '1'),
('0de20f4831cb119', 'is_logged', '1'),
('ef5f8301efb6d2f', 'is_logged', '1'),
('6d6ab7f4fcde205', 'is_logged', '1'),
('8ab9d066cc33e5e', 'is_logged', '1'),
('ae5373137ccf13a', 'is_logged', '1'),
('c0efe2f189b62bf', 'is_logged', '1'),
('7653d426f8f8b50', 'is_logged', '1'),
('2a8b29d1acd3bf9', 'is_logged', '1'),
('1e0eb6e09b8148e', 'is_logged', '1'),
('8dbf997c9e6ef9c', 'is_logged', '1'),
('cc45d2a2fa39f12', 'is_logged', '1'),
('34992d90b049c3e', 'is_logged', '1'),
('affae0e91186d28', 'is_logged', '1'),
('a8712aafec6d232', 'is_logged', '1'),
('26bcc59b52b0741', 'is_logged', '1'),
('68557c53177f277', 'is_logged', '1'),
('af896dbeda42276', 'is_logged', '1'),
('1d5ca5372e546ec', 'is_logged', '1'),
('043a7044daacb13', 'is_logged', '1'),
('70b42c6e43d58bb', 'is_logged', '1'),
('3a5acab186973c5', 'is_logged', '1'),
('0d6547019a56914', 'is_logged', '1'),
('4c0fb4fc29f6ebf', 'is_logged', '1'),
('a5bb7f1c8b47724', 'is_logged', '1'),
('666cd2d967fa26d', 'is_logged', '1'),
('6d1b352b4f67c11', 'is_logged', '1'),
('f7fcc62c7f63c3b', 'is_logged', '1'),
('9193f0862fd6b3d', 'is_logged', '1'),
('9193f0862fd6b3d', 'login_bad_attempts', '1'),
('d5665d378fd756c', 'is_logged', '1'),
('dcb098db4e89c22', 'is_logged', '1'),
('01813ccab35033a', 'is_logged', '1'),
('ab4e70df8d833b8', 'is_logged', '1'),
('5d4801a4530b4ba', 'is_logged', '1'),
('ed33ae82cacf9a2', 'is_logged', '1'),
('f70873c5314ed49', 'is_logged', '1'),
('846a7f770ca708d', 'is_logged', '1'),
('00bb3af509e78e1', 'is_logged', '1'),
('7a70c59ea823321', 'is_logged', '1'),
('962813260aeaa64', 'is_logged', '1'),
('c8f4b7e1a3ed4fd', 'is_logged', '1'),
('958e7ef37d41fef', 'is_logged', '1'),
('4b07a715e44ef57', 'is_logged', '1'),
('ae361b69c9af7fe', 'is_logged', '1'),
('ee9f6be61c7e05d', 'is_logged', '1'),
('9a44b4bfe1d4a52', 'is_logged', '1'),
('dc9ae90339c2edb', 'is_logged', '1'),
('f62a8b1ad2d560f', 'is_logged', '1'),
('825bc9338c88a79', 'is_logged', '1'),
('c325763978aa09b', 'is_logged', '1'),
('a5402b8dab92102', 'is_logged', '1'),
('6c6c954d1fb77b9', 'is_logged', '1'),
('cfa27644b68837a', 'is_logged', '1'),
('c4eb53857e38d79', 'is_logged', '1'),
('ea16d442b12bc01', 'is_logged', '1'),
('489d64caceb9d17', 'login_bad_attempts', '1'),
('62bd1d1d0a32896', 'is_logged', '1'),
('62bd1d1d0a32896', 'login_bad_attempts', '1'),
('2f17bfd84d4e498', 'is_logged', '1'),
('d4e35599531ebdf', 'is_logged', '1'),
('f399eb828ceb01e', 'is_logged', '1'),
('77f28747d4fdcf5', 'is_logged', '1'),
('9fa87c0c3055ec2', 'is_logged', '1'),
('178ac1c4ec4bfec', 'is_logged', '1'),
('2693fcb1d46bc9a', 'is_logged', '1'),
('e8aefc04416defc', 'is_logged', '1'),
('107a61b18c43483', 'is_logged', '1'),
('56fcac753e4a942', 'is_logged', '1'),
('45f7ac9d50ff795', 'is_logged', '1'),
('c374a8e9519146e', 'is_logged', '1'),
('629210ad937a1fa', 'is_logged', '1'),
('d9c523092c80cf5', 'is_logged', '1'),
('b42b119e4e0766c', 'is_logged', '1'),
('7dd4dcf8950914f', 'is_logged', '1'),
('fc4340c0dcee9db', 'is_logged', '1'),
('97a3b25490dc092', 'is_logged', '1'),
('b698688fd5b2e44', 'is_logged', '1'),
('86b09e9a7a3e1f1', 'is_logged', '1'),
('a1420299ff9a819', 'is_logged', '1'),
('db55e179105fcb8', 'is_logged', '1'),
('62d0be2db5c78a8', 'is_logged', '1'),
('e40e1841ac9f308', 'is_logged', '1'),
('0d5d0e626e2f9d4', 'is_logged', '1'),
('11c003aaab5746e', 'is_logged', '1'),
('cfd55b6e7830f5f', 'is_logged', '1'),
('b1a28d521191705', 'is_logged', '1'),
('c09deb99dbc42d9', 'is_logged', '1'),
('ec3f65d671de564', 'is_logged', '1'),
('b351eee96af6196', 'is_logged', '1'),
('5e06f4658894876', 'is_logged', '1'),
('a7f692652ae5616', 'is_logged', '1'),
('7b6b59e436e798e', 'is_logged', '1'),
('194306a47815d7c', 'is_logged', '1'),
('4e4834abc1b16de', 'is_logged', '1'),
('6d9688379acdfeb', 'is_logged', '1'),
('0e7354c63ade6ff', 'is_logged', '1'),
('d503ce6843c6584', 'is_logged', '1'),
('abe1a622ecb4b9a', 'is_logged', '1'),
('015b8db029ebef6', 'is_logged', '1'),
('befa6122a706e8b', 'is_logged', '1'),
('c9e50910292de5d', 'is_logged', '1'),
('8b7fe33bf27b17f', 'is_logged', '1'),
('c5f3a31d314ffe1', 'is_logged', '1'),
('38d897035ec0114', 'is_logged', '1'),
('022c405dc5f718d', 'is_logged', '1'),
('625a3bbf366f271', 'is_logged', '1'),
('6632997e8ae2552', 'is_logged', '1'),
('c53ab000fb72187', 'is_logged', '1'),
('42316eaeed0f05e', 'is_logged', '1'),
('0dea827e33d0146', 'is_logged', '1'),
('24014adb8e45d99', 'is_logged', '1'),
('9256408c759ba3f', 'is_logged', '1'),
('dd47b7d3fa72bcc', 'is_logged', '1'),
('f574def60badcbf', 'is_logged', '1'),
('6d5740f27f46d64', 'is_logged', '1'),
('7d5be38db0e65b3', 'is_logged', '1'),
('1fb05d06721539e', 'is_logged', '1'),
('118754db4e7ce9a', 'is_logged', '1'),
('d581d2b77be351f', 'is_logged', '1'),
('d581d2b77be351f', 'login_bad_attempts', '1'),
('3f23798980e515f', 'is_logged', '1'),
('35b98d4f5cf65f7', 'is_logged', '1'),
('6bc11b44d2012e9', 'is_logged', '1'),
('b2958869e38cca2', 'is_logged', '1'),
('717314add99200e', 'is_logged', '1'),
('406558447f5f501', 'is_logged', '1'),
('b9f2b495441b35e', 'is_logged', '1'),
('89d6840e77d8d86', 'is_logged', '1'),
('89d6840e77d8d86', 'login_bad_attempts', '1'),
('8087469f1be45b7', 'is_logged', '1'),
('40f7ffce800f697', 'is_logged', '1'),
('eccbd86ba5eaa5d', 'is_logged', '1'),
('b8a31211fc0410e', 'is_logged', '1'),
('1930ab4cd345e65', 'is_logged', '1'),
('88c29364772e0af', 'is_logged', '1'),
('7eff360c81d0755', 'is_logged', '1'),
('cd1f4b84ee6f511', 'is_logged', '1'),
('c9861582a9f0130', 'is_logged', '1'),
('6ba1462d6b7a018', 'is_logged', '1'),
('d02952f9e4587cf', 'is_logged', '1'),
('717ae74dbe56e4d', 'is_logged', '1'),
('b8c23323fe815b2', 'is_logged', '1'),
('83fbd195dffd8d0', 'is_logged', '1'),
('d639e9c8a37af33', 'is_logged', '1'),
('c05f5e3aa05f2b8', 'is_logged', '1'),
('434c7cb8ce98363', 'is_logged', '1'),
('f489f2253d46954', 'is_logged', '1'),
('10c8525fe6b7995', 'is_logged', '1'),
('4266aff51db0cfa', 'is_logged', '1'),
('61157a59a0c6c52', 'is_logged', '1'),
('3ab185703a8195b', 'is_logged', '1'),
('387f5d69859928d', 'is_logged', '1'),
('5f4b74c3b57d9e3', 'is_logged', '1'),
('97fa9f8819542fc', 'is_logged', '1'),
('97fa9f8819542fc', 'login_bad_attempts', '1'),
('ff71af0dd9035df', 'is_logged', '1'),
('b6a483693ca7154', 'is_logged', '1'),
('fd10ae38df689ee', 'is_logged', '1'),
('bd3701b4bf4c133', 'is_logged', '1'),
('91c0ffdffa46e19', 'is_logged', '1'),
('b9b3931811d7187', 'is_logged', '1'),
('b9b3931811d7187', 'login_bad_attempts', '1'),
('584d56a323b1cb2', 'is_logged', '1'),
('b90d3b827b27ea1', 'is_logged', '1'),
('2f5eb4d993804c8', 'is_logged', '1'),
('2f5eb4d993804c8', 'login_bad_attempts', '1'),
('ee4e7835d89f62b', 'is_logged', '1'),
('d58bd985c3fbdfb', 'is_logged', '1'),
('d58bd985c3fbdfb', 'login_bad_attempts', '1'),
('9129c94b8693749', 'is_logged', '1'),
('9129c94b8693749', 'login_bad_attempts', '1'),
('d3cc555f69a47c0', 'is_logged', '1'),
('8365060e5626cc6', 'is_logged', '1'),
('5b4e9482b01216e', 'is_logged', '1');

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

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`user_id`, `login`, `password`, `email`, `type`, `state`, `is_autologin`, `createdTime`, `lastEnterTime`) VALUES
(1, 'nvvetal', '827ccb0eea8a706c4c34a16891f84e7b', 'nvvetal@rambler.ru', 'vip_user', 'active', 1, 0, 1198312361),
(7, 'Magdalena', '827ccb0eea8a706c4c34a16891f84e7b', 'khalisy@mail.ru', 'user', 'active', 0, 1241009275, 1241009275);

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

--
-- Дамп данных таблицы `users_data`
--

INSERT INTO `users_data` (`user_id`, `u_param`, `u_value`) VALUES
(1, 'p_sex', 'male'),
(1, 'p_first_name', 'Виталий'),
(1, 'p_last_name', 'Гринчишин'),
(1, 'p_from_location', 'Житомир'),
(1, 'p_birthday', '1983-03-03'),
(1, 'p_profession', 'программист'),
(1, 'p_hobby', 'Карточные игры'),
(1, 'p_url', 'zhitomirhost.com'),
(1, 'p_icq', '511723'),
(1, 'p_skype', 'nvvetal'),
(1, 'cookie_session', '5b4e9482b01216e'),
(1, 'cookie_session_key', 'f94fa4e93f2dc490e2842b0eed3791c4'),
(1, 'cookie_session_time', '12549187321052866801'),
(1, 'image_id', '15'),
(1, 'admin_partner_links', '1'),
(1, 'admin_schools', '1'),
(0, 'p_sex', 'male'),
(0, 'p_first_name', 'Виталий1'),
(0, 'p_last_name', 'Гринчишин1'),
(0, 'p_from_location', 'Житомир'),
(0, 'p_birthday', '2007-12-23'),
(0, 'p_profession', 'программист'),
(0, 'p_hobby', 'Карточные игры'),
(0, 'p_url', 'zhitomirhost.com'),
(0, 'p_icq', '511723'),
(0, 'p_skype', 'nvvetal'),
(7, 'p_first_name', ''),
(7, 'p_url', ''),
(7, 'p_from_location', ''),
(7, 'p_hobby', ''),
(7, 'p_icq', ''),
(7, 'p_last_name', ''),
(7, 'p_profession', ''),
(7, 'image_id', '33'),
(7, 'p_birthday', '1900-05-25'),
(7, 'p_sex', 'unknown'),
(7, 'p_skype', ''),
(7, 'forum', '');