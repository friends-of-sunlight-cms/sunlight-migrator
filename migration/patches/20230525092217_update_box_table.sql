ALTER TABLE `sunlight_box`
    CHANGE COLUMN `column` `slot` VARCHAR(64) COLLATE utf8mb4_unicode_ci NOT NULL;

ALTER TABLE `sunlight_box`
    CHANGE COLUMN `ord` `ord` INT(11) NOT NULL DEFAULT 0,
    CHANGE COLUMN `title` `title` VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
    CHANGE COLUMN `content` `content` MEDIUMTEXT COLLATE utf8mb4_unicode_ci NOT NULL,
    CHANGE COLUMN `visible` `visible` TINYINT(1) NOT NULL DEFAULT 1,
    CHANGE COLUMN `public` `public` TINYINT(1) NOT NULL DEFAULT 1,
    ADD COLUMN `level` INT(11) NOT NULL DEFAULT 0 AFTER `public`,
    ADD COLUMN `template` VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL AFTER `level`,
    ADD COLUMN `layout` VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL AFTER `template`,
    ADD COLUMN `page_ids` TEXT COLLATE utf8mb4_unicode_ci NULL AFTER `slot`,
    ADD COLUMN `page_children` TINYINT(1) NOT NULL DEFAULT 0 AFTER `page_ids`,
    CHANGE COLUMN `class` `class` VARCHAR(255) COLLATE utf8mb4_unicode_ci NULL;
