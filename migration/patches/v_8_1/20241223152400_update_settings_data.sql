INSERT INTO `sunlight_setting` (`var`, `val`, `preload`, `web`, `admin`) VALUES
    ('password_min_len', '8', 0, 0, 0),
    ('allowed_file_ext', '7z,avif,csv,doc,docx,dot,dotx,eot,gif,heic,ico,jpeg,jpg,jxl,m4a,m4v,md,mov,mp3,mp4,odg,odp,ods,odt,ogg,ogv,otf,otg,otp,ots,ott,pdf,png,pot,potx,ppt,pptx,ram,rar,rm,rst,tar,ttc,ttf,txt,webm,webp,wma,wmv,woff,woff2,xls,xlsx,xlt,xltx,zip', 0, 0, 0);

UPDATE `sunlight_setting` SET `val`='1' WHERE `var`='registration_confirm';
UPDATE `sunlight_setting` SET `val`='sl8db-002' WHERE `var`='dbversion';

UPDATE `sunlight_setting` SET `val`='60' WHERE `var`='antispamtimeout';
UPDATE `sunlight_setting` SET `val`='10' WHERE `var`='messagesperpage';
UPDATE `sunlight_setting` SET `val`='3' WHERE `var`='pagingmode';
UPDATE `sunlight_setting` SET `val`='1' WHERE `var`='show_avatars';
UPDATE `sunlight_setting` SET `val`='1' WHERE `var`='pretty_urls';

UPDATE `sunlight_setting` SET `web`=1, `admin`=1;
UPDATE `sunlight_setting` SET `web`=0 WHERE `var` IN ('admin_index_custom', 'admin_index_custom_pos', 'admin_index_log_since', 'adminpagelist_mode', 'adminscheme', 'adminscheme_dark', 'allowed_file_ext', 'fulltext_content_limit', 'password_min_len');
UPDATE `sunlight_setting` SET `admin`=0 WHERE `var` IN ('admin_index_log_since', 'allowed_file_ext', 'fulltext_content_limit', 'password_min_len');
