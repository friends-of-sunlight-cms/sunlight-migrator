UPDATE `sunlight_post` SET `subject`='' WHERE (`subject`='-') OR (`xhome`=-1 AND `type` NOT IN(5, 6));
UPDATE `sunlight_post` SET `guest`='' WHERE `guest`='Anonym';
