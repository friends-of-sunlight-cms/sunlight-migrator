ALTER TABLE `sunlight_redirect`
    CHANGE COLUMN `old` `old` VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    CHANGE COLUMN `new` `new` VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    ADD COLUMN `permanent` TINYINT(1) NOT NULL DEFAULT 0 AFTER `new`;

ALTER TABLE `sunlight_redirect`
    DROP INDEX `old`,
    ADD KEY (`old`),
    ADD KEY (`permanent`);

