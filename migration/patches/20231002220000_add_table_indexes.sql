ALTER TABLE `sunlight_article`
    ADD KEY (`author`),
    ADD KEY (`home1`),
    ADD KEY (`home2`),
    ADD KEY (`home3`),
    ADD KEY (`time`),
    ADD KEY (`visible`),
    ADD KEY (`public`),
    ADD KEY (`confirmed`),
    ADD KEY (`ratenum`),
    ADD KEY (`ratesum`),
    ADD KEY (`slug`),
    ADD FULLTEXT `search` (`title`, `description`, `search_content`);

ALTER TABLE `sunlight_box`
    ADD KEY (`ord`),
    ADD KEY (`visible`),
    ADD KEY (`public`),
    ADD KEY (`slot`),
    ADD KEY (`level`),
    ADD KEY (`template`),
    ADD KEY (`layout`);

ALTER TABLE `sunlight_gallery_image`
    ADD KEY (`home`),
    ADD KEY (`in_storage`),
    ADD KEY (`ord`),
    ADD KEY (`full`),
    ADD FULLTEXT `search` (`title`);

ALTER TABLE `sunlight_iplog`
    ADD KEY (`ip`),
    ADD KEY (`type`),
    ADD KEY (`time`),
    ADD KEY (`var`);

ALTER TABLE `sunlight_log`
    ADD KEY (`level`),
    ADD KEY (`category`),
    ADD KEY (`time`),
    ADD KEY (`message`(255)),
    ADD KEY (`method`),
    ADD KEY (`url`(255)),
    ADD KEY (`ip`),
    ADD KEY (`user_id`);

ALTER TABLE `sunlight_page`
    ADD KEY (`level`),
    ADD KEY (`type`),
    ADD KEY (`ord`),
    ADD KEY (`visible`),
    ADD KEY (`public`),
    ADD KEY (`show_heading`),
    ADD KEY (`var1`),
    ADD KEY (`var2`),
    ADD KEY (`var3`),
    ADD KEY (`var4`),
    ADD KEY (`node_parent`),
    ADD KEY (`slug_abs`),
    ADD KEY (`slug`),
    ADD FULLTEXT `search` (`title`, `heading`, `description`, `search_content`);

ALTER TABLE `sunlight_pm`
    ADD KEY (`sender`),
    ADD KEY (`receiver`),
    ADD KEY (`update_time`),
    ADD KEY (`sender_deleted`),
    ADD KEY (`receiver_deleted`);

ALTER TABLE `sunlight_poll`
    ADD KEY (`author`);

ALTER TABLE `sunlight_post`
    ADD KEY (`bumptime`),
    ADD KEY (`type`),
    ADD KEY (`home`),
    ADD KEY (`xhome`),
    ADD KEY (`author`),
    ADD KEY (`time`),
    ADD KEY (`sticky`),
    ADD KEY (`flag`),
    ADD FULLTEXT `search` (`subject`, `text`);

ALTER TABLE `sunlight_redirect`
    ADD KEY (`active`),
    ADD KEY (`permanent`),
    ADD KEY (`old`);

ALTER TABLE `sunlight_setting`
    ADD KEY (`preload`),
    ADD KEY (`web`),
    ADD KEY (`admin`);

ALTER TABLE `sunlight_user`
    ADD UNIQUE KEY (`username`),
    ADD UNIQUE KEY (`email`),
    ADD UNIQUE KEY (`publicname`),
    ADD KEY (`group_id`),
    ADD KEY (`logincounter`),
    ADD KEY (`registertime`),
    ADD KEY (`activitytime`),
    ADD KEY (`blocked`),
    ADD KEY (`massemail`);

ALTER TABLE `sunlight_user_activation`
    ADD KEY (`code`),
    ADD KEY (`expire`);

ALTER TABLE `sunlight_user_group`
    ADD KEY (`level`),
    ADD KEY (`blocked`),
    ADD KEY (`reglist`);
