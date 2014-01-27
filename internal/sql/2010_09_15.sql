ALTER TABLE `calendar` ADD `is_deleted` TINYINT NOT NULL DEFAULT '0';
ALTER TABLE `calendar_categories` ADD `is_deleted` TINYINT NOT NULL DEFAULT '0';