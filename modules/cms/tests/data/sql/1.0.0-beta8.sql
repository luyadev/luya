-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 11. Aug 2016 um 14:14
-- Server-Version: 5.7.13-0ubuntu0.16.04.2
-- PHP-Version: 7.0.8-0ubuntu0.16.04.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `luya_env_phpunit`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `admin_auth`
--

CREATE TABLE `admin_auth` (
  `id` int(11) NOT NULL,
  `alias_name` varchar(60) NOT NULL,
  `module_name` varchar(60) NOT NULL,
  `is_crud` smallint(1) DEFAULT '0',
  `route` varchar(200) DEFAULT NULL,
  `api` varchar(80) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `admin_auth`
--

INSERT INTO `admin_auth` (`id`, `alias_name`, `module_name`, `is_crud`, `route`, `api`) VALUES
(1, 'Page Contentblocks', 'cmsadmin', 1, '0', 'api-cms-navitempageblockitem'),
(2, 'Containers', 'cmsadmin', 1, '0', 'api-cms-navcontainer'),
(3, 'Layouts', 'cmsadmin', 1, '0', 'api-cms-layout'),
(4, 'Groups Management', 'cmsadmin', 1, '0', 'api-cms-blockgroup'),
(5, 'Blocks Management', 'cmsadmin', 1, '0', 'api-cms-block'),
(6, 'Create new Page', 'cmsadmin', 0, 'cmsadmin/page/create', '0'),
(7, 'Page Edit', 'cmsadmin', 0, 'cmsadmin/page/update', '0'),
(8, 'Draft Edit', 'cmsadmin', 0, 'cmsadmin/page/drafts', '0'),
(9, 'Page Content', 'cmsadmin', 0, 'cmsadmin/default/index', '0'),
(10, 'Page Permissions', 'cmsadmin', 0, 'cmsadmin/permission/index', '0'),
(11, 'Users', 'admin', 1, '0', 'api-admin-user'),
(12, 'Groups', 'admin', 1, '0', 'api-admin-group'),
(13, 'Languages', 'admin', 1, '0', 'api-admin-lang'),
(14, 'Tags', 'admin', 1, '0', 'api-admin-tag'),
(15, 'Effects', 'admin', 1, '0', 'api-admin-effect'),
(16, 'Filters', 'admin', 1, '0', 'api-admin-filter'),
(17, 'File Manager', 'admin', 0, 'admin/storage/index', '0');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `admin_config`
--

CREATE TABLE `admin_config` (
  `name` varchar(80) NOT NULL,
  `value` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `admin_config`
--

INSERT INTO `admin_config` (`name`, `value`) VALUES
('last_import_timestamp', '1470917553'),
('setup_command_timestamp', '1470917630');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `admin_group`
--

CREATE TABLE `admin_group` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `text` text,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `admin_group`
--

INSERT INTO `admin_group` (`id`, `name`, `text`, `is_deleted`) VALUES
(1, 'Administrator', 'Administrator Accounts have full access to all Areas and can create, update and delete all data records.', 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `admin_group_auth`
--

CREATE TABLE `admin_group_auth` (
  `group_id` int(11) DEFAULT NULL,
  `auth_id` int(11) DEFAULT NULL,
  `crud_create` smallint(4) DEFAULT NULL,
  `crud_update` smallint(4) DEFAULT NULL,
  `crud_delete` smallint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `admin_group_auth`
--

INSERT INTO `admin_group_auth` (`group_id`, `auth_id`, `crud_create`, `crud_update`, `crud_delete`) VALUES
(1, 11, 1, 1, 1),
(1, 12, 1, 1, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `admin_lang`
--

CREATE TABLE `admin_lang` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `short_code` varchar(255) DEFAULT NULL,
  `is_default` smallint(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `admin_lang`
--

INSERT INTO `admin_lang` (`id`, `name`, `short_code`, `is_default`) VALUES
(1, 'English', 'en', 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `admin_ngrest_log`
--

CREATE TABLE `admin_ngrest_log` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `timestamp_create` int(11) NOT NULL,
  `route` varchar(80) NOT NULL,
  `api` varchar(80) NOT NULL,
  `is_update` tinyint(1) DEFAULT '0',
  `is_insert` tinyint(1) DEFAULT '0',
  `attributes_json` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `admin_property`
--

CREATE TABLE `admin_property` (
  `id` int(11) NOT NULL,
  `module_name` varchar(120) DEFAULT NULL,
  `var_name` varchar(80) NOT NULL,
  `class_name` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `admin_search_data`
--

CREATE TABLE `admin_search_data` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `timestamp_create` int(11) NOT NULL,
  `query` varchar(200) NOT NULL,
  `num_rows` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `admin_storage_effect`
--

CREATE TABLE `admin_storage_effect` (
  `id` int(11) NOT NULL,
  `identifier` varchar(100) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `imagine_name` varchar(255) DEFAULT NULL,
  `imagine_json_params` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `admin_storage_effect`
--

INSERT INTO `admin_storage_effect` (`id`, `identifier`, `name`, `imagine_name`, `imagine_json_params`) VALUES
(1, 'thumbnail', 'Thumbnail', 'thumbnail', '{"vars":[{"var":"width","label":"Breit in Pixel"},{"var":"height","label":"Hoehe in Pixel"},{"var":"mode","label":"outbound or inset"},{"var":"saveOptions","label":"save options"}]}'),
(2, 'crop', 'Crop', 'crop', '{"vars":[{"var":"width","label":"Breit in Pixel"},{"var":"height","label":"Hoehe in Pixel"},{"var":"saveOptions","label":"save options"}]}');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `admin_storage_file`
--

CREATE TABLE `admin_storage_file` (
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
  `passthrough_file_password` varchar(40) DEFAULT NULL,
  `passthrough_file_stats` int(11) DEFAULT '0',
  `caption` text,
  `internal_note` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `admin_storage_filter`
--

CREATE TABLE `admin_storage_filter` (
  `id` int(11) NOT NULL,
  `identifier` varchar(100) NOT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `admin_storage_filter`
--

INSERT INTO `admin_storage_filter` (`id`, `identifier`, `name`) VALUES
(1, 'large-crop', 'Crop large (800x800)'),
(2, 'large-thumbnail', 'Thumbnail large (800xnull)'),
(3, 'medium-crop', 'Crop medium (300x300)'),
(4, 'medium-thumbnail', 'Thumbnail medium (300xnull)'),
(5, 'small-crop', 'Crop small (100x100)'),
(6, 'small-landscape', 'Landscape small (150x50)'),
(7, 'small-thumbnail', 'Thumbnail small (100xnull)'),
(8, 'tiny-crop', 'Crop tiny (40x40)'),
(9, 'tiny-thumbnail', 'Thumbnail tiny (40xnull)');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `admin_storage_filter_chain`
--

CREATE TABLE `admin_storage_filter_chain` (
  `id` int(11) NOT NULL,
  `sort_index` int(11) DEFAULT NULL,
  `filter_id` int(11) DEFAULT NULL,
  `effect_id` int(11) DEFAULT NULL,
  `effect_json_values` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `admin_storage_filter_chain`
--

INSERT INTO `admin_storage_filter_chain` (`id`, `sort_index`, `filter_id`, `effect_id`, `effect_json_values`) VALUES
(1, NULL, 1, 1, '{"width":800,"height":800}'),
(2, NULL, 2, 1, '{"width":800,"height":null}'),
(3, NULL, 3, 1, '{"width":300,"height":300}'),
(4, NULL, 4, 1, '{"width":300,"height":null}'),
(5, NULL, 5, 1, '{"width":100,"height":100}'),
(6, NULL, 6, 1, '{"width":150,"height":50}'),
(7, NULL, 7, 1, '{"width":100,"height":null}'),
(8, NULL, 8, 1, '{"width":40,"height":40}'),
(9, NULL, 9, 1, '{"width":40,"height":null}');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `admin_storage_folder`
--

CREATE TABLE `admin_storage_folder` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `timestamp_create` int(11) DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `admin_storage_image`
--

CREATE TABLE `admin_storage_image` (
  `id` int(11) NOT NULL,
  `file_id` int(11) DEFAULT NULL,
  `filter_id` int(11) DEFAULT NULL,
  `resolution_width` int(11) DEFAULT NULL,
  `resolution_height` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `admin_tag`
--

CREATE TABLE `admin_tag` (
  `id` int(11) NOT NULL,
  `name` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `admin_tag_relation`
--

CREATE TABLE `admin_tag_relation` (
  `tag_id` int(11) NOT NULL,
  `table_name` varchar(120) NOT NULL,
  `pk_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `admin_user`
--

CREATE TABLE `admin_user` (
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
  `force_reload` tinyint(1) DEFAULT '0',
  `settings` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `admin_user`
--

INSERT INTO `admin_user` (`id`, `firstname`, `lastname`, `title`, `email`, `password`, `password_salt`, `auth_token`, `is_deleted`, `secure_token`, `secure_token_timestamp`, `force_reload`, `settings`) VALUES
(1, 'John', 'Doe', 1, 'test@luya.io', '$2y$13$MuZpf..6eTl5k1qSdVvVP.liSO8yNuvlLCsnVXcjIB5AV.QEKN4Wi', 'BUCuvfSRnlhoR0YtG7-uOI2Ys1qQ5tVA', NULL, 0, NULL, 0, 0, NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `admin_user_group`
--

CREATE TABLE `admin_user_group` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `admin_user_group`
--

INSERT INTO `admin_user_group` (`id`, `user_id`, `group_id`) VALUES
(1, 1, 1);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `admin_user_login`
--

CREATE TABLE `admin_user_login` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `timestamp_create` int(11) NOT NULL,
  `auth_token` varchar(120) NOT NULL,
  `ip` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `admin_user_online`
--

CREATE TABLE `admin_user_online` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `last_timestamp` int(11) NOT NULL,
  `invoken_route` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `cms_block`
--

CREATE TABLE `cms_block` (
  `id` int(11) NOT NULL,
  `group_id` int(11) DEFAULT NULL,
  `class` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `cms_block`
--

INSERT INTO `cms_block` (`id`, `group_id`, `class`) VALUES
(1, 3, '\\cmsadmin\\blocks\\AudioBlock'),
(2, 1, '\\cmsadmin\\blocks\\DevBlock'),
(3, 3, '\\cmsadmin\\blocks\\FileListBlock'),
(4, 3, '\\cmsadmin\\blocks\\FormBlock'),
(5, 1, '\\cmsadmin\\blocks\\HtmlBlock'),
(6, 3, '\\cmsadmin\\blocks\\ImageBlock'),
(7, 3, '\\cmsadmin\\blocks\\ImageTextBlock'),
(8, 2, '\\cmsadmin\\blocks\\LayoutBlock'),
(9, 3, '\\cmsadmin\\blocks\\LineBlock'),
(10, 3, '\\cmsadmin\\blocks\\LinkButtonBlock'),
(11, 5, '\\cmsadmin\\blocks\\ListBlock'),
(12, 3, '\\cmsadmin\\blocks\\MapBlock'),
(13, 1, '\\cmsadmin\\blocks\\ModuleBlock'),
(14, 5, '\\cmsadmin\\blocks\\QuoteBlock'),
(15, 3, '\\cmsadmin\\blocks\\SpacingBlock'),
(16, 3, '\\cmsadmin\\blocks\\TableBlock'),
(17, 5, '\\cmsadmin\\blocks\\TextBlock'),
(18, 5, '\\cmsadmin\\blocks\\TitleBlock'),
(19, 3, '\\cmsadmin\\blocks\\VideoBlock'),
(20, 5, '\\cmsadmin\\blocks\\WysiwygBlock');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `cms_block_group`
--

CREATE TABLE `cms_block_group` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `identifier` varchar(120) NOT NULL,
  `created_timestamp` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `cms_block_group`
--

INSERT INTO `cms_block_group` (`id`, `name`, `is_deleted`, `identifier`, `created_timestamp`) VALUES
(1, 'Development', 0, 'development-group', 1470917553),
(2, 'Layout', 0, 'layout-group', 1470917553),
(3, 'Basics', 0, 'main-group', 1470917553),
(4, 'Project', 0, 'project-group', 1470917553),
(5, 'Texts', 0, 'text-group', 1470917553);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `cms_layout`
--

CREATE TABLE `cms_layout` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `json_config` text,
  `view_file` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `cms_layout`
--

INSERT INTO `cms_layout` (`id`, `name`, `json_config`, `view_file`) VALUES
(1, 'Main.php', '{"placeholders":[{"label":"content","var":"content"}]}', 'main.php'),
(2, 'Sidebar.php', '{"placeholders":[{"label":"content","var":"content"},{"label":"sidebar","var":"sidebar"}]}', 'sidebar.php');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `cms_log`
--

CREATE TABLE `cms_log` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT '0',
  `is_insertion` tinyint(1) DEFAULT '0',
  `is_update` tinyint(1) DEFAULT '0',
  `is_deletion` tinyint(1) DEFAULT '0',
  `timestamp` int(11) NOT NULL,
  `message` varchar(255) DEFAULT NULL,
  `data_json` text,
  `table_name` varchar(120) DEFAULT NULL,
  `row_id` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `cms_log`
--

INSERT INTO `cms_log` (`id`, `user_id`, `is_insertion`, `is_update`, `is_deletion`, `timestamp`, `message`, `data_json`, `table_name`, `row_id`) VALUES
(1, 0, 1, 0, 0, 1470917683, '{"tableName":"cms_nav","action":"insert","row":2}', '{"parent_nav_id":0,"nav_container_id":1,"is_hidden":1,"is_offline":1,"is_draft":0,"sort_index":1,"id":2}', 'cms_nav', 2),
(2, 0, 1, 0, 0, 1470917683, '{"tableName":"cms_nav_item","action":"insert","row":2}', '{"lang_id":1,"title":"Page 1","alias":"page1","description":"Description of Page 1","nav_item_type":1,"nav_item_type_id":2,"nav_id":2,"timestamp_create":1470917683,"timestamp_update":0,"create_user_id":0,"update_user_id":0,"id":2}', 'cms_nav_item', 2),
(3, 0, 1, 0, 0, 1470917683, '{"tableName":"cms_nav","action":"insert","row":3}', '{"parent_nav_id":0,"nav_container_id":1,"is_hidden":1,"is_offline":1,"is_draft":0,"sort_index":3,"id":3}', 'cms_nav', 3),
(4, 0, 1, 0, 0, 1470917683, '{"tableName":"cms_nav_item","action":"insert","row":3}', '{"lang_id":1,"title":"Page 2","alias":"page2","description":"Description of Page 2","nav_item_type":1,"nav_item_type_id":3,"nav_id":3,"timestamp_create":1470917683,"timestamp_update":0,"create_user_id":0,"update_user_id":0,"id":3}', 'cms_nav_item', 3),
(5, 0, 1, 0, 0, 1470917683, '{"tableName":"cms_nav","action":"insert","row":4}', '{"parent_nav_id":0,"nav_container_id":1,"is_hidden":1,"is_offline":1,"is_draft":0,"sort_index":4,"id":4}', 'cms_nav', 4),
(6, 0, 1, 0, 0, 1470917683, '{"tableName":"cms_nav_item","action":"insert","row":4}', '{"lang_id":1,"title":"Page 3","alias":"page3","description":"Description of Page 3","nav_item_type":1,"nav_item_type_id":4,"nav_id":4,"timestamp_create":1470917683,"timestamp_update":0,"create_user_id":0,"update_user_id":0,"id":4}', 'cms_nav_item', 4),
(7, 0, 1, 0, 0, 1470917683, '{"tableName":"cms_nav","action":"insert","row":5}', '{"parent_nav_id":0,"nav_container_id":1,"is_hidden":1,"is_offline":1,"is_draft":0,"sort_index":5,"id":5}', 'cms_nav', 5),
(8, 0, 1, 0, 0, 1470917683, '{"tableName":"cms_nav_item","action":"insert","row":5}', '{"lang_id":1,"title":"Page 4","alias":"page4","description":"Description of Page 4","nav_item_type":1,"nav_item_type_id":5,"nav_id":5,"timestamp_create":1470917683,"timestamp_update":0,"create_user_id":0,"update_user_id":0,"id":5}', 'cms_nav_item', 5),
(9, 0, 1, 0, 0, 1470917683, '{"tableName":"cms_nav","action":"insert","row":6}', '{"parent_nav_id":0,"nav_container_id":1,"is_hidden":1,"is_offline":1,"is_draft":0,"sort_index":6,"id":6}', 'cms_nav', 6),
(10, 0, 1, 0, 0, 1470917683, '{"tableName":"cms_nav_item","action":"insert","row":6}', '{"lang_id":1,"title":"Page 5","alias":"page5","description":"Description of Page 5","nav_item_type":1,"nav_item_type_id":6,"nav_id":6,"timestamp_create":1470917683,"timestamp_update":0,"create_user_id":0,"update_user_id":0,"id":6}', 'cms_nav_item', 6),
(11, 0, 1, 0, 0, 1470917683, '{"tableName":"cms_nav","action":"insert","row":7}', '{"parent_nav_id":0,"nav_container_id":1,"is_hidden":1,"is_offline":1,"is_draft":0,"sort_index":7,"id":7}', 'cms_nav', 7),
(12, 0, 1, 0, 0, 1470917683, '{"tableName":"cms_nav_item","action":"insert","row":7}', '{"lang_id":1,"title":"Page 6","alias":"page6","description":"Description of Page 6","nav_item_type":1,"nav_item_type_id":7,"nav_id":7,"timestamp_create":1470917683,"timestamp_update":0,"create_user_id":0,"update_user_id":0,"id":7}', 'cms_nav_item', 7),
(13, 0, 1, 0, 0, 1470917683, '{"tableName":"cms_nav","action":"insert","row":8}', '{"parent_nav_id":2,"nav_container_id":1,"is_hidden":1,"is_offline":1,"is_draft":0,"sort_index":1,"id":8}', 'cms_nav', 8),
(14, 0, 1, 0, 0, 1470917683, '{"tableName":"cms_nav_item","action":"insert","row":8}', '{"lang_id":1,"title":"Page 1","alias":"p1-page1","description":"Description of Page 1","nav_item_type":1,"nav_item_type_id":8,"nav_id":8,"timestamp_create":1470917683,"timestamp_update":0,"create_user_id":0,"update_user_id":0,"id":8}', 'cms_nav_item', 8),
(15, 0, 1, 0, 0, 1470917683, '{"tableName":"cms_nav","action":"insert","row":9}', '{"parent_nav_id":2,"nav_container_id":1,"is_hidden":1,"is_offline":1,"is_draft":0,"sort_index":2,"id":9}', 'cms_nav', 9),
(16, 0, 1, 0, 0, 1470917683, '{"tableName":"cms_nav_item","action":"insert","row":9}', '{"lang_id":1,"title":"Page 2","alias":"p1-page2","description":"Description of Page 2","nav_item_type":1,"nav_item_type_id":9,"nav_id":9,"timestamp_create":1470917683,"timestamp_update":0,"create_user_id":0,"update_user_id":0,"id":9}', 'cms_nav_item', 9),
(17, 0, 1, 0, 0, 1470917683, '{"tableName":"cms_nav","action":"insert","row":10}', '{"parent_nav_id":2,"nav_container_id":1,"is_hidden":1,"is_offline":1,"is_draft":0,"sort_index":3,"id":10}', 'cms_nav', 10),
(18, 0, 1, 0, 0, 1470917683, '{"tableName":"cms_nav_item","action":"insert","row":10}', '{"lang_id":1,"title":"Page 3","alias":"p1-page3","description":"Description of Page 3","nav_item_type":1,"nav_item_type_id":10,"nav_id":10,"timestamp_create":1470917683,"timestamp_update":0,"create_user_id":0,"update_user_id":0,"id":10}', 'cms_nav_item', 10),
(19, 0, 1, 0, 0, 1470917683, '{"tableName":"cms_nav","action":"insert","row":11}', '{"parent_nav_id":2,"nav_container_id":1,"is_hidden":1,"is_offline":1,"is_draft":0,"sort_index":4,"id":11}', 'cms_nav', 11),
(20, 0, 1, 0, 0, 1470917683, '{"tableName":"cms_nav_item","action":"insert","row":11}', '{"lang_id":1,"title":"Page 4","alias":"p1-page4","description":"Description of Page 4","nav_item_type":1,"nav_item_type_id":11,"nav_id":11,"timestamp_create":1470917683,"timestamp_update":0,"create_user_id":0,"update_user_id":0,"id":11}', 'cms_nav_item', 11),
(21, 0, 1, 0, 0, 1470917684, '{"tableName":"cms_nav","action":"insert","row":12}', '{"parent_nav_id":2,"nav_container_id":1,"is_hidden":1,"is_offline":1,"is_draft":0,"sort_index":5,"id":12}', 'cms_nav', 12),
(22, 0, 1, 0, 0, 1470917684, '{"tableName":"cms_nav_item","action":"insert","row":12}', '{"lang_id":1,"title":"Page 5","alias":"p1-page5","description":"Description of Page 5","nav_item_type":1,"nav_item_type_id":12,"nav_id":12,"timestamp_create":1470917684,"timestamp_update":0,"create_user_id":0,"update_user_id":0,"id":12}', 'cms_nav_item', 12),
(23, 0, 1, 0, 0, 1470917684, '{"tableName":"cms_nav","action":"insert","row":13}', '{"parent_nav_id":2,"nav_container_id":1,"is_hidden":1,"is_offline":1,"is_draft":0,"sort_index":6,"id":13}', 'cms_nav', 13),
(24, 0, 1, 0, 0, 1470917684, '{"tableName":"cms_nav_item","action":"insert","row":13}', '{"lang_id":1,"title":"Page 6","alias":"p1-page6","description":"Description of Page 6","nav_item_type":1,"nav_item_type_id":13,"nav_id":13,"timestamp_create":1470917684,"timestamp_update":0,"create_user_id":0,"update_user_id":0,"id":13}', 'cms_nav_item', 13);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `cms_nav`
--

CREATE TABLE `cms_nav` (
  `id` int(11) NOT NULL,
  `nav_container_id` int(11) NOT NULL DEFAULT '0',
  `parent_nav_id` int(11) NOT NULL DEFAULT '0',
  `sort_index` int(11) NOT NULL DEFAULT '0',
  `is_deleted` tinyint(1) DEFAULT '0',
  `is_hidden` tinyint(1) DEFAULT '0',
  `is_offline` tinyint(1) DEFAULT '0',
  `is_home` tinyint(1) DEFAULT '0',
  `is_draft` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `cms_nav`
--

INSERT INTO `cms_nav` (`id`, `nav_container_id`, `parent_nav_id`, `sort_index`, `is_deleted`, `is_hidden`, `is_offline`, `is_home`, `is_draft`) VALUES
(1, 1, 0, 1, 0, 0, 0, 1, 0),
(2, 1, 0, 2, 0, 0, 0, 0, 0),
(3, 1, 0, 3, 0, 0, 0, 0, 0),
(4, 1, 0, 4, 0, 0, 0, 0, 0),
(5, 1, 0, 5, 0, 0, 0, 0, 0),
(6, 1, 0, 6, 0, 0, 0, 0, 0),
(7, 1, 0, 7, 0, 0, 0, 0, 0),
(8, 1, 2, 1, 0, 0, 0, 0, 0),
(9, 1, 2, 2, 0, 0, 0, 0, 0),
(10, 1, 2, 3, 0, 0, 0, 0, 0),
(11, 1, 2, 4, 0, 0, 0, 0, 0),
(12, 1, 2, 5, 0, 0, 0, 0, 0),
(13, 1, 2, 6, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `cms_nav_container`
--

CREATE TABLE `cms_nav_container` (
  `id` int(11) NOT NULL,
  `name` varchar(180) NOT NULL,
  `alias` varchar(80) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `cms_nav_container`
--

INSERT INTO `cms_nav_container` (`id`, `name`, `alias`, `is_deleted`) VALUES
(1, 'Default Container', 'default', 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `cms_nav_item`
--

CREATE TABLE `cms_nav_item` (
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
  `description` text,
  `keywords` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `cms_nav_item`
--

INSERT INTO `cms_nav_item` (`id`, `nav_id`, `lang_id`, `nav_item_type`, `nav_item_type_id`, `create_user_id`, `update_user_id`, `timestamp_create`, `timestamp_update`, `title`, `alias`, `description`, `keywords`) VALUES
(1, 1, 1, 1, 1, 1, 1, 1470917630, NULL, 'Homepage', 'homepage', NULL, NULL),
(2, 2, 1, 1, 2, 0, 0, 1470917683, 0, 'Page 1', 'page1', 'Description of Page 1', NULL),
(3, 3, 1, 1, 3, 0, 0, 1470917683, 0, 'Page 2', 'page2', 'Description of Page 2', NULL),
(4, 4, 1, 1, 4, 0, 0, 1470917683, 0, 'Page 3', 'page3', 'Description of Page 3', NULL),
(5, 5, 1, 1, 5, 0, 0, 1470917683, 0, 'Page 4', 'page4', 'Description of Page 4', NULL),
(6, 6, 1, 1, 6, 0, 0, 1470917683, 0, 'Page 5', 'page5', 'Description of Page 5', NULL),
(7, 7, 1, 1, 7, 0, 0, 1470917683, 0, 'Page 6', 'page6', 'Description of Page 6', NULL),
(8, 8, 1, 1, 8, 0, 0, 1470917683, 0, 'Page 1', 'p1-page1', 'Description of Page 1', NULL),
(9, 9, 1, 1, 9, 0, 0, 1470917683, 0, 'Page 2', 'p1-page2', 'Description of Page 2', NULL),
(10, 10, 1, 1, 10, 0, 0, 1470917683, 0, 'Page 3', 'p1-page3', 'Description of Page 3', NULL),
(11, 11, 1, 1, 11, 0, 0, 1470917683, 0, 'Page 4', 'p1-page4', 'Description of Page 4', NULL),
(12, 12, 1, 1, 12, 0, 0, 1470917684, 0, 'Page 5', 'p1-page5', 'Description of Page 5', NULL),
(13, 13, 1, 1, 13, 0, 0, 1470917684, 0, 'Page 6', 'p1-page6', 'Description of Page 6', NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `cms_nav_item_module`
--

CREATE TABLE `cms_nav_item_module` (
  `id` int(11) NOT NULL,
  `module_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `cms_nav_item_page`
--

CREATE TABLE `cms_nav_item_page` (
  `id` int(11) NOT NULL,
  `layout_id` int(11) DEFAULT NULL,
  `nav_item_id` int(11) NOT NULL,
  `timestamp_create` int(11) NOT NULL,
  `create_user_id` int(11) NOT NULL,
  `version_alias` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `cms_nav_item_page`
--

INSERT INTO `cms_nav_item_page` (`id`, `layout_id`, `nav_item_id`, `timestamp_create`, `create_user_id`, `version_alias`) VALUES
(1, 1, 1, 1470917630, 1, 'Initial'),
(2, 1, 2, 1470917683, 0, 'Initial'),
(3, 1, 3, 1470917683, 0, 'Initial'),
(4, 1, 4, 1470917683, 0, 'Initial'),
(5, 1, 5, 1470917683, 0, 'Initial'),
(6, 1, 6, 1470917683, 0, 'Initial'),
(7, 1, 7, 1470917683, 0, 'Initial'),
(8, 1, 8, 1470917683, 0, 'Initial'),
(9, 1, 9, 1470917683, 0, 'Initial'),
(10, 1, 10, 1470917683, 0, 'Initial'),
(11, 1, 11, 1470917683, 0, 'Initial'),
(12, 1, 12, 1470917684, 0, 'Initial'),
(13, 1, 13, 1470917684, 0, 'Initial');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `cms_nav_item_page_block_item`
--

CREATE TABLE `cms_nav_item_page_block_item` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `cms_nav_item_redirect`
--

CREATE TABLE `cms_nav_item_redirect` (
  `id` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `value` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `cms_nav_permission`
--

CREATE TABLE `cms_nav_permission` (
  `group_id` int(11) NOT NULL,
  `nav_id` int(11) NOT NULL,
  `inheritance` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `cms_nav_property`
--

CREATE TABLE `cms_nav_property` (
  `id` int(11) NOT NULL,
  `nav_id` int(11) NOT NULL,
  `admin_prop_id` int(11) NOT NULL,
  `value` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `migration`
--

CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1470917546),
('m141104_104622_admin_group', 1470917547),
('m141104_104631_admin_user_group', 1470917547),
('m141104_114809_admin_user', 1470917547),
('m141203_121042_admin_lang', 1470917547),
('m141203_143052_cms_cat', 1470917547),
('m141203_143059_cms_nav', 1470917547),
('m141203_143111_cms_nav_item', 1470917547),
('m141208_134038_cms_nav_item_page', 1470917547),
('m150106_095003_cms_layout', 1470917547),
('m150108_154017_cms_block', 1470917547),
('m150108_155009_cms_nav_item_page_block_item', 1470917547),
('m150122_125429_cms_nav_item_module', 1470917547),
('m150205_141350_block_group', 1470917547),
('m150304_152220_admin_storage_folder', 1470917547),
('m150304_152238_admin_storage_file', 1470917547),
('m150304_152244_admin_storage_filter', 1470917547),
('m150304_152250_admin_storage_effect', 1470917547),
('m150304_152256_admin_storage_image', 1470917547),
('m150309_142652_admin_storage_filter_chain', 1470917547),
('m150323_125407_admin_auth', 1470917548),
('m150323_132625_admin_group_auth', 1470917548),
('m150331_125022_admin_ngrest_log', 1470917548),
('m150615_094744_admin_user_login', 1470917548),
('m150617_200836_admin_user_online', 1470917548),
('m150626_084948_admin_search_data', 1470917548),
('m150915_081559_admin_config', 1470917548),
('m150922_134558_add_is_offline', 1470917548),
('m150924_112309_cms_nav_prop', 1470917548),
('m150924_120914_admin_prop', 1470917548),
('m151007_084953_storage_folder_is_deleted', 1470917548),
('m151007_113638_admin_file_use_socket', 1470917548),
('m151007_134149_admin_property_class_name', 1470917548),
('m151012_072207_cms_log', 1470917548),
('m151013_132217_login_secure_token', 1470917548),
('m151020_065710_user_force_reload', 1470917548),
('m151022_143429_cms_nav_item_redirect', 1470917548),
('m151026_161841_admin_tag', 1470917549),
('m151028_085932_add_is_home_in_nav', 1470917549),
('m151104_160421_remove_property_fields', 1470917549),
('m151110_113803_rename_rewrite_to_alias', 1470917549),
('m151110_114915_rename_cms_cat_to_cms_nav_container', 1470917549),
('m151116_105124_image_resolution_to_storage_image', 1470917549),
('m151123_114124_add_nav_item_description', 1470917549),
('m151126_090723_add_is_draft_for_nav', 1470917549),
('m151130_075456_block_is_hidden', 1470917549),
('m160329_085913_blockgroupfields', 1470917550),
('m160329_110559_navitemkeywords', 1470917550),
('m160331_075331_pageversiondata', 1470917550),
('m160412_083028_changedcmsproptype', 1470917550),
('m160602_125708_filemanagercaption', 1470917550),
('m160629_092417_cmspermissiontable', 1470917550),
('m160802_140548_add_user_settings_field', 1470917550),
('m160804_082037_cmslog_add_fields', 1470917550);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `admin_auth`
--
ALTER TABLE `admin_auth`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `admin_config`
--
ALTER TABLE `admin_config`
  ADD PRIMARY KEY (`name`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indizes für die Tabelle `admin_group`
--
ALTER TABLE `admin_group`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `admin_lang`
--
ALTER TABLE `admin_lang`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `admin_ngrest_log`
--
ALTER TABLE `admin_ngrest_log`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `admin_property`
--
ALTER TABLE `admin_property`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `var_name` (`var_name`);

--
-- Indizes für die Tabelle `admin_search_data`
--
ALTER TABLE `admin_search_data`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `admin_storage_effect`
--
ALTER TABLE `admin_storage_effect`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `identifier` (`identifier`);

--
-- Indizes für die Tabelle `admin_storage_file`
--
ALTER TABLE `admin_storage_file`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `admin_storage_filter`
--
ALTER TABLE `admin_storage_filter`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `identifier` (`identifier`);

--
-- Indizes für die Tabelle `admin_storage_filter_chain`
--
ALTER TABLE `admin_storage_filter_chain`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `admin_storage_folder`
--
ALTER TABLE `admin_storage_folder`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `admin_storage_image`
--
ALTER TABLE `admin_storage_image`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `admin_tag`
--
ALTER TABLE `admin_tag`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indizes für die Tabelle `admin_user`
--
ALTER TABLE `admin_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indizes für die Tabelle `admin_user_group`
--
ALTER TABLE `admin_user_group`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `admin_user_login`
--
ALTER TABLE `admin_user_login`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `admin_user_online`
--
ALTER TABLE `admin_user_online`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `cms_block`
--
ALTER TABLE `cms_block`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `cms_block_group`
--
ALTER TABLE `cms_block_group`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `cms_layout`
--
ALTER TABLE `cms_layout`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `cms_log`
--
ALTER TABLE `cms_log`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `cms_nav`
--
ALTER TABLE `cms_nav`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `cms_nav_container`
--
ALTER TABLE `cms_nav_container`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `cms_nav_item`
--
ALTER TABLE `cms_nav_item`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `cms_nav_item_module`
--
ALTER TABLE `cms_nav_item_module`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `cms_nav_item_page`
--
ALTER TABLE `cms_nav_item_page`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `cms_nav_item_page_block_item`
--
ALTER TABLE `cms_nav_item_page_block_item`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `cms_nav_item_redirect`
--
ALTER TABLE `cms_nav_item_redirect`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `cms_nav_property`
--
ALTER TABLE `cms_nav_property`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `admin_auth`
--
ALTER TABLE `admin_auth`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT für Tabelle `admin_group`
--
ALTER TABLE `admin_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT für Tabelle `admin_lang`
--
ALTER TABLE `admin_lang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT für Tabelle `admin_ngrest_log`
--
ALTER TABLE `admin_ngrest_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `admin_property`
--
ALTER TABLE `admin_property`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `admin_search_data`
--
ALTER TABLE `admin_search_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `admin_storage_effect`
--
ALTER TABLE `admin_storage_effect`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT für Tabelle `admin_storage_file`
--
ALTER TABLE `admin_storage_file`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `admin_storage_filter`
--
ALTER TABLE `admin_storage_filter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT für Tabelle `admin_storage_filter_chain`
--
ALTER TABLE `admin_storage_filter_chain`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT für Tabelle `admin_storage_folder`
--
ALTER TABLE `admin_storage_folder`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `admin_storage_image`
--
ALTER TABLE `admin_storage_image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `admin_tag`
--
ALTER TABLE `admin_tag`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `admin_user`
--
ALTER TABLE `admin_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT für Tabelle `admin_user_group`
--
ALTER TABLE `admin_user_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT für Tabelle `admin_user_login`
--
ALTER TABLE `admin_user_login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `admin_user_online`
--
ALTER TABLE `admin_user_online`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `cms_block`
--
ALTER TABLE `cms_block`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT für Tabelle `cms_block_group`
--
ALTER TABLE `cms_block_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT für Tabelle `cms_layout`
--
ALTER TABLE `cms_layout`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT für Tabelle `cms_log`
--
ALTER TABLE `cms_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT für Tabelle `cms_nav`
--
ALTER TABLE `cms_nav`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT für Tabelle `cms_nav_container`
--
ALTER TABLE `cms_nav_container`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT für Tabelle `cms_nav_item`
--
ALTER TABLE `cms_nav_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT für Tabelle `cms_nav_item_module`
--
ALTER TABLE `cms_nav_item_module`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `cms_nav_item_page`
--
ALTER TABLE `cms_nav_item_page`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT für Tabelle `cms_nav_item_page_block_item`
--
ALTER TABLE `cms_nav_item_page_block_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `cms_nav_item_redirect`
--
ALTER TABLE `cms_nav_item_redirect`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `cms_nav_property`
--
ALTER TABLE `cms_nav_property`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
