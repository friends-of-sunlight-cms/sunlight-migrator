ALTER TABLE `sunlight_iplog`
    CHANGE COLUMN `ip` `ip` VARCHAR(45) COLLATE utf8mb4_unicode_ci NOT NULL,
    CHANGE COLUMN `type` `type` INT(11) NOT NULL,
    CHANGE COLUMN `time` `time` BIGINT(20) NOT NULL,
    CHANGE COLUMN `var` `var` INT(11) NOT NULL DEFAULT 0;

