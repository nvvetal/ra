-- phpMyAdmin SQL Dump
-- version 2.11.7
-- http://www.phpmyadmin.net
--
-- ����: localhost
-- ����� ��������: ��� 24 2011 �., 09:41
-- ������ �������: 5.0.51
-- ������ PHP: 5.2.6

--
-- ���� ������: `rakscom`
--

-- --------------------------------------------------------

--
-- ��������� ������� `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `itemId` bigint(20) unsigned NOT NULL,
  `itemType` enum('photo') NOT NULL,
  `comment` longtext NOT NULL,
  `timeCreated` int(11) NOT NULL,
  `timeApproved` int(11) NOT NULL,
  `approvedBy` int(11) NOT NULL,
  `createdBy` int(11) NOT NULL,
  `isApproved` enum('Y','N') NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=InnoDB  AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- ��������� ������� `rates`
--

DROP TABLE IF EXISTS `rates`;
CREATE TABLE IF NOT EXISTS `rates` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `rateToId` bigint(20) unsigned NOT NULL,
  `rateToType` enum('photo') NOT NULL,
  `rateFromId` int(11) NOT NULL,
  `rateFromType` enum('user','system') NOT NULL,
  `ratePoints` smallint(5) unsigned NOT NULL,
  `rateTime` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `rateToId` (`rateToId`,`rateToType`,`rateTime`,`ratePoints`)
) TYPE=MyISAM  AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- ��������� ������� `rates_agr`
--

DROP TABLE IF EXISTS `rates_agr`;
CREATE TABLE IF NOT EXISTS `rates_agr` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `rateToId` bigint(20) unsigned NOT NULL,
  `rateToType` enum('photo') NOT NULL,
  `rateCnt` int(11) NOT NULL,
  `ratePoints` bigint(20) unsigned NOT NULL,
  `rateAvg` float unsigned NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `rateToId` (`rateToId`,`rateToType`,`ratePoints`,`rateAvg`)
) TYPE=MyISAM  AUTO_INCREMENT=3 ;
