TRUNCATE TABLE `sunlight_user_activation`;

UPDATE `sunlight_user` SET `publicname`=NULL WHERE publicname='';

ALTER TABLE `sunlight_user`
    ADD UNIQUE KEY (`username`),
    ADD UNIQUE KEY (`publicname`),
    ADD UNIQUE KEY (`email`);

UPDATE `sunlight_user` SET `password`=CONCAT('md5_legacy:0:', `salt`, ':', `password`);
ALTER TABLE `sunlight_user` DROP COLUMN `salt`;

ALTER TABLE `sunlight_user` ADD COLUMN `migr_move` TINYINT(1) NOT NULL DEFAULT 0;
UPDATE `sunlight_user` SET `migr_move`=1 WHERE id=0;

UPDATE `sunlight_user` SET `id`=(SELECT MAX(id)+1 FROM `sunlight_user`) WHERE id=0;
UPDATE `sunlight_article` SET `author`=(SELECT id FROM `sunlight_user` WHERE migr_move=1) WHERE author=0;

UPDATE `sunlight_pm` SET `sender`=(SELECT id FROM `sunlight_user` WHERE migr_move=1) WHERE sender=0;
UPDATE `sunlight_pm` SET `receiver`=(SELECT id FROM `sunlight_user` WHERE migr_move=1) WHERE receiver=0;
UPDATE `sunlight_poll` SET `author`=(SELECT id FROM `sunlight_user` WHERE migr_move=1) WHERE author=0;
UPDATE `sunlight_post` SET `author`=(SELECT id FROM `sunlight_user` WHERE migr_move=1) WHERE author=0;

ALTER TABLE `sunlight_user` DROP COLUMN `migr_move`;
