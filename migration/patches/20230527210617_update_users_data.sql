TRUNCATE TABLE `sunlight_user_activation`;

UPDATE `sunlight_user` SET `publicname`=NULL WHERE publicname='';

UPDATE `sunlight_user` SET `password`=CONCAT('md5_legacy:0:', `salt`, ':', `password`);
ALTER TABLE `sunlight_user` DROP COLUMN `salt`;

SET @new_admin_id := (SELECT MAX(id)+1 FROM `sunlight_user`);
UPDATE `sunlight_user` SET `id`=@new_admin_id WHERE id=0;

UPDATE `sunlight_article` SET `author`=@new_admin_id WHERE author=0;
UPDATE `sunlight_pm` SET `sender`=@new_admin_id WHERE sender=0;
UPDATE `sunlight_pm` SET `receiver`=@new_admin_id WHERE receiver=0;
UPDATE `sunlight_poll` SET `author`=@new_admin_id WHERE author=0;
UPDATE `sunlight_post` SET `author`=@new_admin_id WHERE author=0;
