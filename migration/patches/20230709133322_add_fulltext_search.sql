ALTER TABLE `sunlight_page` ADD `search_content` text COLLATE 'utf8mb4_unicode_ci' NOT NULL AFTER `content`;
ALTER TABLE `sunlight_page` ADD FULLTEXT `search` (`title`, `heading`, `description`, `search_content`);

ALTER TABLE `sunlight_article` ADD `search_content` text COLLATE 'utf8mb4_unicode_ci' NOT NULL AFTER `content`;
ALTER TABLE `sunlight_article` ADD FULLTEXT `search` (`title`, `description`, `search_content`);

ALTER TABLE `sunlight_post` ADD FULLTEXT `search` (`subject`, `text`);

ALTER TABLE `sunlight_gallery_image` ADD FULLTEXT `search` (`title`);

INSERT INTO `sunlight_setting` (`var`, `val`, `preload`, `web`, `admin`) VALUES ('fulltext_content_limit', '65535', '0', '0', '0');
