-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- ����: localhost
-- ����� ��������: ��� 21 2011 �., 18:25
-- ������ �������: 5.1.41
-- ������ PHP: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- ���� ������: `rakscom`
--

-- --------------------------------------------------------

--
-- ��������� ������� `rates`
--

CREATE TABLE IF NOT EXISTS `rates` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `rateToId` bigint(20) unsigned NOT NULL,
  `rateToType` enum('photo') NOT NULL,
  `rateFromId` int(11) NOT NULL,
  `rateFromType` enum('user','system') NOT NULL,
  `rateTime` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `rateToId` (`rateToId`,`rateToType`,`rateTime`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- ���� ������ ������� `rates`
--


-- --------------------------------------------------------

--
-- ��������� ������� `rates_agr`
--

CREATE TABLE IF NOT EXISTS `rates_agr` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `rateToId` bigint(20) unsigned NOT NULL,
  `rateToType` enum('photo') NOT NULL,
  `rateCnt` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `rateToId` (`rateToId`,`rateToType`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- ���� ������ ������� `rates_agr`
--

