UPDATE `sunlight_setting` SET `var`=SUBSTR(`var`, 2) WHERE `var` LIKE '.%';
UPDATE `sunlight_setting` SET `web`=1, `admin`=1;
UPDATE `sunlight_setting` SET `web`=0, `admin`=1 WHERE `var` NOT IN ('adminscheme', 'adminscheme_mode', 'admin_index_custom', 'admin_index_custom_pos');
UPDATE `sunlight_setting` SET `preload`=1 WHERE `var` NOT IN ('admin_index_custom', 'admin_index_custom_pos', 'cron_auth', 'rules');

INSERT INTO `sunlight_setting` (`var`, `val`, `preload`, `web`, `admin`) VALUES
   ('adminpagelist_mode', '0', 1, 0, 1),
   ('galdefault_per_page', '9', 1, 1, 1),
   ('galdefault_per_row', '3', 1, 1, 1),
   ('galdefault_thumb_h', '110', 1, 1, 1),
   ('galdefault_thumb_w', '147', 1, 1, 1),
   ('articlesperpage', '15', 1, 1, 1),
   ('topicsperpage', '30', 1, 1, 1),
   ('article_pic_thumb_h', '200', 1, 1, 1),
   ('article_pic_thumb_w', '200', 1, 1, 1),
   ('version_check', '1', 1, 1, 1),
   ('log_level', '5', 1, 1, 1),
   ('log_retention', '30', 1, 1, 1),
   ('date_format', 'j.n.Y', 1, 1, 1);

UPDATE `sunlight_setting` SET `val`='' WHERE `var`='install_check';
UPDATE `sunlight_setting` SET `var`='pretty_urls' WHERE `var`='modrewrite';
UPDATE `sunlight_setting` SET `val`='cs' WHERE `var`='language' AND `val`='default';
UPDATE `sunlight_setting` SET `var`='default_template' WHERE `var`='template';
UPDATE `sunlight_setting` SET `val`='default' WHERE `var`='default_template';
UPDATE `sunlight_setting` SET `var`='antispamtimeout' WHERE `var`='postsendexpire';
UPDATE `sunlight_setting` SET `var`='adminscheme_dark' WHERE `var`='adminscheme_mode';

DELETE FROM `sunlight_setting` WHERE `var` IN ('printart', 'extend_enabled', 'ajaxfm', 'wysiwyg', 'codemirror', 'lightbox', 'url', 'banned', 'keywords', 'proxy_mode', 'rss', 'rsslimit', 'modrewrite', 'smileys', 'postsendexpire', 'adminscheme_mode');

UPDATE `sunlight_setting` SET `val`='8.0.0' WHERE `var`='dbversion';
UPDATE `sunlight_setting` SET `val`=(SELECT * FROM (SELECT `val` FROM `sunlight_setting` WHERE `var` = 'article_pic_w') AS mysql_sucks) WHERE `var`='article_pic_thumb_w';
UPDATE `sunlight_setting` SET `val`=(SELECT * FROM (SELECT `val` FROM `sunlight_setting` WHERE `var` = 'article_pic_h') AS mysql_sucks) WHERE `var`='article_pic_thumb_h';
UPDATE `sunlight_setting` SET `val`=`val` * 3 WHERE `var` IN ('article_pic_w', 'article_pic_h');
UPDATE `sunlight_setting` SET `val`=`val` + 1 WHERE `var` = 'cacheid';
