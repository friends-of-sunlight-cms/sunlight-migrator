UPDATE `sunlight_page` SET `node_parent`=NULL WHERE `node_parent`=0 OR `node_parent`=-1;
UPDATE `sunlight_page` SET `var2`=0 WHERE `type`=7;
UPDATE `sunlight_page` SET `level_inherit`=1 WHERE `type`=0;
UPDATE `sunlight_page` SET `layout_inherit`=1;
