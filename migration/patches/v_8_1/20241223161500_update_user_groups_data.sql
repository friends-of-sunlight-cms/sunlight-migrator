ALTER TABLE `sunlight_user_group`
    ADD COLUMN `rawhtml` TINYINT(1) NOT NULL DEFAULT 0 AFTER `selfremove`;

UPDATE `sunlight_user_group` SET `rawhtml` = 1 WHERE `id` = 1;
