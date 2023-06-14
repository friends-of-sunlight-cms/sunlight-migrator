ALTER TABLE `sunlight_poll`
    CHANGE COLUMN `question` `question` VARCHAR(96) COLLATE utf8mb4_unicode_ci NOT NULL,
    CHANGE COLUMN `answers` `answers` MEDIUMTEXT COLLATE utf8mb4_unicode_ci NOT NULL,
    CHANGE COLUMN `locked` `locked` TINYINT(1) NOT NULL DEFAULT 0,
    CHANGE COLUMN `votes` `votes` VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL;

