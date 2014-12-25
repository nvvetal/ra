CREATE TABLE IF NOT EXISTS `advertise_splash` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `beginDate` date NOT NULL,
  `endDate` date NOT NULL,
  `enabled` enum('N','Y') NOT NULL DEFAULT 'N',
  `created` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE  `advertise_splash` CHANGE  `enabled`  `is_enabled` ENUM(  'N',  'Y' ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT  'N';
ALTER TABLE  `advertise_splash` CHANGE  `created`  `created_time` INT( 11 ) NOT NULL ;