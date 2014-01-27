-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Фев 22 2012 г., 09:30
-- Версия сервера: 5.5.16
-- Версия PHP: 5.3.8

SET time_zone = "+00:00";

--
-- База данных: `rakscom`
--

-- --------------------------------------------------------

--
-- Структура таблицы `shop_items`
--

CREATE TABLE IF NOT EXISTS `shop_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '',
  `image_id` int(11) NOT NULL,
  `price` smallint(5) unsigned NOT NULL DEFAULT '0',
  `is_enabled` enum('N','Y') NOT NULL DEFAULT 'N',
  `is_deleted` enum('N','Y') NOT NULL DEFAULT 'N',
  PRIMARY KEY (`id`)
) TYPE=InnoDB  AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `shop_items`
--

INSERT INTO `shop_items` (`id`, `category_id`, `name`, `image_id`, `price`, `is_enabled`, `is_deleted`) VALUES
(1, 1, 'zzzz', 0, 1, 'N', 'N');

-- --------------------------------------------------------

--
-- Структура таблицы `shop_shops`
--

CREATE TABLE IF NOT EXISTS `shop_shops` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `image_id` int(32) NOT NULL,
  `is_system` enum('N','Y') NOT NULL DEFAULT 'N',
  `is_enabled` enum('N','Y') NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`id`)
) TYPE=InnoDB  AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `shop_shops`
--

INSERT INTO `shop_shops` (`id`, `name`, `description`, `user_id`, `image_id`, `is_system`, `is_enabled`) VALUES
(1, 'zzz', 'dfz fgdf gdfsg fdsgfsd gfds gfdsg fgdfsg fdsgdfg', 1, 0, 'N', 'Y'),
(2, 'aaa', '', 5, 0, 'N', 'Y');
