ALTER TABLE `sunlight_shoutbox`
    CHANGE COLUMN `title` `title` VARCHAR(64) COLLATE utf8mb4_unicode_ci NOT NULL,
    CHANGE COLUMN `locked` `locked` TINYINT(1) NOT NULL DEFAULT 0,
    CHANGE COLUMN `public` `public` TINYINT(1) NOT NULL DEFAULT 1;

