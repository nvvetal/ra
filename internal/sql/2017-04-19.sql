ALTER TABLE `users` ADD `facebook_id` VARCHAR(255) NULL AFTER `email`, ADD UNIQUE `idx_facebook` (`facebook_id`);

DELETE FROM users_data WHERE user_id IN  (SELECT user_id FROM (SELECT ud.user_id FROM users_data as ud LEFT JOIN users as u ON u.user_id = ud.user_id WHERE u.user_id IS NULL) as uu);

ALTER TABLE `users_data` ADD CONSTRAINT `FK_USERS` FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`) ON DELETE CASCADE;

ALTER TABLE `users` CHANGE `email` `email` VARCHAR(1024) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL;

UPDATE `users` SET email = 'izotova-2003@yandex.ru' WHERE user_id = 38765 LIMIT 1;
UPDATE `users` SET email = 'sonamona_2000@yahoo.com' WHERE user_id = 45030 LIMIT 1;
UPDATE `users` SET email = 'broker-e@mail.ru' WHERE user_id = 45797 LIMIT 1;
UPDATE `users` SET email = 'bogdanovich2033@bk.ru' WHERE user_id = 45578 LIMIT 1;
UPDATE `users` SET email = '176@ua.fm' WHERE user_id = 40015 LIMIT 1;
UPDATE `users` SET email = 'ulya_bashtovenko@list.ru' WHERE user_id = 39278 LIMIT 1;

ALTER TABLE `users` ADD UNIQUE `idx_email` (`email`);

ALTER TABLE `users` CHANGE `login` `login` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '';

UPDATE `users` SET login = 'anastasiya.polickarpova' WHERE user_id = 45511 LIMIT 1;
UPDATE `users` SET login = 'anastasiya.polickarpova258' WHERE user_id = 45512 LIMIT 1;
UPDATE `users` SET login = 'family-circus@inbox.com' WHERE user_id = 44849 LIMIT 1;

ALTER TABLE `users` DROP INDEX `login`, ADD UNIQUE `idx_login` (`login`) USING BTREE;


