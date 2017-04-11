DROP TABLE IF EXISTS `crawler_index` CASCADE;
DROP TABLE IF EXISTS `crawler_searchdata` CASCADE;

CREATE TABLE `crawler_index` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(200) NOT NULL,
  `title` varchar(200) DEFAULT NULL,
  `content` text,
  `description` text,
  `language_info` varchar(80) DEFAULT NULL,
  `url_found_on_page` varchar(255) DEFAULT NULL,
  `group` varchar(120) DEFAULT NULL,
  `added_to_index` int(11) DEFAULT '0',
  `last_update` int(11) DEFAULT '0',
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `crawler_searchdata` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `query` varchar(120) NOT NULL,
  `results` int(11) DEFAULT '0',
  `timestamp` int(11) NOT NULL,
  `language` varchar(12) DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
