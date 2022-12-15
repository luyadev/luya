-- phpMyAdmin SQL Dump
-- version 4.4.13.1deb1
-- https://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 07, 2016 at 02:08 PM
-- Server version: 5.6.27-0ubuntu1
-- PHP Version: 5.6.11-1ubuntu3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `luya_envs_dev`
--

-- --------------------------------------------------------

--
-- Table structure for table `account_user`
--

CREATE TABLE IF NOT EXISTS `account_user` (
  `id` int(11) NOT NULL,
  `firstname` text,
  `lastname` text,
  `email` text,
  `password` varchar(255) DEFAULT NULL,
  `password_salt` varchar(255) DEFAULT NULL,
  `auth_token` varchar(255) DEFAULT NULL,
  `is_deleted` tinyint(11) DEFAULT '0',
  `gender` tinyint(1) DEFAULT '0',
  `street` varchar(120) DEFAULT NULL,
  `zip` varchar(20) DEFAULT NULL,
  `city` varchar(80) DEFAULT NULL,
  `country` varchar(80) DEFAULT NULL,
  `company` varchar(80) DEFAULT NULL,
  `subscription_newsletter` tinyint(1) DEFAULT '0',
  `subscription_medianews` tinyint(1) DEFAULT '0',
  `verification_hash` varchar(80) DEFAULT NULL,
  `is_mail_verified` tinyint(1) DEFAULT '0',
  `is_active` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

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
) ENGINE=InnoDB AUTO_INCREMENT=90 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin_auth`
--

INSERT INTO `admin_auth` (`id`, `alias_name`, `module_name`, `is_crud`, `route`, `api`) VALUES
(10, 'Users', 'admin', 1, '0', 'api-admin-user'),
(11, 'Groups', 'admin', 1, '0', 'api-admin-group'),
(12, 'Languages', 'admin', 1, '0', 'api-admin-lang'),
(13, 'Tags', 'admin', 1, '0', 'api-admin-tag'),
(14, 'Effects', 'admin', 1, '0', 'api-admin-effect'),
(15, 'Filters', 'admin', 1, '0', 'api-admin-filter'),
(16, 'File Manager', 'admin', 0, 'admin/storage/index', '0'),
(73, 'Blöcke einfügen und verschieben', 'cmsadmin', 1, '0', 'api-cms-navitempageblockitem'),
(74, 'Containers', 'cmsadmin', 1, '0', 'api-cms-navcontainer'),
(75, 'Layouts', 'cmsadmin', 1, '0', 'api-cms-layout'),
(76, 'Groups', 'cmsadmin', 1, '0', 'api-cms-blockgroup'),
(77, 'Manage', 'cmsadmin', 1, '0', 'api-cms-block'),
(78, 'Seiten Erstellen', 'cmsadmin', 0, 'cmsadmin/page/create', '0'),
(79, 'Seiten Bearbeiten', 'cmsadmin', 0, 'cmsadmin/page/update', '0'),
(80, 'Vorlagen Bearbeiten', 'cmsadmin', 0, 'cmsadmin/page/drafts', '0'),
(81, 'Page Content', 'cmsadmin', 0, 'cmsadmin/default/index', '0'),
(82, 'News Eintrag', 'newsadmin', 1, '0', 'api-news-article'),
(83, 'Kategorien', 'newsadmin', 1, '0', 'api-news-cat'),
(84, 'Tags', 'newsadmin', 1, '0', 'api-news-tag'),
(85, 'Alben', 'galleryadmin', 1, '0', 'api-gallery-album'),
(86, 'Kategorien', 'galleryadmin', 1, '0', 'api-gallery-cat'),
(87, 'Benutzer', 'accountadmin', 1, '0', 'api-account-user'),
(88, 'Seiten Index', 'crawleradmin', 1, '0', 'api-crawler-index'),
(89, 'Zwischenspeicher', 'crawleradmin', 1, '0', 'api-crawler-builderindex');

-- --------------------------------------------------------

--
-- Table structure for table `admin_config`
--

CREATE TABLE IF NOT EXISTS `admin_config` (
  `name` varchar(80) NOT NULL,
  `value` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
(1, 10, 1, 1, 1),
(1, 11, 1, 1, 1),
(1, 12, 1, 1, 1),
(1, 13, 1, 1, 1),
(1, 14, 1, 1, 1),
(1, 15, 1, 1, 1),
(1, 16, 1, 1, 1),
(1, 73, 1, 1, 1),
(1, 74, 1, 1, 1),
(1, 75, 1, 1, 1),
(1, 76, 1, 1, 1),
(1, 77, 1, 1, 1),
(1, 78, 1, 1, 1),
(1, 79, 1, 1, 1),
(1, 80, 1, 1, 1),
(1, 81, 1, 1, 1),
(1, 82, 1, 1, 1),
(1, 83, 1, 1, 1),
(1, 84, 1, 1, 1),
(1, 85, 1, 1, 1),
(1, 86, 1, 1, 1),
(1, 87, 1, 1, 1),
(1, 88, 1, 1, 1),
(1, 89, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `admin_lang`
--

CREATE TABLE IF NOT EXISTS `admin_lang` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `short_code` varchar(255) DEFAULT NULL,
  `is_default` smallint(6) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin_lang`
--

INSERT INTO `admin_lang` (`id`, `name`, `short_code`, `is_default`) VALUES
(1, 'English', 'en', 1),
(9, 'Deutsch', 'de', 0);

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
-- Table structure for table `admin_property`
--

CREATE TABLE IF NOT EXISTS `admin_property` (
  `id` int(11) NOT NULL,
  `module_name` varchar(120) DEFAULT NULL,
  `var_name` varchar(80) NOT NULL,
  `class_name` varchar(200) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin_property`
--

INSERT INTO `admin_property` (`id`, `module_name`, `var_name`, `class_name`) VALUES
(1, 'account', 'isProtectedArea', 'account\\properties\\IsProtectedAreaProperty'),
(2, '@app', 'test', 'app\\properties\\TestProperty');

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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

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
  `file_size` int(11) DEFAULT '0',
  `upload_user_id` int(11) DEFAULT '0',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `passthrough_file` tinyint(1) DEFAULT '0',
  `passthrough_file_password` varchar(40) NOT NULL,
  `passthrough_file_stats` int(11) DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin_storage_file`
--

INSERT INTO `admin_storage_file` (`id`, `is_hidden`, `folder_id`, `name_original`, `name_new`, `name_new_compound`, `mime_type`, `extension`, `hash_file`, `hash_name`, `upload_timestamp`, `file_size`, `upload_user_id`, `is_deleted`, `passthrough_file`, `passthrough_file_password`, `passthrough_file_stats`) VALUES
(1, 0, 3, '10', '9', '7', '8', '6', '5', '4', 2, 1, 0, 1, 0, '', 0),
(2, 0, 3, '10', '9', '7', '8', '6', '5', '4', 2, 1, 0, 1, 0, '', 0),
(3, 0, 3, '10', '9', '7', '8', '6', '5', '4', 2, 1, 0, 1, 0, '', 0),
(4, 0, 3, '10', '9', '7', '8', '6', '5', '4', 2, 1, 0, 1, 0, '', 0),
(5, 0, 3, '10', '9', '7', '8', '6', '5', '4', 2, 1, 0, 1, 0, '', 0),
(6, 0, 3, '10', '9', '7', '8', '6', '5', '4', 2, 1, 0, 1, 0, '', 0),
(7, 0, 3, '10', '9', '7', '8', '6', '5', '4', 2, 1, 0, 1, 0, '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `admin_storage_filter`
--

CREATE TABLE IF NOT EXISTS `admin_storage_filter` (
  `id` int(11) NOT NULL,
  `identifier` varchar(100) NOT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

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
(9, 'tiny-thumbnail', 'Thumbnail klein (40x40)'),
(10, 'my-test-filter', 'Mein Test Filter');

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
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

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
(14, NULL, 9, 1, '{"width":40,"height":40}'),
(15, NULL, 10, 1, '{"width":200,"height":100}'),
(16, NULL, 10, 3, '{"width":200,"height":100}');

-- --------------------------------------------------------

--
-- Table structure for table `admin_storage_folder`
--

CREATE TABLE IF NOT EXISTS `admin_storage_folder` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `timestamp_create` int(11) DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `admin_tag`
--

CREATE TABLE IF NOT EXISTS `admin_tag` (
  `id` int(11) NOT NULL,
  `name` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `admin_tag_relation`
--

CREATE TABLE IF NOT EXISTS `admin_tag_relation` (
  `tag_id` int(11) NOT NULL,
  `table_name` varchar(120) NOT NULL,
  `pk_id` int(11) NOT NULL
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
  `email` varchar(120) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `password_salt` varchar(255) DEFAULT NULL,
  `auth_token` varchar(255) DEFAULT NULL,
  `is_deleted` smallint(6) DEFAULT NULL,
  `secure_token` varchar(40) DEFAULT NULL,
  `secure_token_timestamp` int(11) DEFAULT '0',
  `force_reload` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin_user`
--

INSERT INTO `admin_user` (`id`, `firstname`, `lastname`, `title`, `email`, `password`, `password_salt`, `auth_token`, `is_deleted`, `secure_token`, `secure_token_timestamp`, `force_reload`) VALUES
(1, 'Test', 'Luya', 1, 'test@luya.io', '$2y$13$vnVPO4zmwAG3R2/0IA6fcOYdP4OFqxOsPJfuLY1PLZNg4vikmMsnK', 'sqg6hROLsv7kypd6JsJB1ZvbBnNrPtJN', '652e7d1b6b0d25b36698214c85d757410bff4fa9cc920e96b9e4ae9e1ffa93c02vy7KU0JWj4fbuFvEWcEbL2mTam--mUk', 0, NULL, 0, 0);

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
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cms_block`
--

INSERT INTO `cms_block` (`id`, `group_id`, `system_block`, `class`) VALUES
(1, 1, 0, '\\cmsadmin\\blocks\\AudioBlock'),
(2, 1, 0, '\\cmsadmin\\blocks\\DevBlock'),
(3, 1, 0, '\\cmsadmin\\blocks\\FileListBlock'),
(4, 1, 0, '\\cmsadmin\\blocks\\FormBlock'),
(5, 1, 0, '\\cmsadmin\\blocks\\HtmlBlock'),
(6, 1, 0, '\\cmsadmin\\blocks\\ImageBlock'),
(7, 1, 0, '\\cmsadmin\\blocks\\ImageTextBlock'),
(8, 1, 0, '\\cmsadmin\\blocks\\LayoutBlock'),
(9, 1, 0, '\\cmsadmin\\blocks\\LineBlock'),
(10, 1, 0, '\\cmsadmin\\blocks\\LinkButtonBlock'),
(11, 1, 0, '\\cmsadmin\\blocks\\ListBlock'),
(12, 1, 0, '\\cmsadmin\\blocks\\MapBlock'),
(13, 1, 0, '\\cmsadmin\\blocks\\ModuleBlock'),
(14, 1, 0, '\\cmsadmin\\blocks\\QuoteBlock'),
(15, 1, 0, '\\cmsadmin\\blocks\\SpacingBlock'),
(16, 1, 0, '\\cmsadmin\\blocks\\TableBlock'),
(17, 1, 0, '\\cmsadmin\\blocks\\TextBlock'),
(18, 1, 0, '\\cmsadmin\\blocks\\TitleBlock'),
(19, 1, 0, '\\cmsadmin\\blocks\\VideoBlock'),
(20, 1, 0, '\\cmsadmin\\blocks\\WysiwygBlock'),
(21, 1, 0, '\\newsadmin\\blocks\\LatestNews'),
(22, 1, 0, '\\galleryadmin\\blocks\\GalleryAlbum'),
(23, 1, 0, '\\app\\blocks\\AjaxBlock'),
(24, 1, 0, '\\app\\blocks\\ImageListTestBlock'),
(25, 1, 0, '\\app\\blocks\\ImageNoFilterBlock'),
(26, 1, 0, '\\app\\blocks\\TestBlock'),
(27, 1, 0, '\\app\\blocks\\WellBlock');

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
-- Table structure for table `cms_log`
--

CREATE TABLE IF NOT EXISTS `cms_log` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT '0',
  `is_insertion` tinyint(1) DEFAULT '0',
  `is_update` tinyint(1) DEFAULT '0',
  `is_deletion` tinyint(1) DEFAULT '0',
  `timestamp` int(11) NOT NULL,
  `message` varchar(255) DEFAULT NULL,
  `data_json` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cms_nav`
--

INSERT INTO `cms_nav` (`id`, `nav_container_id`, `parent_nav_id`, `sort_index`, `is_deleted`, `is_hidden`, `is_offline`, `is_home`, `is_draft`) VALUES
(1, 1, 0, 1, 0, 0, 0, 1, 0),
(2, 1, 0, 2, 0, 0, 0, 0, 0),
(3, 1, 0, 3, 0, 0, 0, 0, 0),
(4, 1, 3, 1, 0, 0, 0, 0, 0),
(5, 1, 0, 4, 0, 0, 0, 0, 0),
(6, 1, 0, 5, 0, 0, 0, 0, 0),
(7, 1, 0, 6, 0, 0, 1, 0, 0),
(8, 1, 0, 7, 0, 1, 0, 0, 0),
(9, 1, 0, 8, 0, 1, 1, 0, 0),
(10, 1, 3, 2, 0, 0, 0, 0, 0),
(11, 1, 0, 9, 0, 0, 0, 0, 0),
(12, 1, 0, 10, 0, 0, 0, 0, 0);

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
(1, 'Default Container', 'default', 0);

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
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cms_nav_item`
--

INSERT INTO `cms_nav_item` (`id`, `nav_id`, `lang_id`, `nav_item_type`, `nav_item_type_id`, `create_user_id`, `update_user_id`, `timestamp_create`, `timestamp_update`, `title`, `alias`, `description`) VALUES
(1, 1, 1, 1, 1, 1, 1, 1452169829, NULL, 'Homepage', 'homepage', NULL),
(2, 2, 1, 1, 2, 1, 1, 1452169917, 0, 'Page 1', 'page-1', NULL),
(3, 3, 1, 1, 3, 1, 1, 1452169924, 0, 'Page 2', 'page-2', NULL),
(4, 4, 1, 1, 4, 1, 1, 1452169937, 0, 'Sub Page of 2', 'sub-page-of-2', NULL),
(5, 5, 1, 3, 1, 1, 1, 1452169956, 0, 'Redirect to Page 1', 'redirect-to-page-1', NULL),
(6, 6, 1, 3, 2, 1, 1, 1452169974, 0, 'Redirect to external luya.io', 'redirect-to-external-luyaio', NULL),
(7, 7, 1, 1, 5, 1, 1, 1452169988, 0, 'Page is Offline', 'page-is-offline', NULL),
(8, 8, 1, 1, 6, 1, 1, 1452169995, 0, 'Page is Hidden', 'page-is-hidden', NULL),
(9, 9, 1, 1, 7, 1, 1, 1452170015, 0, 'Page is Offline and Hidden', 'page-is-offline-and-hidden', NULL),
(10, 10, 1, 1, 8, 1, 1, 1452170057, 0, 'Sub Page #2 of 2', 'sub-page-2-of-2', NULL),
(11, 11, 1, 2, 1, 1, 1, 1452170216, 0, 'News Module', 'news-module', NULL),
(12, 12, 1, 1, 9, 1, 1, 1452170281, 0, 'News Module as Module-Block', 'news-module-as-module-block', NULL),
(13, 1, 9, 1, 10, 1, 1, 1452171794, 1452171794, 'Startseite', 'startseite', NULL),
(14, 2, 9, 1, 11, 1, 1, 1452171805, 1452171805, 'Seite 1', 'seite-1', NULL),
(15, 3, 9, 1, 12, 1, 1, 1452171813, 1452171813, 'Seite 2', 'seite-2', NULL),
(16, 4, 9, 1, 13, 1, 1, 1452171829, 1452171829, 'Unterseite von Seite 2', 'unterseite-von-seite-2', NULL),
(17, 10, 9, 1, 14, 1, 1, 1452171850, 1452171850, 'Unterseite #2 von Seite 2', 'unterseite-2-von-seite-2', NULL),
(18, 5, 9, 3, 3, 1, 1, 1452171871, 1452171871, 'Weiterleitung auf Seite 1', 'weiterleitung-auf-seite-1', NULL),
(19, 6, 9, 3, 4, 1, 1, 1452171935, 1452171935, 'Weiterleitung auf extern luya.io', 'weiterleitung-auf-extern-luyaio', NULL),
(20, 7, 9, 1, 15, 1, 1, 1452171949, 1452171949, 'Seite ist Offline', 'seite-ist-offline', NULL),
(21, 8, 9, 1, 16, 1, 1, 1452171962, 1452171963, 'Seite ist versteckt', 'seite-ist-versteckt', NULL),
(22, 9, 9, 1, 17, 1, 1, 1452171977, 1452171977, 'Seite ist Offline und Versteckt', 'seite-ist-offline-und-versteckt', NULL),
(23, 11, 9, 2, 2, 1, 1, 1452171987, 1452171987, 'News Modul', 'news-modul', NULL),
(24, 12, 9, 1, 18, 1, 1, 1452172022, 1452172022, 'News Modul als Modul-Block', 'news-modul-als-modul-block', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cms_nav_item_module`
--

CREATE TABLE IF NOT EXISTS `cms_nav_item_module` (
  `id` int(11) NOT NULL,
  `module_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cms_nav_item_module`
--

INSERT INTO `cms_nav_item_module` (`id`, `module_name`) VALUES
(1, 'news'),
(2, 'news');

-- --------------------------------------------------------

--
-- Table structure for table `cms_nav_item_page`
--

CREATE TABLE IF NOT EXISTS `cms_nav_item_page` (
  `id` int(11) NOT NULL,
  `layout_id` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cms_nav_item_page`
--

INSERT INTO `cms_nav_item_page` (`id`, `layout_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1);

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
  `is_hidden` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cms_nav_item_page_block_item`
--

INSERT INTO `cms_nav_item_page_block_item` (`id`, `block_id`, `placeholder_var`, `nav_item_page_id`, `prev_id`, `json_config_values`, `json_config_cfg_values`, `is_dirty`, `create_user_id`, `update_user_id`, `timestamp_create`, `timestamp_update`, `sort_index`, `is_hidden`) VALUES
(1, 13, 'content', 9, 0, '{"moduleName":"news"}', '{}', 1, 1, 1, 1452170772, 1452170775, 0, 0),
(2, 13, 'content', 18, 0, '{"moduleName":"news"}', '{}', 0, 1, 0, 1452172022, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `cms_nav_item_redirect`
--

CREATE TABLE IF NOT EXISTS `cms_nav_item_redirect` (
  `id` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `value` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cms_nav_item_redirect`
--

INSERT INTO `cms_nav_item_redirect` (`id`, `type`, `value`) VALUES
(1, 1, '2'),
(2, 2, 'https://luya.io'),
(3, 1, '2'),
(4, 2, 'https://luya.io');

-- --------------------------------------------------------

--
-- Table structure for table `cms_nav_property`
--

CREATE TABLE IF NOT EXISTS `cms_nav_property` (
  `id` int(11) NOT NULL,
  `nav_id` int(11) NOT NULL,
  `admin_prop_id` int(11) NOT NULL,
  `value` varchar(255) NOT NULL
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
  `language_info` varchar(80) DEFAULT NULL,
  `crawled` tinyint(1) DEFAULT '0',
  `status_code` tinyint(4) DEFAULT '0',
  `content_hash` varchar(80) DEFAULT NULL,
  `is_dublication` tinyint(1) DEFAULT '0'
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
  `language_info` varchar(80) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

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

-- --------------------------------------------------------

--
-- Table structure for table `error_data`
--

CREATE TABLE IF NOT EXISTS `error_data` (
  `id` int(11) NOT NULL,
  `identifier` varchar(255) DEFAULT NULL,
  `error_json` text,
  `timestamp_create` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `gallery_album`
--

CREATE TABLE IF NOT EXISTS `gallery_album` (
  `id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(150) NOT NULL,
  `description` text,
  `cover_image_id` int(11) DEFAULT '0',
  `timestamp_create` int(11) NOT NULL DEFAULT '0',
  `timestamp_update` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `gallery_album_image`
--

CREATE TABLE IF NOT EXISTS `gallery_album_image` (
  `image_id` int(11) NOT NULL DEFAULT '0',
  `album_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `gallery_cat`
--

CREATE TABLE IF NOT EXISTS `gallery_cat` (
  `id` int(11) NOT NULL,
  `title` varchar(120) NOT NULL,
  `cover_image_id` int(11) NOT NULL DEFAULT '0',
  `description` text
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
('m000000_000000_base', 1452169690),
('m141104_104622_admin_group', 1452169691),
('m141104_104631_admin_user_group', 1452169691),
('m141104_114809_admin_user', 1452169691),
('m141203_121042_admin_lang', 1452169691),
('m141203_143052_cms_cat', 1452169691),
('m141203_143059_cms_nav', 1452169691),
('m141203_143111_cms_nav_item', 1452169691),
('m141208_134038_cms_nav_item_page', 1452169691),
('m150106_095003_cms_layout', 1452169691),
('m150108_154017_cms_block', 1452169691),
('m150108_155009_cms_nav_item_page_block_item', 1452169692),
('m150122_125429_cms_nav_item_module', 1452169692),
('m150204_144806_news_article', 1452169692),
('m150205_141350_block_group', 1452169692),
('m150210_102242_error_data', 1452171451),
('m150302_154115_account_user', 1452169692),
('m150304_152220_admin_storage_folder', 1452169692),
('m150304_152238_admin_storage_file', 1452169692),
('m150304_152244_admin_storage_filter', 1452169692),
('m150304_152250_admin_storage_effect', 1452169692),
('m150304_152256_admin_storage_image', 1452169692),
('m150309_142652_admin_storage_filter_chain', 1452169692),
('m150311_123919_news_tag', 1452169692),
('m150311_124116_news_article_tag', 1452169693),
('m150323_125407_admin_auth', 1452169693),
('m150323_132625_admin_group_auth', 1452169693),
('m150331_125022_admin_ngrest_log', 1452169693),
('m150428_095829_news_cat', 1452169693),
('m150504_094950_gallery_album', 1452169693),
('m150504_132138_gallery_album_image', 1452169693),
('m150601_105400_gallery_cat', 1452169693),
('m150615_094744_admin_user_login', 1452169693),
('m150617_200836_admin_user_online', 1452169693),
('m150626_084948_admin_search_data', 1452169693),
('m150727_104346_crawler_index', 1452169693),
('m150727_105126_crawler_builder_index', 1452169694),
('m150915_081559_admin_config', 1452169694),
('m150922_134558_add_is_offline', 1452169694),
('m150924_112309_cms_nav_prop', 1452169694),
('m150924_120914_admin_prop', 1452169694),
('m151007_084953_storage_folder_is_deleted', 1452169694),
('m151007_113638_admin_file_use_socket', 1452169694),
('m151007_134149_admin_property_class_name', 1452169695),
('m151012_072207_cms_log', 1452169695),
('m151013_132217_login_secure_token', 1452169695),
('m151020_065710_user_force_reload', 1452169695),
('m151022_143429_cms_nav_item_redirect', 1452169695),
('m151026_161841_admin_tag', 1452169695),
('m151028_085932_add_is_home_in_nav', 1452169696),
('m151104_160421_remove_property_fields', 1452169696),
('m151110_113803_rename_rewrite_to_alias', 1452169696),
('m151110_114915_rename_cms_cat_to_cms_nav_container', 1452169696),
('m151116_105124_image_resolution_to_storage_image', 1452169696),
('m151123_114124_add_nav_item_description', 1452169697),
('m151126_090723_add_is_draft_for_nav', 1452169697),
('m151130_075456_block_is_hidden', 1452169697),
('m151213_201944_add_md5_sum', 1452169697),
('m151214_095728_add_more_user_data', 1452169698);

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
-- Indexes for table `account_user`
--
ALTER TABLE `account_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_auth`
--
ALTER TABLE `admin_auth`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_config`
--
ALTER TABLE `admin_config`
  ADD PRIMARY KEY (`name`),
  ADD UNIQUE KEY `name` (`name`);

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
-- Indexes for table `admin_property`
--
ALTER TABLE `admin_property`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `var_name` (`var_name`);

--
-- Indexes for table `admin_search_data`
--
ALTER TABLE `admin_search_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_storage_effect`
--
ALTER TABLE `admin_storage_effect`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `identifier` (`identifier`);

--
-- Indexes for table `admin_storage_file`
--
ALTER TABLE `admin_storage_file`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_storage_filter`
--
ALTER TABLE `admin_storage_filter`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `identifier` (`identifier`);

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
-- Indexes for table `admin_tag`
--
ALTER TABLE `admin_tag`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `admin_user`
--
ALTER TABLE `admin_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

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
-- Indexes for table `cms_layout`
--
ALTER TABLE `cms_layout`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cms_log`
--
ALTER TABLE `cms_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cms_nav`
--
ALTER TABLE `cms_nav`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cms_nav_container`
--
ALTER TABLE `cms_nav_container`
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
-- Indexes for table `cms_nav_item_redirect`
--
ALTER TABLE `cms_nav_item_redirect`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cms_nav_property`
--
ALTER TABLE `cms_nav_property`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `crawler_builder_index`
--
ALTER TABLE `crawler_builder_index`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniqueurl` (`url`);

--
-- Indexes for table `crawler_index`
--
ALTER TABLE `crawler_index`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniqueurl` (`url`);

--
-- Indexes for table `dummy_table`
--
ALTER TABLE `dummy_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `error_data`
--
ALTER TABLE `error_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gallery_album`
--
ALTER TABLE `gallery_album`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gallery_cat`
--
ALTER TABLE `gallery_cat`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `account_user`
--
ALTER TABLE `account_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `admin_auth`
--
ALTER TABLE `admin_auth`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=90;
--
-- AUTO_INCREMENT for table `admin_group`
--
ALTER TABLE `admin_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `admin_lang`
--
ALTER TABLE `admin_lang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `admin_ngrest_log`
--
ALTER TABLE `admin_ngrest_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `admin_property`
--
ALTER TABLE `admin_property`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `admin_search_data`
--
ALTER TABLE `admin_search_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `admin_storage_effect`
--
ALTER TABLE `admin_storage_effect`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `admin_storage_file`
--
ALTER TABLE `admin_storage_file`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `admin_storage_filter`
--
ALTER TABLE `admin_storage_filter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `admin_storage_filter_chain`
--
ALTER TABLE `admin_storage_filter_chain`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `admin_storage_folder`
--
ALTER TABLE `admin_storage_folder`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `admin_storage_image`
--
ALTER TABLE `admin_storage_image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `admin_tag`
--
ALTER TABLE `admin_tag`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `cms_block_group`
--
ALTER TABLE `cms_block_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `cms_layout`
--
ALTER TABLE `cms_layout`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `cms_log`
--
ALTER TABLE `cms_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `cms_nav`
--
ALTER TABLE `cms_nav`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `cms_nav_container`
--
ALTER TABLE `cms_nav_container`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `cms_nav_item`
--
ALTER TABLE `cms_nav_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `cms_nav_item_module`
--
ALTER TABLE `cms_nav_item_module`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `cms_nav_item_page`
--
ALTER TABLE `cms_nav_item_page`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `cms_nav_item_page_block_item`
--
ALTER TABLE `cms_nav_item_page_block_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `cms_nav_item_redirect`
--
ALTER TABLE `cms_nav_item_redirect`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `cms_nav_property`
--
ALTER TABLE `cms_nav_property`
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
-- AUTO_INCREMENT for table `dummy_table`
--
ALTER TABLE `dummy_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `error_data`
--
ALTER TABLE `error_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `gallery_album`
--
ALTER TABLE `gallery_album`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `gallery_cat`
--
ALTER TABLE `gallery_cat`
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