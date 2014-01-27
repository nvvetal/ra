CREATE TABLE `rakscom`.`raks_history` (
`id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`user_id` INT NOT NULL ,
`rule` VARCHAR( 255 ) NOT NULL ,
`amount` SMALLINT NOT NULL
) ENGINE = MYISAM ;
ALTER TABLE `raks_history` ADD `time_action` INT( 11 ) NOT NULL ;