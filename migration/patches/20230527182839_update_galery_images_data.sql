UPDATE `sunlight_gallery_image` SET `full` = CONCAT('images/galleries/', SUBSTRING(`full`, 20)) WHERE `prev` = '' AND SUBSTRING(`full`, 1, 19) = 'pictures/galleries/';
