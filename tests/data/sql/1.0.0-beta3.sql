-- phpMyAdmin SQL Dump
-- version 4.2.12deb2
-- https://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 11, 2015 at 10:44 AM
-- Server version: 5.6.25-0ubuntu0.15.04.1
-- PHP Version: 5.6.4-4ubuntu6.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `luyatests`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `error_data`
--

CREATE TABLE `error_data` (
`id` int(11) NOT NULL,
  `identifier` varchar(255) DEFAULT NULL,
  `error_json` text,
  `timestamp_create` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `error_data`
--
ALTER TABLE `error_data`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `error_data`
--
ALTER TABLE `error_data`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

-- --------------------------------------------------------

--
-- Table structure for table `admin_property`
--

CREATE TABLE IF NOT EXISTS `admin_property` (
  `id` int(11) NOT NULL,
  `module_name` varchar(120) DEFAULT NULL,
  `var_name` varchar(80) NOT NULL,
  `class_name` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cms_nav_property`
--

CREATE TABLE IF NOT EXISTS `cms_nav_property` (
`id` int(11) NOT NULL,
  `admin_prop_id` int(11) NOT NULL DEFAULT '0',
  `value` varchar(255) NOT NULL,
  `nav_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='latin1_swedish_ci';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_property`
--
ALTER TABLE `admin_property`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cms_nav_property`
--
ALTER TABLE `cms_nav_property`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_property`
--
ALTER TABLE `admin_property`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `cms_nav_property`
--
ALTER TABLE `cms_nav_property`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;


--
-- Table structure for table `admin_auth`
--

CREATE TABLE IF NOT EXISTS `admin_auth` (
`id` int(11) NOT NULL,
  `alias_name` varchar(60) NOT NULL,
  `module_name` varchar(60) NOT NULL,
  `is_crud` smallint(1) DEFAULT '0',
  `route` varchar(200) DEFAULT NULL,
  `api` varchar(80) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin_auth`
--

INSERT INTO `admin_auth` (`id`, `alias_name`, `module_name`, `is_crud`, `route`, `api`) VALUES
(1, 'Blöcke einfügen und verschieben', 'cmsadmin', 1, '0', 'api-cms-navitempageblockitem'),
(2, 'Kategorien', 'cmsadmin', 1, '0', 'api-cms-cat'),
(3, 'Layouts', 'cmsadmin', 1, '0', 'api-cms-layout'),
(4, 'Blockgruppen', 'cmsadmin', 1, '0', 'api-cms-blockgroup'),
(5, 'Blöcke Verwalten', 'cmsadmin', 1, '0', 'api-cms-block'),
(6, 'Seiten Erstellen', 'cmsadmin', 0, 'cmsadmin/page/create', '0'),
(7, 'Seiten Bearbeiten', 'cmsadmin', 0, 'cmsadmin/page/update', '0'),
(8, 'Seiteninhalte', 'cmsadmin', 0, 'cmsadmin/default/index', '0'),
(9, 'Benutzer', 'admin', 1, '0', 'api-admin-user'),
(10, 'Gruppen', 'admin', 1, '0', 'api-admin-group'),
(11, 'Sprachen', 'admin', 1, '0', 'api-admin-lang'),
(12, 'Effekte', 'admin', 1, '0', 'api-admin-effect'),
(13, 'Filter', 'admin', 1, '0', 'api-admin-filter'),
(14, 'Dateimanager', 'admin', 0, 'admin/storage/index', '0'),
(15, 'News Eintrag', 'newsadmin', 1, '0', 'api-news-article'),
(16, 'Kategorien', 'newsadmin', 1, '0', 'api-news-cat'),
(17, 'Tags', 'newsadmin', 1, '0', 'api-news-tag'),
(18, 'Builder Index', 'crawleradmin', 1, '0', 'api-crawler-builderindex'),
(19, 'Index', 'crawleradmin', 1, '0', 'api-crawler-index');

-- --------------------------------------------------------



CREATE TABLE IF NOT EXISTS `admin_config` (
  `name` varchar(80) NOT NULL,
  `value` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_config`
--
ALTER TABLE `admin_config`
 ADD PRIMARY KEY (`name`), ADD UNIQUE KEY `name` (`name`);

--
-- Table structure for table `dummy_table`
--

CREATE TABLE IF NOT EXISTS `dummy_table` (
`id` int(11) NOT NULL,
  `i18n_text` text NOT NULL,
  `i18n_textarea` text NOT NULL,
  `date` int(11) NOT NULL,
  `datetime` int(11) NOT NULL,
  `file_array` text NOT NULL,
  `image_array` text NOT NULL,
  `select` int(11) NOT NULL,
  `cms_page` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dummy_table`
--
ALTER TABLE `dummy_table`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dummy_table`
--
ALTER TABLE `dummy_table`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

-- --------------------------------------------------------

--
-- Table structure for table `admin_group`
--

CREATE TABLE IF NOT EXISTS `admin_group` (
`id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `text` text,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin_group`
--

INSERT INTO `admin_group` (`id`, `name`, `text`, `is_deleted`) VALUES
(1, 'Adminstrator', 'Administrator Accounts', 0);

-- --------------------------------------------------------

--
-- Table structure for table `admin_group_auth`
--

CREATE TABLE IF NOT EXISTS `admin_group_auth` (
  `group_id` int(11) DEFAULT NULL,
  `auth_id` int(11) DEFAULT NULL,
  `crud_create` smallint(4) DEFAULT NULL,
  `crud_update` smallint(4) DEFAULT NULL,
  `crud_delete` smallint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin_group_auth`
--

INSERT INTO `admin_group_auth` (`group_id`, `auth_id`, `crud_create`, `crud_update`, `crud_delete`) VALUES
(1, 9, 1, 1, 1),
(1, 14, 0, 0, 0),
(1, 12, 1, 1, 1),
(1, 13, 1, 1, 1),
(1, 10, 1, 1, 1),
(1, 11, 1, 1, 1),
(1, 4, 1, 1, 1),
(1, 1, 1, 1, 1),
(1, 5, 1, 1, 1),
(1, 2, 1, 1, 1),
(1, 3, 1, 1, 1),
(1, 7, 0, 0, 0),
(1, 6, 0, 0, 0),
(1, 8, 0, 0, 0),
(1, 18, 1, 1, 1),
(1, 19, 1, 1, 1),
(1, 16, 1, 1, 1),
(1, 15, 1, 1, 1),
(1, 17, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `admin_lang`
--

CREATE TABLE IF NOT EXISTS `admin_lang` (
`id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `short_code` varchar(255) DEFAULT NULL,
  `is_default` smallint(6) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin_lang`
--

INSERT INTO `admin_lang` (`id`, `name`, `short_code`, `is_default`) VALUES
(1, 'Deutsch', 'de', 1),
(2, 'English', 'en', 0);

-- --------------------------------------------------------

--
-- Table structure for table `admin_ngrest_log`
--

CREATE TABLE IF NOT EXISTS `admin_ngrest_log` (
`id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `timestamp_create` int(11) NOT NULL,
  `route` varchar(80) NOT NULL,
  `api` varchar(80) NOT NULL,
  `is_update` tinyint(1) DEFAULT '0',
  `is_insert` tinyint(1) DEFAULT '0',
  `attributes_json` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `admin_search_data`
--

CREATE TABLE IF NOT EXISTS `admin_search_data` (
`id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `timestamp_create` int(11) NOT NULL,
  `query` varchar(200) NOT NULL,
  `num_rows` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `admin_storage_effect`
--

CREATE TABLE IF NOT EXISTS `admin_storage_effect` (
`id` int(11) NOT NULL,
  `identifier` varchar(100) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `imagine_name` varchar(255) DEFAULT NULL,
  `imagine_json_params` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin_storage_effect`
--

INSERT INTO `admin_storage_effect` (`id`, `identifier`, `name`, `imagine_name`, `imagine_json_params`) VALUES
(1, 'thumbnail', 'Thumbnail', 'thumbnail', '{"vars":[{"var":"type","label":"outbound or inset"},{"var":"width","label":"Breit in Pixel"},{"var":"height","label":"Hoehe in Pixel"}]}'),
(2, 'resize', 'Zuschneiden', 'resize', '{"vars":[{"var":"width","label":"Breit in Pixel"},{"var":"height","label":"Hoehe in Pixel"}]}'),
(3, 'crop', 'Crop', 'crop', '{"vars":[{"var":"width","label":"Breit in Pixel"},{"var":"height","label":"Hoehe in Pixel"}]}');

-- --------------------------------------------------------

--
-- Table structure for table `admin_storage_file`
--

CREATE TABLE IF NOT EXISTS `admin_storage_file` (
`id` int(11) NOT NULL,
  `is_hidden` tinyint(1) DEFAULT '0',
  `folder_id` int(11) DEFAULT '0',
  `name_original` varchar(255) DEFAULT NULL,
  `name_new` varchar(255) DEFAULT NULL,
  `name_new_compound` varchar(255) DEFAULT NULL,
  `mime_type` varchar(255) DEFAULT NULL,
  `extension` varchar(255) DEFAULT NULL,
  `hash_file` varchar(255) DEFAULT NULL,
  `hash_name` varchar(255) DEFAULT NULL,
  `upload_timestamp` int(11) NOT NULL DEFAULT '0',
  `file_size` int(11) NOT NULL DEFAULT '0',
  `upload_user_id` int(11) NOT NULL DEFAULT '0',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `passthrough_file` tinyint(1) DEFAULT '0',
  `passthrough_file_password` varchar(40) NOT NULL,
  `passthrough_file_stats` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `admin_storage_filter`
--

CREATE TABLE IF NOT EXISTS `admin_storage_filter` (
`id` int(11) NOT NULL,
  `identifier` varchar(100) NOT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin_storage_filter`
--

INSERT INTO `admin_storage_filter` (`id`, `identifier`, `name`) VALUES
(1, 'large-crop', 'Zuschneiden gross (800x800)'),
(2, 'large-thumbnail', 'Thumbnail gross (800x800)'),
(3, 'medium-crop', 'Zuschneiden mittel (300x300)'),
(4, 'medium-thumbnail', 'Thumbnail mittel (300x300)'),
(5, 'small-crop', 'Zuschneiden klein (100x100)'),
(6, 'small-landscape', 'Kleines Landschaftsbild (150x50)'),
(7, 'small-thumbnail', 'Thumbnail klein (100x100)'),
(8, 'tiny-crop', 'Zuschneiden sehr klein (40x40)'),
(9, 'tiny-thumbnail', 'Thumbnail klein (40x40)');

-- --------------------------------------------------------

--
-- Table structure for table `admin_storage_filter_chain`
--

CREATE TABLE IF NOT EXISTS `admin_storage_filter_chain` (
`id` int(11) NOT NULL,
  `sort_index` int(11) DEFAULT NULL,
  `filter_id` int(11) DEFAULT NULL,
  `effect_id` int(11) DEFAULT NULL,
  `effect_json_values` text
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin_storage_filter_chain`
--

INSERT INTO `admin_storage_filter_chain` (`id`, `sort_index`, `filter_id`, `effect_id`, `effect_json_values`) VALUES
(1, NULL, 1, 1, '{"width":800,"height":800,"type":"outbound"}'),
(2, NULL, 1, 3, '{"width":800,"height":800}'),
(3, NULL, 2, 1, '{"width":800,"height":800}'),
(4, NULL, 3, 1, '{"width":300,"height":300,"type":"outbound"}'),
(5, NULL, 3, 3, '{"width":300,"height":300}'),
(6, NULL, 4, 1, '{"width":300,"height":300}'),
(7, NULL, 5, 1, '{"width":100,"height":100,"type":"outbound"}'),
(8, NULL, 5, 3, '{"width":100,"height":100}'),
(9, NULL, 6, 1, '{"width":150,"height":150,"type":"outbound"}'),
(10, NULL, 6, 3, '{"width":150,"height":50}'),
(11, NULL, 7, 1, '{"width":100,"height":100}'),
(12, NULL, 8, 1, '{"width":40,"height":40,"type":"outbound"}'),
(13, NULL, 8, 3, '{"width":40,"height":40}'),
(14, NULL, 9, 1, '{"width":40,"height":40}');

-- --------------------------------------------------------

--
-- Table structure for table `admin_storage_folder`
--

CREATE TABLE IF NOT EXISTS `admin_storage_folder` (
`id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `timestamp_create` int(11) DEFAULT NULL,
  `is_deleted` tinyint(1) DEFAULT 0 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `admin_storage_image`
--

CREATE TABLE IF NOT EXISTS `admin_storage_image` (
`id` int(11) NOT NULL,
  `file_id` int(11) DEFAULT NULL,
  `filter_id` int(11) DEFAULT NULL,
  `resolution_width` int(11) DEFAULT NULL,
  `resolution_height` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `admin_user`
--

CREATE TABLE IF NOT EXISTS `admin_user` (
`id` int(11) NOT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `title` smallint(6) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `password_salt` varchar(255) DEFAULT NULL,
  `auth_token` varchar(255) DEFAULT NULL,
  `is_deleted` smallint(6) DEFAULT NULL,
  `force_reload` smallint(1) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin_user`
--

INSERT INTO `admin_user` (`id`, `firstname`, `lastname`, `title`, `email`, `password`, `password_salt`, `auth_token`, `is_deleted`) VALUES
(1, 'Foo', 'Bar', 1, 'test@luya.io', '$2y$13$EXkpAAqsBLORVw4ghjRXA.kSEeH8Occtkd77fvz18Si4u75MSUQiq', 'fCKDa8pKQKTMFEdb5qvWRQUERK5A_8fP', '0af5d2d08a15e456f44eaeaf2be01147920146614a139bfb6199f6746cfbe276QwYMO2imSAMClYMDWIV7dEGtqtl1cPNt', 0);

-- --------------------------------------------------------

--
-- Table structure for table `admin_user_group`
--

CREATE TABLE IF NOT EXISTS `admin_user_group` (
`id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin_user_group`
--

INSERT INTO `admin_user_group` (`id`, `user_id`, `group_id`) VALUES
(1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `admin_user_login`
--

CREATE TABLE IF NOT EXISTS `admin_user_login` (
`id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `timestamp_create` int(11) NOT NULL,
  `auth_token` varchar(120) NOT NULL,
  `ip` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `admin_user_online`
--

CREATE TABLE IF NOT EXISTS `admin_user_online` (
`id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `last_timestamp` int(11) NOT NULL,
  `invoken_route` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cms_block`
--

CREATE TABLE IF NOT EXISTS `cms_block` (
`id` int(11) NOT NULL,
  `group_id` int(11) DEFAULT NULL,
  `system_block` int(11) DEFAULT NULL,
  `class` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cms_block`
--

INSERT INTO `cms_block` (`id`, `group_id`, `system_block`, `class`) VALUES
(1, 1, 0, '\\cmsadmin\\blocks\\DevBlock'),
(2, 1, 0, '\\cmsadmin\\blocks\\FileListBlock'),
(3, 1, 0, '\\cmsadmin\\blocks\\FormBlock'),
(4, 1, 0, '\\cmsadmin\\blocks\\HtmlBlock'),
(5, 1, 0, '\\cmsadmin\\blocks\\ImageBlock'),
(6, 1, 0, '\\cmsadmin\\blocks\\ImageTextBlock'),
(7, 1, 0, '\\cmsadmin\\blocks\\LayoutBlock'),
(8, 1, 0, '\\cmsadmin\\blocks\\ListBlock'),
(9, 1, 0, '\\cmsadmin\\blocks\\MapBlock'),
(10, 1, 0, '\\cmsadmin\\blocks\\ModuleBlock'),
(11, 1, 0, '\\cmsadmin\\blocks\\QuoteBlock'),
(12, 1, 0, '\\cmsadmin\\blocks\\SpacingBlock'),
(13, 1, 0, '\\cmsadmin\\blocks\\TableBlock'),
(14, 1, 0, '\\cmsadmin\\blocks\\TestBlock'),
(15, 1, 0, '\\cmsadmin\\blocks\\TextBlock'),
(16, 1, 0, '\\cmsadmin\\blocks\\TitleBlock'),
(17, 1, 0, '\\cmsadmin\\blocks\\VideoBlock'),
(18, 1, 0, '\\cmsadmin\\blocks\\WysiwygBlock'),
(19, 1, 0, '\\newsadmin\\blocks\\LatestNews'),
(20, 1, 0, '\\app\\blocks\\WellBlock');

-- --------------------------------------------------------

--
-- Table structure for table `cms_block_group`
--

CREATE TABLE IF NOT EXISTS `cms_block_group` (
`id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cms_block_group`
--

INSERT INTO `cms_block_group` (`id`, `name`, `is_deleted`) VALUES
(1, 'Inhalts-Elemente', 0),
(2, 'Layout-Elemente', 0),
(3, 'Modul-Elemente', 0),
(4, 'Projekt-Elemente', 0),
(5, 'Entwicklung', 0);

-- --------------------------------------------------------

--
-- Table structure for table `cms_nav_container`
--

CREATE TABLE IF NOT EXISTS `cms_nav_container` (
`id` int(11) NOT NULL,
  `name` varchar(180) NOT NULL,
  `alias` varchar(80) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cms_nav_container`
--

INSERT INTO `cms_nav_container` (`id`, `name`, `alias`, `is_deleted`) VALUES
(1, 'Hauptnavigation', 'default', 0);

-- --------------------------------------------------------

--
-- Table structure for table `cms_layout`
--

CREATE TABLE IF NOT EXISTS `cms_layout` (
`id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `json_config` text,
  `view_file` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cms_layout`
--

INSERT INTO `cms_layout` (`id`, `name`, `json_config`, `view_file`) VALUES
(1, 'Main.twig', '{"placeholders":[{"label":"content","var":"content"}]}', 'main.twig');

-- --------------------------------------------------------

--
-- Table structure for table `cms_nav`
--

CREATE TABLE IF NOT EXISTS `cms_nav` (
`id` int(11) NOT NULL,
  `nav_container_id` int(11) NOT NULL DEFAULT '0',
  `parent_nav_id` int(11) NOT NULL DEFAULT '0',
  `sort_index` int(11) NOT NULL DEFAULT '0',
  `is_deleted` tinyint(1) DEFAULT '0',
  `is_hidden` tinyint(1) DEFAULT '0',
  `is_offline` tinyint(1) DEFAULT '0',
  `is_home` tinyint(1) DEFAULT '0',
   `is_draft` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cms_nav`
--

INSERT INTO `cms_nav` (`id`, `nav_container_id`, `parent_nav_id`, `sort_index`, `is_deleted`, `is_hidden`, `is_home`) VALUES
(1, 1, 0, 1, 0, 0, 1),
(2, 1, 0, 2, 0, 0, 0),
(3, 1, 0, 3, 0, 0, 0),
(4, 1, 0, 4, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `cms_nav_item`
--

CREATE TABLE IF NOT EXISTS `cms_nav_item` (
`id` int(11) NOT NULL,
  `nav_id` int(11) NOT NULL,
  `lang_id` int(11) NOT NULL,
  `nav_item_type` int(11) NOT NULL,
  `nav_item_type_id` int(11) NOT NULL,
  `create_user_id` int(11) NOT NULL,
  `update_user_id` int(11) NOT NULL,
  `timestamp_create` int(11) DEFAULT NULL,
  `timestamp_update` int(11) DEFAULT NULL,
  `title` varchar(180) NOT NULL,
  `alias` varchar(80) NOT NULL,
  `description` text
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cms_nav_item`
--

INSERT INTO `cms_nav_item` (`id`, `nav_id`, `lang_id`, `nav_item_type`, `nav_item_type_id`, `create_user_id`, `update_user_id`, `timestamp_create`, `timestamp_update`, `title`, `alias`) VALUES
(1, 1, 1, 1, 1, 1, 1, 1439281771, 0, 'Page 1', 'page-1'),
(2, 2, 1, 1, 2, 1, 1, 1439281801, 0, 'Page 2', 'page-2'),
(3, 3, 1, 2, 1, 1, 1, 1439282169, 0, 'My News Page', 'my-news-page'),
(4, 4, 1, 2, 2, 1, 1, 1439282169, 0, 'News Module', 'news-module-page');

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `cms_nav_item_redirect` (
  `id` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `value` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 COMMENT='latin1_swedish_ci';


--
-- Table structure for table `cms_nav_item_module`
--

CREATE TABLE IF NOT EXISTS `cms_nav_item_module` (
`id` int(11) NOT NULL,
  `module_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cms_nav_item_module`
--

INSERT INTO `cms_nav_item_module` (`id`, `module_name`) VALUES
(1, 'gallery'),
(2, 'news');

-- --------------------------------------------------------

--
-- Table structure for table `cms_nav_item_page`
--

CREATE TABLE IF NOT EXISTS `cms_nav_item_page` (
`id` int(11) NOT NULL,
  `layout_id` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cms_nav_item_page`
--

INSERT INTO `cms_nav_item_page` (`id`, `layout_id`) VALUES
(1, 1),
(2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `cms_nav_item_page_block_item`
--

CREATE TABLE IF NOT EXISTS `cms_nav_item_page_block_item` (
`id` int(11) NOT NULL,
  `block_id` int(11) DEFAULT NULL,
  `placeholder_var` varchar(80) NOT NULL,
  `nav_item_page_id` int(11) DEFAULT NULL,
  `prev_id` int(11) DEFAULT NULL,
  `json_config_values` text,
  `json_config_cfg_values` text,
  `is_dirty` tinyint(1) DEFAULT '0',
  `create_user_id` int(11) DEFAULT '0',
  `update_user_id` int(11) DEFAULT '0',
  `timestamp_create` int(11) DEFAULT '0',
  `timestamp_update` int(11) DEFAULT '0',
  `sort_index` int(11) DEFAULT '0',
  `is_hidden` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `crawler_builder_index`
--

CREATE TABLE IF NOT EXISTS `crawler_builder_index` (
`id` int(11) NOT NULL,
  `url` varchar(200) NOT NULL,
  `content` text,
  `title` varchar(200) DEFAULT NULL,
  `last_indexed` int(11) DEFAULT NULL,
  `arguments_json` text NOT NULL,
  `language_info` varchar(80) DEFAULT NULL,
  `crawled` tinyint(1) DEFAULT '0',
  `status_code` tinyint(4) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `crawler_index`
--

CREATE TABLE IF NOT EXISTS `crawler_index` (
`id` int(11) NOT NULL,
  `url` varchar(200) NOT NULL,
  `content` text,
  `title` varchar(200) DEFAULT NULL,
  `added_to_index` int(11) DEFAULT NULL,
  `last_update` int(11) DEFAULT NULL,
  `arguments_json` text NOT NULL,
  `language_info` varchar(80) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `migration`
--

CREATE TABLE IF NOT EXISTS `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1439281671),
('m141104_104622_admin_group', 1439281673),
('m141104_104631_admin_user_group', 1439281673),
('m141104_114809_admin_user', 1439281673),
('m141203_121042_admin_lang', 1439281673),
('m141203_143052_cms_cat', 1439281673),
('m141203_143059_cms_nav', 1439281673),
('m141203_143111_cms_nav_item', 1439281673),
('m141208_134038_cms_nav_item_page', 1439281674),
('m150106_095003_cms_layout', 1439281674),
('m150108_154017_cms_block', 1439281674),
('m150108_155009_cms_nav_item_page_block_item', 1439281674),
('m150122_125429_cms_nav_item_module', 1439281674),
('m150204_144806_news_article', 1439281674),
('m150205_141350_block_group', 1439281674),
('m150304_152220_admin_storage_folder', 1439281674),
('m150304_152238_admin_storage_file', 1439281674),
('m150304_152244_admin_storage_filter', 1439281674),
('m150304_152250_admin_storage_effect', 1439281674),
('m150304_152256_admin_storage_image', 1439281674),
('m150309_142652_admin_storage_filter_chain', 1439281674),
('m150311_123919_news_tag', 1439281674),
('m150311_124116_news_article_tag', 1439281674),
('m150323_125407_admin_auth', 1439281674),
('m150323_132625_admin_group_auth', 1439281674),
('m150331_125022_admin_ngrest_log', 1439281674),
('m150428_095829_news_cat', 1439281674),
('m150615_094744_admin_user_login', 1439281674),
('m150617_200836_admin_user_online', 1439281674),
('m150626_084948_admin_search_data', 1439281674),
('m150727_104346_crawler_index', 1439281674),
('m150727_105126_crawler_builder_index', 1439281675);

-- --------------------------------------------------------

--
-- Table structure for table `news_article`
--

CREATE TABLE IF NOT EXISTS `news_article` (
`id` int(11) NOT NULL,
  `title` text,
  `text` text,
  `cat_id` int(11) NOT NULL DEFAULT '0',
  `image_id` int(11) DEFAULT NULL,
  `image_list` text,
  `file_list` text,
  `create_user_id` int(11) DEFAULT NULL,
  `update_user_id` int(11) DEFAULT NULL,
  `timestamp_create` int(11) DEFAULT NULL,
  `timestamp_update` int(11) DEFAULT NULL,
  `timestamp_display_from` int(11) DEFAULT NULL,
  `timestamp_display_until` int(11) DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `is_display_limit` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `news_article_tag`
--

CREATE TABLE IF NOT EXISTS `news_article_tag` (
`id` int(11) NOT NULL,
  `article_id` int(11) DEFAULT NULL,
  `tag_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `news_cat`
--

CREATE TABLE IF NOT EXISTS `news_cat` (
`id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `news_tag`
--

CREATE TABLE IF NOT EXISTS `news_tag` (
`id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_auth`
--
ALTER TABLE `admin_auth`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_group`
--
ALTER TABLE `admin_group`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_lang`
--
ALTER TABLE `admin_lang`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_ngrest_log`
--
ALTER TABLE `admin_ngrest_log`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_search_data`
--
ALTER TABLE `admin_search_data`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_storage_effect`
--
ALTER TABLE `admin_storage_effect`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `identifier` (`identifier`);

--
-- Indexes for table `admin_storage_file`
--
ALTER TABLE `admin_storage_file`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_storage_filter`
--
ALTER TABLE `admin_storage_filter`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `identifier` (`identifier`);

--
-- Indexes for table `admin_storage_filter_chain`
--
ALTER TABLE `admin_storage_filter_chain`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_storage_folder`
--
ALTER TABLE `admin_storage_folder`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_storage_image`
--
ALTER TABLE `admin_storage_image`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_user`
--
ALTER TABLE `admin_user`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_user_group`
--
ALTER TABLE `admin_user_group`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_user_login`
--
ALTER TABLE `admin_user_login`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_user_online`
--
ALTER TABLE `admin_user_online`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cms_block`
--
ALTER TABLE `cms_block`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cms_block_group`
--
ALTER TABLE `cms_block_group`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cms_nav_container`
--
ALTER TABLE `cms_nav_container`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cms_layout`
--
ALTER TABLE `cms_layout`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cms_nav`
--
ALTER TABLE `cms_nav`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cms_nav_item`
--
ALTER TABLE `cms_nav_item`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cms_nav_item_module`
--
ALTER TABLE `cms_nav_item_module`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cms_nav_item_page`
--
ALTER TABLE `cms_nav_item_page`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cms_nav_item_page_block_item`
--
ALTER TABLE `cms_nav_item_page_block_item`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `crawler_builder_index`
--
ALTER TABLE `crawler_builder_index`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `uniqueurl` (`url`);

--
-- Indexes for table `crawler_index`
--
ALTER TABLE `crawler_index`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `uniqueurl` (`url`);

--
-- Indexes for table `migration`
--
ALTER TABLE `migration`
 ADD PRIMARY KEY (`version`);

--
-- Indexes for table `news_article`
--
ALTER TABLE `news_article`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news_article_tag`
--
ALTER TABLE `news_article_tag`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news_cat`
--
ALTER TABLE `news_cat`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news_tag`
--
ALTER TABLE `news_tag`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_auth`
--
ALTER TABLE `admin_auth`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `admin_group`
--
ALTER TABLE `admin_group`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `admin_lang`
--
ALTER TABLE `admin_lang`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `admin_ngrest_log`
--
ALTER TABLE `admin_ngrest_log`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `admin_search_data`
--
ALTER TABLE `admin_search_data`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `admin_storage_effect`
--
ALTER TABLE `admin_storage_effect`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `admin_storage_file`
--
ALTER TABLE `admin_storage_file`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `admin_storage_filter`
--
ALTER TABLE `admin_storage_filter`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `admin_storage_filter_chain`
--
ALTER TABLE `admin_storage_filter_chain`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `admin_storage_folder`
--
ALTER TABLE `admin_storage_folder`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `admin_storage_image`
--
ALTER TABLE `admin_storage_image`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `admin_user`
--
ALTER TABLE `admin_user`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `admin_user_group`
--
ALTER TABLE `admin_user_group`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `admin_user_login`
--
ALTER TABLE `admin_user_login`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `admin_user_online`
--
ALTER TABLE `admin_user_online`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `cms_block`
--
ALTER TABLE `cms_block`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `cms_block_group`
--
ALTER TABLE `cms_block_group`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `cms_nav_container`
--
ALTER TABLE `cms_nav_container`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `cms_layout`
--
ALTER TABLE `cms_layout`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `cms_nav`
--
ALTER TABLE `cms_nav`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `cms_nav_item`
--
ALTER TABLE `cms_nav_item`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `cms_nav_item_module`
--
ALTER TABLE `cms_nav_item_module`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `cms_nav_item_page`
--
ALTER TABLE `cms_nav_item_page`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `cms_nav_item_page_block_item`
--
ALTER TABLE `cms_nav_item_page_block_item`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `crawler_builder_index`
--
ALTER TABLE `crawler_builder_index`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `crawler_index`
--
ALTER TABLE `crawler_index`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `news_article`
--
ALTER TABLE `news_article`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `news_article_tag`
--
ALTER TABLE `news_article_tag`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `news_cat`
--
ALTER TABLE `news_cat`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `news_tag`
--
ALTER TABLE `news_tag`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

