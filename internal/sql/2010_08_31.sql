-- phpMyAdmin SQL Dump
-- version 2.11.7
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Авг 31 2010 г., 09:55
-- Версия сервера: 5.0.51
-- Версия PHP: 5.2.6

--
-- База данных: `rakscom`
--

-- --------------------------------------------------------

--
-- Структура таблицы `i18n_calendar`
--

CREATE TABLE IF NOT EXISTS `i18n_calendar` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `lang` char(3) NOT NULL,
  `name` varchar(255) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `i18n_default`
--

CREATE TABLE IF NOT EXISTS `i18n_default` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `lang` char(3) NOT NULL,
  `name` varchar(255) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM  AUTO_INCREMENT=12 ;

-- --------------------------------------------------------

--
-- Структура таблицы `i18n_forum`
--

CREATE TABLE IF NOT EXISTS `i18n_forum` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `lang` char(3) NOT NULL,
  `name` varchar(255) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `i18n_schools`
--

CREATE TABLE IF NOT EXISTS `i18n_schools` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `lang` char(3) NOT NULL,
  `name` varchar(255) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM  AUTO_INCREMENT=12 ;
