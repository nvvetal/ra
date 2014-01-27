CREATE TABLE IF NOT EXISTS `articles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `section_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `content_short` text NOT NULL,
  `content` text NOT NULL,
  `owner_id` int(11) NOT NULL,
  `is_enabled` enum('Y','N') NOT NULL DEFAULT 'N',
  PRIMARY KEY (`id`)
);

CREATE TABLE IF NOT EXISTS `article_sections` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `image_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `image_id` (`image_id`)
);
ALTER TABLE  `rates` CHANGE  `rateToType`  `rateToType` ENUM(  'photo',  'video',  'article' ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT  'photo';
ALTER TABLE  `rates_agr` CHANGE  `rateToType`  `rateToType` ENUM(  'photo',  'video',  'article' ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT  'photo';
ALTER TABLE  `comments` CHANGE  `itemType`  `itemType` ENUM(  'photo',  'video',  'article' ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'photo';
ALTER TABLE  `articles` ADD  `created_time` INT NOT NULL AFTER  `owner_id`;
ALTER TABLE  `articles` ADD  `approved_time` INT NOT NULL AFTER  `created_time`;
ALTER TABLE  `images` CHANGE  `owner_type`  `owner_type` ENUM(  'unknown',  'user',  'school',  'article_section' ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT  'unknown';
CREATE TABLE IF NOT EXISTS `i18n_article` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `lang` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `value` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
);
ALTER TABLE  `comments` ADD  `pItemId` INT UNSIGNED NOT NULL AFTER  `id`;
ALTER TABLE  `articles` ADD  `reason` TEXT NOT NULL AFTER  `approved_time` ;
ALTER TABLE  `articles` ADD  `approve_cnt` INT NOT NULL AFTER  `reason` ;