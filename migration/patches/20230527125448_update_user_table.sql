ALTER TABLE `sunlight_user`
    CHANGE `group` `group_id` int(11) NOT NULL;

ALTER TABLE `sunlight_user`
    CHANGE COLUMN `levelshift` `levelshift` TINYINT(1) NOT NULL DEFAULT 0,
    CHANGE COLUMN `username` `username` VARCHAR(24) COLLATE utf8mb4_unicode_ci NOT NULL,
    CHANGE COLUMN `publicname` `publicname` VARCHAR(24) COLLATE utf8mb4_unicode_ci NULL,
    CHANGE COLUMN `password` `password` VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    CHANGE COLUMN `logincounter` `logincounter` INT(11) NOT NULL DEFAULT 0,
    CHANGE COLUMN `registertime` `registertime` BIGINT(20) NOT NULL DEFAULT 0,
    CHANGE COLUMN `activitytime` `activitytime` BIGINT(20) NOT NULL DEFAULT 0,
    CHANGE COLUMN `blocked` `blocked` TINYINT(1) NOT NULL DEFAULT 0,
    CHANGE COLUMN `massemail` `massemail` TINYINT(1) NOT NULL DEFAULT 0,
    CHANGE COLUMN `wysiwyg` `wysiwyg` TINYINT(1) NOT NULL DEFAULT 0,
    ADD COLUMN `public` TINYINT(1) NOT NULL DEFAULT 1 AFTER `wysiwyg`,
    CHANGE COLUMN `language` `language` VARCHAR(12) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
    CHANGE COLUMN `ip` `ip` VARCHAR(45) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
    CHANGE COLUMN `email` `email` VARCHAR(191) COLLATE utf8mb4_unicode_ci NOT NULL,
    CHANGE COLUMN `avatar` `avatar` VARCHAR(32) COLLATE utf8mb4_unicode_ci NULL,
    CHANGE COLUMN `note` `note` TEXT COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
    DROP COLUMN `avatar_mode`,
    DROP COLUMN `web`,
    DROP COLUMN `skype`,
    DROP COLUMN `msn`,
    DROP COLUMN `icq`,
    DROP COLUMN `jabber`;

ALTER TABLE `sunlight_user`
    DROP INDEX `username`,
    DROP INDEX `publicname`,
    DROP INDEX `email`;
