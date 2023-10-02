ALTER TABLE `sunlight_setting`
    CHANGE COLUMN `var` `var` VARCHAR(24) COLLATE utf8mb4_unicode_ci NOT NULL,
    CHANGE COLUMN `val` `val` MEDIUMTEXT COLLATE utf8mb4_unicode_ci NOT NULL,
    ADD COLUMN `preload` TINYINT(1) NOT NULL DEFAULT 0,
    ADD COLUMN `web` TINYINT(1) NOT NULL,
    ADD COLUMN `admin` TINYINT(1) NOT NULL;
