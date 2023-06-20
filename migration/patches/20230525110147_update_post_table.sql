ALTER TABLE `sunlight_post`
    CHANGE COLUMN `xhome` `xhome` INT(11) NOT NULL DEFAULT -1,
    CHANGE COLUMN `subject` `subject` VARCHAR(48) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
    CHANGE COLUMN `text` `text` MEDIUMTEXT COLLATE utf8mb4_unicode_ci NOT NULL,
    CHANGE COLUMN `author` `author` INT(11) NOT NULL DEFAULT -1,
    CHANGE COLUMN `guest` `guest` VARCHAR(24) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
    CHANGE COLUMN `time` `time` BIGINT(20) NOT NULL,
    CHANGE COLUMN `ip` `ip` VARCHAR(45) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
    CHANGE COLUMN `bumptime` `bumptime` BIGINT(20) NOT NULL DEFAULT 0;
