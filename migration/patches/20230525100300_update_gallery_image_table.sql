ALTER TABLE `sunlight_gallery_image`
    CHANGE COLUMN `ord` `ord` INT(11) NOT NULL DEFAULT 0,
    CHANGE COLUMN `title` `title` VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
    CHANGE COLUMN `prev` `prev` VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
    CHANGE COLUMN `full` `full` VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '';

ALTER TABLE `sunlight_gallery_image`
    DROP INDEX `full`,
    ADD KEY (`full`),
