ALTER TABLE `sunlight_pm`
    CHANGE COLUMN `sender_readtime` `sender_readtime` BIGINT(20) NOT NULL DEFAULT 0,
    CHANGE COLUMN `receiver_readtime` `receiver_readtime` BIGINT(20) NOT NULL DEFAULT 0,
    CHANGE COLUMN `update_time` `update_time` BIGINT(20) NOT NULL DEFAULT 0;
