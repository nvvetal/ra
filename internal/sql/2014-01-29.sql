ALTER TABLE  `images` CHANGE  `owner_type`  `owner_type` ENUM(  'unknown',  'user',  'school',  'article_section',  'shop' ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT  'unknown';
