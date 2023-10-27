ALTER TABLE `sunlight_user_activation`
    CHANGE COLUMN `code` `code` VARCHAR(48) COLLATE utf8mb4_unicode_ci NOT NULL,
    CHANGE COLUMN `expire` `expire` BIGINT(20) NOT NULL,
    ADD COLUMN `data` BLOB NOT NULL,
    DROP COLUMN `group`,
    DROP COLUMN `username`,
    DROP COLUMN `password`,
    DROP COLUMN `salt`,
    DROP COLUMN `massemail`,
    DROP COLUMN `ip`,
    DROP COLUMN `email`;

