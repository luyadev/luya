ALTER TABLE `gallery_cat` ADD `cover_image_id` INT(11) NOT NULl DEFAULT '0' ;
ALTER TABLE `gallery_cat` ADD `description` TEXT;

ALTER TABLE `admin_storage_file` ADD `is_deleted` TINYINT(1) NOT NULL DEFAULT '0' AFTER `is_hidden`;