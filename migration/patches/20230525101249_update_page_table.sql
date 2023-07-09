ALTER TABLE `sunlight_page`
    CHANGE COLUMN `title_seo` `slug` VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    CHANGE COLUMN `intersectionperex` `perex` TEXT COLLATE utf8mb4_unicode_ci NOT NULL,
    CHANGE COLUMN `autotitle` `show_heading` TINYINT(1) NOT NULL DEFAULT 1,
    CHANGE COLUMN `intersection` `node_parent` INT(11) NULL;

ALTER TABLE `sunlight_page`
    CHANGE COLUMN `title` `title` VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    ADD COLUMN `heading` VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' AFTER `title`,
    ADD COLUMN `slug_abs` TINYINT(1) NOT NULL DEFAULT 0 AFTER `slug`,
    CHANGE COLUMN `description` `description` VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
    ADD COLUMN `node_level` INT(11) NOT NULL DEFAULT 0 AFTER `node_parent`,
    ADD COLUMN `node_depth` INT(11) NOT NULL DEFAULT 0 AFTER `node_level`,
    CHANGE COLUMN `ord` `ord` INT(11) NOT NULL DEFAULT 0,
    CHANGE COLUMN `content` `content` MEDIUMTEXT COLLATE utf8mb4_unicode_ci NOT NULL,
    CHANGE COLUMN `visible` `visible` TINYINT(1) NOT NULL DEFAULT 1,
    CHANGE COLUMN `public` `public` TINYINT(1) NOT NULL DEFAULT 1,
    ADD COLUMN `level_inherit` TINYINT(1) NOT NULL DEFAULT 0 AFTER `level`,
    CHANGE COLUMN `events` `events` VARCHAR(255) COLLATE utf8mb4_unicode_ci NULL,
    ADD COLUMN `link_new_window` TINYINT(1) NOT NULL DEFAULT 0 AFTER `events`,
    ADD COLUMN `link_url` VARCHAR(255) COLLATE utf8mb4_unicode_ci NULL AFTER `link_new_window`,
    ADD COLUMN `layout` VARCHAR(255) COLLATE utf8mb4_unicode_ci NULL AFTER `link_url`,
    ADD COLUMN `layout_inherit` TINYINT(1) NOT NULL DEFAULT 0 AFTER `layout`,
    CHANGE COLUMN `var1` `var1` INT(11) NULL,
    CHANGE COLUMN `var2` `var2` INT(11) NULL,
    CHANGE COLUMN `var3` `var3` INT(11) NULL,
    CHANGE COLUMN `var4` `var4` INT(11) NULL,
    DROP COLUMN `keywords`;

ALTER TABLE `sunlight_page`
    DROP INDEX `title_seo`,
    DROP INDEX `autotitle`,
    DROP INDEX `intersection`,
    ADD KEY (`show_heading`),
    ADD KEY (`slug_abs`),
    ADD KEY (`slug_seo`),
    ADD KEY (`node_parent`);
