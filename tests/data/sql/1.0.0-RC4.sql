-- MySQL dump 10.13  Distrib 5.7.19, for Linux (x86_64)
--
-- Host: localhost    Database: luya_env_phpunit
-- ------------------------------------------------------
-- Server version	5.7.19-0ubuntu0.16.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `admin_auth`
--

DROP TABLE IF EXISTS `admin_auth`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_auth` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `alias_name` varchar(60) NOT NULL,
  `module_name` varchar(60) NOT NULL,
  `is_crud` tinyint(1) DEFAULT '0',
  `route` varchar(200) DEFAULT NULL,
  `api` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_auth`
--

LOCK TABLES `admin_auth` WRITE;
/*!40000 ALTER TABLE `admin_auth` DISABLE KEYS */;
INSERT INTO `admin_auth` VALUES (1,'module_permission_page_blocks','cmsadmin',1,'0','api-cms-navitempageblockitem'),(2,'menu_group_item_env_container','cmsadmin',1,'0','api-cms-navcontainer'),(3,'menu_group_item_env_layouts','cmsadmin',1,'0','api-cms-layout'),(4,'menu_group_item_elements_group','cmsadmin',1,'0','api-cms-blockgroup'),(5,'menu_group_item_elements_blocks','cmsadmin',1,'0','api-cms-block'),(6,'module_permission_add_new_page','cmsadmin',0,'cmsadmin/page/create','0'),(7,'module_permission_update_pages','cmsadmin',0,'cmsadmin/page/update','0'),(8,'module_permission_delete_pages','cmsadmin',0,'cmsadmin/page/delete','0'),(9,'module_permission_edit_drafts','cmsadmin',0,'cmsadmin/page/drafts','0'),(10,'menu_group_item_env_config','cmsadmin',0,'cmsadmin/config/index','0'),(11,'menu_node_cms','cmsadmin',0,'cmsadmin/default/index','0'),(12,'menu_group_item_env_permission','cmsadmin',0,'cmsadmin/permission/index','0'),(13,'menu_access_item_user','admin',1,'0','api-admin-user'),(14,'menu_access_item_group','admin',1,'0','api-admin-group'),(15,'menu_system_item_language','admin',1,'0','api-admin-lang'),(16,'menu_system_item_tags','admin',1,'0','api-admin-tag'),(17,'menu_system_logger','admin',1,'0','api-admin-logger'),(18,'menu_images_item_effects','admin',1,'0','api-admin-effect'),(19,'menu_images_item_filters','admin',1,'0','api-admin-filter'),(20,'Machines','admin',1,'0','api-admin-proxymachine'),(21,'Builds','admin',1,'0','api-admin-proxybuild'),(22,'menu_node_filemanager','admin',0,'admin/storage/index','0');
/*!40000 ALTER TABLE `admin_auth` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_config`
--

DROP TABLE IF EXISTS `admin_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_config` (
  `name` varchar(80) NOT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_config`
--

LOCK TABLES `admin_config` WRITE;
/*!40000 ALTER TABLE `admin_config` DISABLE KEYS */;
INSERT INTO `admin_config` VALUES ('last_import_timestamp','1504513122'),('setup_command_timestamp','1504513123');
/*!40000 ALTER TABLE `admin_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_group`
--

DROP TABLE IF EXISTS `admin_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `text` text,
  `is_deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_group`
--

LOCK TABLES `admin_group` WRITE;
/*!40000 ALTER TABLE `admin_group` DISABLE KEYS */;
INSERT INTO `admin_group` VALUES (1,'Administrator','Administrator Accounts have full access to all Areas and can create, update and delete all data records.',0);
/*!40000 ALTER TABLE `admin_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_group_auth`
--

DROP TABLE IF EXISTS `admin_group_auth`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_group_auth` (
  `group_id` int(11) DEFAULT NULL,
  `auth_id` int(11) DEFAULT NULL,
  `crud_create` smallint(4) DEFAULT NULL,
  `crud_update` smallint(4) DEFAULT NULL,
  `crud_delete` smallint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_group_auth`
--

LOCK TABLES `admin_group_auth` WRITE;
/*!40000 ALTER TABLE `admin_group_auth` DISABLE KEYS */;
INSERT INTO `admin_group_auth` VALUES (1,1,1,1,1),(1,2,1,1,1),(1,3,1,1,1),(1,4,1,1,1),(1,5,1,1,1),(1,6,1,1,1),(1,7,1,1,1),(1,8,1,1,1),(1,9,1,1,1),(1,10,1,1,1),(1,11,1,1,1),(1,12,1,1,1),(1,13,1,1,1),(1,14,1,1,1),(1,15,1,1,1),(1,16,1,1,1),(1,17,1,1,1),(1,18,1,1,1),(1,19,1,1,1),(1,20,1,1,1),(1,21,1,1,1),(1,22,1,1,1);
/*!40000 ALTER TABLE `admin_group_auth` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_lang`
--

DROP TABLE IF EXISTS `admin_lang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_lang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `short_code` varchar(15) DEFAULT NULL,
  `is_default` tinyint(1) DEFAULT '0',
  `is_deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_lang`
--

LOCK TABLES `admin_lang` WRITE;
/*!40000 ALTER TABLE `admin_lang` DISABLE KEYS */;
INSERT INTO `admin_lang` VALUES (1,'English','en',1,0),(2,'Deutsch','de',0,0);
/*!40000 ALTER TABLE `admin_lang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_logger`
--

DROP TABLE IF EXISTS `admin_logger`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_logger` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `time` int(11) NOT NULL,
  `message` text NOT NULL,
  `type` int(11) NOT NULL,
  `trace_file` varchar(255) DEFAULT NULL,
  `trace_line` varchar(255) DEFAULT NULL,
  `trace_function` varchar(255) DEFAULT NULL,
  `trace_function_args` text,
  `group_identifier` varchar(255) DEFAULT NULL,
  `group_identifier_index` int(11) DEFAULT NULL,
  `get` text,
  `post` text,
  `session` text,
  `server` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_logger`
--

LOCK TABLES `admin_logger` WRITE;
/*!40000 ALTER TABLE `admin_logger` DISABLE KEYS */;
/*!40000 ALTER TABLE `admin_logger` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_ngrest_log`
--

DROP TABLE IF EXISTS `admin_ngrest_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_ngrest_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `timestamp_create` int(11) NOT NULL,
  `route` varchar(80) NOT NULL,
  `api` varchar(80) NOT NULL,
  `is_update` tinyint(1) DEFAULT '0',
  `is_insert` tinyint(1) DEFAULT '0',
  `attributes_json` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_ngrest_log`
--

LOCK TABLES `admin_ngrest_log` WRITE;
/*!40000 ALTER TABLE `admin_ngrest_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `admin_ngrest_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_property`
--

DROP TABLE IF EXISTS `admin_property`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_property` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module_name` varchar(120) DEFAULT NULL,
  `var_name` varchar(40) NOT NULL,
  `class_name` varchar(200) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `var_name` (`var_name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_property`
--

LOCK TABLES `admin_property` WRITE;
/*!40000 ALTER TABLE `admin_property` DISABLE KEYS */;
/*!40000 ALTER TABLE `admin_property` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_proxy_build`
--

DROP TABLE IF EXISTS `admin_proxy_build`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_proxy_build` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `machine_id` int(11) NOT NULL,
  `timestamp` int(11) NOT NULL,
  `build_token` varchar(255) NOT NULL,
  `config` text NOT NULL,
  `is_complet` tinyint(1) DEFAULT '0',
  `expiration_time` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `build_token` (`build_token`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_proxy_build`
--

LOCK TABLES `admin_proxy_build` WRITE;
/*!40000 ALTER TABLE `admin_proxy_build` DISABLE KEYS */;
/*!40000 ALTER TABLE `admin_proxy_build` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_proxy_machine`
--

DROP TABLE IF EXISTS `admin_proxy_machine`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_proxy_machine` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `access_token` varchar(255) NOT NULL,
  `identifier` varchar(255) NOT NULL,
  `is_deleted` tinyint(1) DEFAULT '0',
  `is_disabled` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `identifier` (`identifier`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_proxy_machine`
--

LOCK TABLES `admin_proxy_machine` WRITE;
/*!40000 ALTER TABLE `admin_proxy_machine` DISABLE KEYS */;
/*!40000 ALTER TABLE `admin_proxy_machine` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_search_data`
--

DROP TABLE IF EXISTS `admin_search_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_search_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `timestamp_create` int(11) NOT NULL,
  `query` varchar(255) NOT NULL,
  `num_rows` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_search_data`
--

LOCK TABLES `admin_search_data` WRITE;
/*!40000 ALTER TABLE `admin_search_data` DISABLE KEYS */;
/*!40000 ALTER TABLE `admin_search_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_storage_effect`
--

DROP TABLE IF EXISTS `admin_storage_effect`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_storage_effect` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `identifier` varchar(100) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `imagine_name` varchar(255) DEFAULT NULL,
  `imagine_json_params` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `identifier` (`identifier`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_storage_effect`
--

LOCK TABLES `admin_storage_effect` WRITE;
/*!40000 ALTER TABLE `admin_storage_effect` DISABLE KEYS */;
INSERT INTO `admin_storage_effect` VALUES (1,'thumbnail','Thumbnail','thumbnail','{\"vars\":[{\"var\":\"width\",\"label\":\"Breit in Pixel\"},{\"var\":\"height\",\"label\":\"Hoehe in Pixel\"},{\"var\":\"mode\",\"label\":\"outbound or inset\"},{\"var\":\"saveOptions\",\"label\":\"save options\"}]}'),(2,'crop','Crop','crop','{\"vars\":[{\"var\":\"width\",\"label\":\"Breit in Pixel\"},{\"var\":\"height\",\"label\":\"Hoehe in Pixel\"},{\"var\":\"saveOptions\",\"label\":\"save options\"}]}');
/*!40000 ALTER TABLE `admin_storage_effect` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_storage_file`
--

DROP TABLE IF EXISTS `admin_storage_file`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_storage_file` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `is_hidden` tinyint(1) DEFAULT '0',
  `folder_id` int(11) DEFAULT '0',
  `name_original` varchar(255) DEFAULT NULL,
  `name_new` varchar(255) DEFAULT NULL,
  `name_new_compound` varchar(255) DEFAULT NULL,
  `mime_type` varchar(255) DEFAULT NULL,
  `extension` varchar(255) DEFAULT NULL,
  `hash_file` varchar(255) DEFAULT NULL,
  `hash_name` varchar(255) DEFAULT NULL,
  `upload_timestamp` int(11) DEFAULT NULL,
  `file_size` int(11) DEFAULT '0',
  `upload_user_id` int(11) DEFAULT '0',
  `is_deleted` tinyint(1) DEFAULT '0',
  `passthrough_file` tinyint(1) DEFAULT '0',
  `passthrough_file_password` varchar(40) DEFAULT NULL,
  `passthrough_file_stats` int(11) DEFAULT '0',
  `caption` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_storage_file`
--

LOCK TABLES `admin_storage_file` WRITE;
/*!40000 ALTER TABLE `admin_storage_file` DISABLE KEYS */;
/*!40000 ALTER TABLE `admin_storage_file` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_storage_filter`
--

DROP TABLE IF EXISTS `admin_storage_filter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_storage_filter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `identifier` varchar(100) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `identifier` (`identifier`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_storage_filter`
--

LOCK TABLES `admin_storage_filter` WRITE;
/*!40000 ALTER TABLE `admin_storage_filter` DISABLE KEYS */;
INSERT INTO `admin_storage_filter` VALUES (1,'large-crop','Crop large (800x800)'),(2,'large-thumbnail','Thumbnail large (800xnull)'),(3,'medium-crop','Crop medium (300x300)'),(4,'medium-thumbnail','Thumbnail medium (300xnull)'),(5,'small-crop','Crop small (100x100)'),(6,'small-landscape','Landscape small (150x50)'),(7,'small-thumbnail','Thumbnail small (100xnull)'),(8,'tiny-crop','Crop tiny (40x40)'),(9,'tiny-thumbnail','Thumbnail tiny (40xnull)');
/*!40000 ALTER TABLE `admin_storage_filter` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_storage_filter_chain`
--

DROP TABLE IF EXISTS `admin_storage_filter_chain`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_storage_filter_chain` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sort_index` int(11) DEFAULT NULL,
  `filter_id` int(11) DEFAULT NULL,
  `effect_id` int(11) DEFAULT NULL,
  `effect_json_values` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_storage_filter_chain`
--

LOCK TABLES `admin_storage_filter_chain` WRITE;
/*!40000 ALTER TABLE `admin_storage_filter_chain` DISABLE KEYS */;
INSERT INTO `admin_storage_filter_chain` VALUES (1,NULL,1,1,'{\"width\":800,\"height\":800}'),(2,NULL,2,1,'{\"width\":800,\"height\":null}'),(3,NULL,3,1,'{\"width\":300,\"height\":300}'),(4,NULL,4,1,'{\"width\":300,\"height\":null}'),(5,NULL,5,1,'{\"width\":100,\"height\":100}'),(6,NULL,6,1,'{\"width\":150,\"height\":50}'),(7,NULL,7,1,'{\"width\":100,\"height\":null}'),(8,NULL,8,1,'{\"width\":40,\"height\":40}'),(9,NULL,9,1,'{\"width\":40,\"height\":null}');
/*!40000 ALTER TABLE `admin_storage_filter_chain` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_storage_folder`
--

DROP TABLE IF EXISTS `admin_storage_folder`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_storage_folder` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `timestamp_create` int(11) DEFAULT NULL,
  `is_deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_storage_folder`
--

LOCK TABLES `admin_storage_folder` WRITE;
/*!40000 ALTER TABLE `admin_storage_folder` DISABLE KEYS */;
/*!40000 ALTER TABLE `admin_storage_folder` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_storage_image`
--

DROP TABLE IF EXISTS `admin_storage_image`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_storage_image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file_id` int(11) DEFAULT NULL,
  `filter_id` int(11) DEFAULT NULL,
  `resolution_width` int(11) DEFAULT NULL,
  `resolution_height` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_storage_image`
--

LOCK TABLES `admin_storage_image` WRITE;
/*!40000 ALTER TABLE `admin_storage_image` DISABLE KEYS */;
/*!40000 ALTER TABLE `admin_storage_image` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_tag`
--

DROP TABLE IF EXISTS `admin_tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(120) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_tag`
--

LOCK TABLES `admin_tag` WRITE;
/*!40000 ALTER TABLE `admin_tag` DISABLE KEYS */;
/*!40000 ALTER TABLE `admin_tag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_tag_relation`
--

DROP TABLE IF EXISTS `admin_tag_relation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_tag_relation` (
  `tag_id` int(11) NOT NULL,
  `table_name` varchar(120) NOT NULL,
  `pk_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_tag_relation`
--

LOCK TABLES `admin_tag_relation` WRITE;
/*!40000 ALTER TABLE `admin_tag_relation` DISABLE KEYS */;
/*!40000 ALTER TABLE `admin_tag_relation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_user`
--

DROP TABLE IF EXISTS `admin_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `title` smallint(1) DEFAULT NULL,
  `email` varchar(120) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `password_salt` varchar(255) DEFAULT NULL,
  `auth_token` varchar(255) DEFAULT NULL,
  `is_deleted` tinyint(1) DEFAULT '0',
  `secure_token` varchar(40) DEFAULT NULL,
  `secure_token_timestamp` int(11) DEFAULT '0',
  `force_reload` tinyint(1) DEFAULT '0',
  `settings` text,
  `cookie_token` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_user`
--

LOCK TABLES `admin_user` WRITE;
/*!40000 ALTER TABLE `admin_user` DISABLE KEYS */;
INSERT INTO `admin_user` VALUES (1,'John','Doe',1,'test@luya.io','$2y$13$Uo4AWQ8ihEHXOAQ5TDYx0.qM8tjtrSy7so9oAXCRaVgaQSZUeloGG','5hNDWRhJkvSyMifp4LVC-Hk8_f5bGD9s',NULL,0,NULL,0,0,NULL,NULL);
/*!40000 ALTER TABLE `admin_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_user_group`
--

DROP TABLE IF EXISTS `admin_user_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_user_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_user_group`
--

LOCK TABLES `admin_user_group` WRITE;
/*!40000 ALTER TABLE `admin_user_group` DISABLE KEYS */;
INSERT INTO `admin_user_group` VALUES (1,1,1);
/*!40000 ALTER TABLE `admin_user_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_user_login`
--

DROP TABLE IF EXISTS `admin_user_login`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_user_login` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `timestamp_create` int(11) NOT NULL,
  `auth_token` varchar(120) NOT NULL,
  `ip` varchar(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_user_login`
--

LOCK TABLES `admin_user_login` WRITE;
/*!40000 ALTER TABLE `admin_user_login` DISABLE KEYS */;
/*!40000 ALTER TABLE `admin_user_login` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_user_online`
--

DROP TABLE IF EXISTS `admin_user_online`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_user_online` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `last_timestamp` int(11) NOT NULL,
  `invoken_route` varchar(120) NOT NULL,
  `lock_pk` varchar(255) DEFAULT NULL,
  `lock_table` varchar(255) DEFAULT NULL,
  `lock_translation` varchar(255) DEFAULT NULL,
  `lock_translation_args` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_user_online`
--

LOCK TABLES `admin_user_online` WRITE;
/*!40000 ALTER TABLE `admin_user_online` DISABLE KEYS */;
/*!40000 ALTER TABLE `admin_user_online` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_block`
--

DROP TABLE IF EXISTS `cms_block`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_block` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `class` varchar(255) NOT NULL,
  `is_disabled` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_block`
--

LOCK TABLES `cms_block` WRITE;
/*!40000 ALTER TABLE `cms_block` DISABLE KEYS */;
INSERT INTO `cms_block` VALUES (1,4,'\\luya\\cms\\frontend\\blocks\\AudioBlock',0),(2,1,'\\luya\\cms\\frontend\\blocks\\DevBlock',0),(3,3,'\\luya\\cms\\frontend\\blocks\\FileListBlock',0),(4,3,'\\luya\\cms\\frontend\\blocks\\FormBlock',0),(5,1,'\\luya\\cms\\frontend\\blocks\\HtmlBlock',0),(6,4,'\\luya\\cms\\frontend\\blocks\\ImageBlock',0),(7,4,'\\luya\\cms\\frontend\\blocks\\ImageTextBlock',0),(8,2,'\\luya\\cms\\frontend\\blocks\\LayoutBlock',0),(9,3,'\\luya\\cms\\frontend\\blocks\\LineBlock',0),(10,3,'\\luya\\cms\\frontend\\blocks\\LinkButtonBlock',0),(11,6,'\\luya\\cms\\frontend\\blocks\\ListBlock',0),(12,3,'\\luya\\cms\\frontend\\blocks\\MapBlock',0),(13,1,'\\luya\\cms\\frontend\\blocks\\ModuleBlock',0),(14,6,'\\luya\\cms\\frontend\\blocks\\QuoteBlock',0),(15,3,'\\luya\\cms\\frontend\\blocks\\SpacingBlock',0),(16,3,'\\luya\\cms\\frontend\\blocks\\TableBlock',0),(17,6,'\\luya\\cms\\frontend\\blocks\\TextBlock',0),(18,6,'\\luya\\cms\\frontend\\blocks\\TitleBlock',0),(19,4,'\\luya\\cms\\frontend\\blocks\\VideoBlock',0),(20,6,'\\luya\\cms\\frontend\\blocks\\WysiwygBlock',0);
/*!40000 ALTER TABLE `cms_block` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_block_group`
--

DROP TABLE IF EXISTS `cms_block_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_block_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `is_deleted` tinyint(1) DEFAULT '0',
  `identifier` varchar(120) NOT NULL,
  `created_timestamp` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_block_group`
--

LOCK TABLES `cms_block_group` WRITE;
/*!40000 ALTER TABLE `cms_block_group` DISABLE KEYS */;
INSERT INTO `cms_block_group` VALUES (1,'block_group_dev_elements',0,'development-group',1504513122),(2,'block_group_layout_elements',0,'layout-group',1504513122),(3,'block_group_basic_elements',0,'main-group',1504513122),(4,'block_group_media_group',0,'media-group',1504513122),(5,'block_group_project_elements',0,'project-group',1504513122),(6,'block_group_text_elements',0,'text-group',1504513122);
/*!40000 ALTER TABLE `cms_block_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_config`
--

DROP TABLE IF EXISTS `cms_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_config` (
  `name` varchar(80) NOT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_config`
--

LOCK TABLES `cms_config` WRITE;
/*!40000 ALTER TABLE `cms_config` DISABLE KEYS */;
/*!40000 ALTER TABLE `cms_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_layout`
--

DROP TABLE IF EXISTS `cms_layout`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_layout` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `json_config` text,
  `view_file` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_layout`
--

LOCK TABLES `cms_layout` WRITE;
/*!40000 ALTER TABLE `cms_layout` DISABLE KEYS */;
INSERT INTO `cms_layout` VALUES (1,'Main','{\"placeholders\":[[{\"label\":\"Content\",\"var\":\"content\"}]]}','main.php'),(2,'Sidebar','{\"placeholders\":[[{\"label\":\"Content\",\"var\":\"content\"},{\"label\":\"Sidebar\",\"var\":\"sidebar\"}]]}','sidebar.php');
/*!40000 ALTER TABLE `cms_layout` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_log`
--

DROP TABLE IF EXISTS `cms_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT '0',
  `is_insertion` tinyint(1) DEFAULT '0',
  `is_update` tinyint(1) DEFAULT '0',
  `is_deletion` tinyint(1) DEFAULT '0',
  `timestamp` int(11) NOT NULL,
  `message` varchar(255) DEFAULT NULL,
  `data_json` text,
  `table_name` varchar(120) DEFAULT NULL,
  `row_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_log`
--

LOCK TABLES `cms_log` WRITE;
/*!40000 ALTER TABLE `cms_log` DISABLE KEYS */;
INSERT INTO `cms_log` VALUES (1,0,1,0,0,1504513123,'{\"tableName\":\"cms_nav\",\"action\":\"insert\",\"row\":2}','{\"parent_nav_id\":0,\"nav_container_id\":1,\"is_hidden\":true,\"is_offline\":true,\"is_draft\":0,\"sort_index\":1,\"id\":2}','cms_nav',2),(2,0,1,0,0,1504513123,'{\"tableName\":\"cms_nav_item\",\"action\":\"insert\",\"row\":2}','{\"lang_id\":1,\"title\":\"Page 1\",\"alias\":\"page1\",\"description\":\"Description of Page 1\",\"nav_item_type\":1,\"nav_item_type_id\":2,\"nav_id\":2,\"timestamp_create\":1504513123,\"timestamp_update\":0,\"create_user_id\":1,\"update_user_id\":1,\"id\":2}','cms_nav_item',2),(3,0,1,0,0,1504513123,'{\"tableName\":\"cms_nav\",\"action\":\"insert\",\"row\":3}','{\"parent_nav_id\":0,\"nav_container_id\":1,\"is_hidden\":true,\"is_offline\":true,\"is_draft\":0,\"sort_index\":3,\"id\":3}','cms_nav',3),(4,0,1,0,0,1504513123,'{\"tableName\":\"cms_nav_item\",\"action\":\"insert\",\"row\":3}','{\"lang_id\":1,\"title\":\"Page 2\",\"alias\":\"page2\",\"description\":\"Description of Page 2\",\"nav_item_type\":1,\"nav_item_type_id\":3,\"nav_id\":3,\"timestamp_create\":1504513123,\"timestamp_update\":0,\"create_user_id\":1,\"update_user_id\":1,\"id\":3}','cms_nav_item',3),(5,0,1,0,0,1504513123,'{\"tableName\":\"cms_nav\",\"action\":\"insert\",\"row\":4}','{\"parent_nav_id\":0,\"nav_container_id\":1,\"is_hidden\":true,\"is_offline\":true,\"is_draft\":0,\"sort_index\":4,\"id\":4}','cms_nav',4),(6,0,1,0,0,1504513123,'{\"tableName\":\"cms_nav_item\",\"action\":\"insert\",\"row\":4}','{\"lang_id\":1,\"title\":\"Page 3\",\"alias\":\"page3\",\"description\":\"Description of Page 3\",\"nav_item_type\":1,\"nav_item_type_id\":4,\"nav_id\":4,\"timestamp_create\":1504513123,\"timestamp_update\":0,\"create_user_id\":1,\"update_user_id\":1,\"id\":4}','cms_nav_item',4),(7,0,1,0,0,1504513123,'{\"tableName\":\"cms_nav\",\"action\":\"insert\",\"row\":5}','{\"parent_nav_id\":0,\"nav_container_id\":1,\"is_hidden\":true,\"is_offline\":true,\"is_draft\":0,\"sort_index\":5,\"id\":5}','cms_nav',5),(8,0,1,0,0,1504513123,'{\"tableName\":\"cms_nav_item\",\"action\":\"insert\",\"row\":5}','{\"lang_id\":1,\"title\":\"Page 4\",\"alias\":\"page4\",\"description\":\"Description of Page 4\",\"nav_item_type\":1,\"nav_item_type_id\":5,\"nav_id\":5,\"timestamp_create\":1504513123,\"timestamp_update\":0,\"create_user_id\":1,\"update_user_id\":1,\"id\":5}','cms_nav_item',5),(9,0,1,0,0,1504513123,'{\"tableName\":\"cms_nav\",\"action\":\"insert\",\"row\":6}','{\"parent_nav_id\":0,\"nav_container_id\":1,\"is_hidden\":true,\"is_offline\":true,\"is_draft\":0,\"sort_index\":6,\"id\":6}','cms_nav',6),(10,0,1,0,0,1504513123,'{\"tableName\":\"cms_nav_item\",\"action\":\"insert\",\"row\":6}','{\"lang_id\":1,\"title\":\"Page 5\",\"alias\":\"page5\",\"description\":\"Description of Page 5\",\"nav_item_type\":1,\"nav_item_type_id\":6,\"nav_id\":6,\"timestamp_create\":1504513123,\"timestamp_update\":0,\"create_user_id\":1,\"update_user_id\":1,\"id\":6}','cms_nav_item',6),(11,0,1,0,0,1504513123,'{\"tableName\":\"cms_nav\",\"action\":\"insert\",\"row\":7}','{\"parent_nav_id\":0,\"nav_container_id\":1,\"is_hidden\":true,\"is_offline\":true,\"is_draft\":0,\"sort_index\":7,\"id\":7}','cms_nav',7),(12,0,1,0,0,1504513123,'{\"tableName\":\"cms_nav_item\",\"action\":\"insert\",\"row\":7}','{\"lang_id\":1,\"title\":\"Page 6\",\"alias\":\"page6\",\"description\":\"Description of Page 6\",\"nav_item_type\":1,\"nav_item_type_id\":7,\"nav_id\":7,\"timestamp_create\":1504513123,\"timestamp_update\":0,\"create_user_id\":1,\"update_user_id\":1,\"id\":7}','cms_nav_item',7),(13,0,1,0,0,1504513123,'{\"tableName\":\"cms_nav\",\"action\":\"insert\",\"row\":8}','{\"parent_nav_id\":2,\"nav_container_id\":1,\"is_hidden\":true,\"is_offline\":true,\"is_draft\":0,\"sort_index\":1,\"id\":8}','cms_nav',8),(14,0,1,0,0,1504513123,'{\"tableName\":\"cms_nav_item\",\"action\":\"insert\",\"row\":8}','{\"lang_id\":1,\"title\":\"Page 1\",\"alias\":\"p1-page1\",\"description\":\"Description of Page 1\",\"nav_item_type\":1,\"nav_item_type_id\":8,\"nav_id\":8,\"timestamp_create\":1504513123,\"timestamp_update\":0,\"create_user_id\":1,\"update_user_id\":1,\"id\":8}','cms_nav_item',8),(15,0,1,0,0,1504513123,'{\"tableName\":\"cms_nav\",\"action\":\"insert\",\"row\":9}','{\"parent_nav_id\":2,\"nav_container_id\":1,\"is_hidden\":true,\"is_offline\":true,\"is_draft\":0,\"sort_index\":2,\"id\":9}','cms_nav',9),(16,0,1,0,0,1504513123,'{\"tableName\":\"cms_nav_item\",\"action\":\"insert\",\"row\":9}','{\"lang_id\":1,\"title\":\"Page 2\",\"alias\":\"p1-page2\",\"description\":\"Description of Page 2\",\"nav_item_type\":1,\"nav_item_type_id\":9,\"nav_id\":9,\"timestamp_create\":1504513123,\"timestamp_update\":0,\"create_user_id\":1,\"update_user_id\":1,\"id\":9}','cms_nav_item',9),(17,0,1,0,0,1504513123,'{\"tableName\":\"cms_nav\",\"action\":\"insert\",\"row\":10}','{\"parent_nav_id\":2,\"nav_container_id\":1,\"is_hidden\":true,\"is_offline\":true,\"is_draft\":0,\"sort_index\":3,\"id\":10}','cms_nav',10),(18,0,1,0,0,1504513123,'{\"tableName\":\"cms_nav_item\",\"action\":\"insert\",\"row\":10}','{\"lang_id\":1,\"title\":\"Page 3\",\"alias\":\"p1-page3\",\"description\":\"Description of Page 3\",\"nav_item_type\":1,\"nav_item_type_id\":10,\"nav_id\":10,\"timestamp_create\":1504513123,\"timestamp_update\":0,\"create_user_id\":1,\"update_user_id\":1,\"id\":10}','cms_nav_item',10),(19,0,1,0,0,1504513123,'{\"tableName\":\"cms_nav\",\"action\":\"insert\",\"row\":11}','{\"parent_nav_id\":2,\"nav_container_id\":1,\"is_hidden\":true,\"is_offline\":true,\"is_draft\":0,\"sort_index\":4,\"id\":11}','cms_nav',11),(20,0,1,0,0,1504513123,'{\"tableName\":\"cms_nav_item\",\"action\":\"insert\",\"row\":11}','{\"lang_id\":1,\"title\":\"Page 4\",\"alias\":\"p1-page4\",\"description\":\"Description of Page 4\",\"nav_item_type\":1,\"nav_item_type_id\":11,\"nav_id\":11,\"timestamp_create\":1504513123,\"timestamp_update\":0,\"create_user_id\":1,\"update_user_id\":1,\"id\":11}','cms_nav_item',11),(21,0,1,0,0,1504513123,'{\"tableName\":\"cms_nav\",\"action\":\"insert\",\"row\":12}','{\"parent_nav_id\":2,\"nav_container_id\":1,\"is_hidden\":true,\"is_offline\":true,\"is_draft\":0,\"sort_index\":5,\"id\":12}','cms_nav',12),(22,0,1,0,0,1504513123,'{\"tableName\":\"cms_nav_item\",\"action\":\"insert\",\"row\":12}','{\"lang_id\":1,\"title\":\"Page 5\",\"alias\":\"p1-page5\",\"description\":\"Description of Page 5\",\"nav_item_type\":1,\"nav_item_type_id\":12,\"nav_id\":12,\"timestamp_create\":1504513123,\"timestamp_update\":0,\"create_user_id\":1,\"update_user_id\":1,\"id\":12}','cms_nav_item',12),(23,0,1,0,0,1504513124,'{\"tableName\":\"cms_nav\",\"action\":\"insert\",\"row\":13}','{\"parent_nav_id\":2,\"nav_container_id\":1,\"is_hidden\":true,\"is_offline\":true,\"is_draft\":0,\"sort_index\":6,\"id\":13}','cms_nav',13),(24,0,1,0,0,1504513124,'{\"tableName\":\"cms_nav_item\",\"action\":\"insert\",\"row\":13}','{\"lang_id\":1,\"title\":\"Page 6\",\"alias\":\"p1-page6\",\"description\":\"Description of Page 6\",\"nav_item_type\":1,\"nav_item_type_id\":13,\"nav_id\":13,\"timestamp_create\":1504513124,\"timestamp_update\":0,\"create_user_id\":1,\"update_user_id\":1,\"id\":13}','cms_nav_item',13),(25,0,1,0,0,1504513124,'{\"tableName\":\"cms_nav\",\"action\":\"insert\",\"row\":14}','{\"parent_nav_id\":0,\"nav_container_id\":1,\"is_hidden\":true,\"is_offline\":true,\"sort_index\":8,\"id\":14}','cms_nav',14),(26,0,1,0,0,1504513124,'{\"tableName\":\"cms_nav_item\",\"action\":\"insert\",\"row\":14}','{\"lang_id\":1,\"title\":\"Redirect to Page 1\",\"alias\":\"redirect-1\",\"description\":\"Description of Redirect to Page 1\",\"nav_item_type\":3,\"nav_item_type_id\":1,\"nav_id\":14,\"timestamp_create\":1504513124,\"timestamp_update\":0,\"create_user_id\":1,\"update_user_id\":1,\"id\":14}','cms_nav_item',14),(27,0,1,0,0,1504513124,'{\"tableName\":\"cms_nav\",\"action\":\"insert\",\"row\":15}','{\"parent_nav_id\":0,\"nav_container_id\":1,\"is_hidden\":true,\"is_offline\":true,\"sort_index\":9,\"id\":15}','cms_nav',15),(28,0,1,0,0,1504513124,'{\"tableName\":\"cms_nav_item\",\"action\":\"insert\",\"row\":15}','{\"lang_id\":1,\"title\":\"Redirect to Page 2\",\"alias\":\"redirect-2\",\"description\":\"Description of Redirect to Page 2\",\"nav_item_type\":3,\"nav_item_type_id\":2,\"nav_id\":15,\"timestamp_create\":1504513124,\"timestamp_update\":0,\"create_user_id\":1,\"update_user_id\":1,\"id\":15}','cms_nav_item',15),(29,0,1,0,0,1504513124,'{\"tableName\":\"cms_nav\",\"action\":\"insert\",\"row\":16}','{\"parent_nav_id\":0,\"nav_container_id\":1,\"is_hidden\":true,\"is_offline\":true,\"sort_index\":10,\"id\":16}','cms_nav',16),(30,0,1,0,0,1504513124,'{\"tableName\":\"cms_nav_item\",\"action\":\"insert\",\"row\":16}','{\"lang_id\":1,\"title\":\"Redirect to Sub Page 2\",\"alias\":\"redirect-3\",\"description\":\"Description of Redirect to Sub Page 2\",\"nav_item_type\":3,\"nav_item_type_id\":3,\"nav_id\":16,\"timestamp_create\":1504513124,\"timestamp_update\":0,\"create_user_id\":1,\"update_user_id\":1,\"id\":16}','cms_nav_item',16),(31,0,1,0,0,1504513124,'{\"tableName\":\"cms_nav\",\"action\":\"insert\",\"row\":17}','{\"parent_nav_id\":0,\"nav_container_id\":1,\"is_hidden\":true,\"is_offline\":true,\"sort_index\":11,\"id\":17}','cms_nav',17),(32,0,1,0,0,1504513124,'{\"tableName\":\"cms_nav_item\",\"action\":\"insert\",\"row\":17}','{\"lang_id\":1,\"title\":\"Redirect to luya.io\",\"alias\":\"redirect-4\",\"description\":\"Description of Redirect to luya.io\",\"nav_item_type\":3,\"nav_item_type_id\":4,\"nav_id\":17,\"timestamp_create\":1504513124,\"timestamp_update\":0,\"create_user_id\":1,\"update_user_id\":1,\"id\":17}','cms_nav_item',17);
/*!40000 ALTER TABLE `cms_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_nav`
--

DROP TABLE IF EXISTS `cms_nav`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_nav` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nav_container_id` int(11) NOT NULL,
  `parent_nav_id` int(11) NOT NULL,
  `sort_index` int(11) NOT NULL,
  `is_deleted` tinyint(1) DEFAULT '0',
  `is_hidden` tinyint(1) DEFAULT '0',
  `is_home` tinyint(1) DEFAULT '0',
  `is_offline` tinyint(1) DEFAULT '0',
  `is_draft` tinyint(1) DEFAULT '0',
  `layout_file` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_nav`
--

LOCK TABLES `cms_nav` WRITE;
/*!40000 ALTER TABLE `cms_nav` DISABLE KEYS */;
INSERT INTO `cms_nav` VALUES (1,1,0,1,0,0,1,0,0,NULL),(2,1,0,2,0,0,0,0,0,NULL),(3,1,0,3,0,0,0,0,0,NULL),(4,1,0,4,0,0,0,0,0,NULL),(5,1,0,5,0,0,0,0,0,NULL),(6,1,0,6,0,0,0,0,0,NULL),(7,1,0,7,0,0,0,0,0,NULL),(8,1,2,1,0,0,0,0,0,NULL),(9,1,2,2,0,0,0,0,0,NULL),(10,1,2,3,0,0,0,0,0,NULL),(11,1,2,4,0,0,0,0,0,NULL),(12,1,2,5,0,0,0,0,0,NULL),(13,1,2,6,0,0,0,0,0,NULL),(14,1,0,8,0,0,0,0,0,NULL),(15,1,0,9,0,0,0,0,0,NULL),(16,1,0,10,0,0,0,0,0,NULL),(17,1,0,11,0,0,0,0,0,NULL);
/*!40000 ALTER TABLE `cms_nav` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_nav_container`
--

DROP TABLE IF EXISTS `cms_nav_container`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_nav_container` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(180) NOT NULL,
  `alias` varchar(180) NOT NULL,
  `is_deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_nav_container`
--

LOCK TABLES `cms_nav_container` WRITE;
/*!40000 ALTER TABLE `cms_nav_container` DISABLE KEYS */;
INSERT INTO `cms_nav_container` VALUES (1,'Default Container','default',0);
/*!40000 ALTER TABLE `cms_nav_container` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_nav_item`
--

DROP TABLE IF EXISTS `cms_nav_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_nav_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nav_id` int(11) NOT NULL,
  `lang_id` int(11) NOT NULL,
  `nav_item_type` int(11) NOT NULL,
  `nav_item_type_id` int(11) NOT NULL,
  `create_user_id` int(11) NOT NULL,
  `update_user_id` int(11) NOT NULL,
  `timestamp_create` int(11) DEFAULT '0',
  `timestamp_update` int(11) DEFAULT '0',
  `title` varchar(180) NOT NULL,
  `alias` varchar(80) NOT NULL,
  `description` text,
  `keywords` text,
  `title_tag` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_nav_item`
--

LOCK TABLES `cms_nav_item` WRITE;
/*!40000 ALTER TABLE `cms_nav_item` DISABLE KEYS */;
INSERT INTO `cms_nav_item` VALUES (1,1,1,1,1,1,1,1504513123,0,'Homepage','homepage',NULL,NULL,NULL),(2,2,1,1,2,1,1,1504513123,0,'Page 1','page1','Description of Page 1',NULL,NULL),(3,3,1,1,3,1,1,1504513123,0,'Page 2','page2','Description of Page 2',NULL,NULL),(4,4,1,1,4,1,1,1504513123,0,'Page 3','page3','Description of Page 3',NULL,NULL),(5,5,1,1,5,1,1,1504513123,0,'Page 4','page4','Description of Page 4',NULL,NULL),(6,6,1,1,6,1,1,1504513123,0,'Page 5','page5','Description of Page 5',NULL,NULL),(7,7,1,1,7,1,1,1504513123,0,'Page 6','page6','Description of Page 6',NULL,NULL),(8,8,1,1,8,1,1,1504513123,0,'Page 1','p1-page1','Description of Page 1',NULL,NULL),(9,9,1,1,9,1,1,1504513123,0,'Page 2','p1-page2','Description of Page 2',NULL,NULL),(10,10,1,1,10,1,1,1504513123,0,'Page 3','p1-page3','Description of Page 3',NULL,NULL),(11,11,1,1,11,1,1,1504513123,0,'Page 4','p1-page4','Description of Page 4',NULL,NULL),(12,12,1,1,12,1,1,1504513123,0,'Page 5','p1-page5','Description of Page 5',NULL,NULL),(13,13,1,1,13,1,1,1504513124,0,'Page 6','p1-page6','Description of Page 6',NULL,NULL),(14,14,1,3,1,1,1,1504513124,0,'Redirect to Page 1','redirect-1','Description of Redirect to Page 1',NULL,NULL),(15,15,1,3,2,1,1,1504513124,0,'Redirect to Page 2','redirect-2','Description of Redirect to Page 2',NULL,NULL),(16,16,1,3,3,1,1,1504513124,0,'Redirect to Sub Page 2','redirect-3','Description of Redirect to Sub Page 2',NULL,NULL),(17,17,1,3,4,1,1,1504513124,0,'Redirect to luya.io','redirect-4','Description of Redirect to luya.io',NULL,NULL);
/*!40000 ALTER TABLE `cms_nav_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_nav_item_module`
--

DROP TABLE IF EXISTS `cms_nav_item_module`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_nav_item_module` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_nav_item_module`
--

LOCK TABLES `cms_nav_item_module` WRITE;
/*!40000 ALTER TABLE `cms_nav_item_module` DISABLE KEYS */;
/*!40000 ALTER TABLE `cms_nav_item_module` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_nav_item_page`
--

DROP TABLE IF EXISTS `cms_nav_item_page`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_nav_item_page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `layout_id` int(11) NOT NULL,
  `nav_item_id` int(11) NOT NULL,
  `timestamp_create` int(11) NOT NULL,
  `create_user_id` int(11) NOT NULL,
  `version_alias` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_nav_item_page`
--

LOCK TABLES `cms_nav_item_page` WRITE;
/*!40000 ALTER TABLE `cms_nav_item_page` DISABLE KEYS */;
INSERT INTO `cms_nav_item_page` VALUES (1,1,1,1504513123,1,'Initial'),(2,1,2,1504513123,1,'Initial'),(3,1,3,1504513123,1,'Initial'),(4,1,4,1504513123,1,'Initial'),(5,1,5,1504513123,1,'Initial'),(6,1,6,1504513123,1,'Initial'),(7,1,7,1504513123,1,'Initial'),(8,1,8,1504513123,1,'Initial'),(9,1,9,1504513123,1,'Initial'),(10,1,10,1504513123,1,'Initial'),(11,1,11,1504513123,1,'Initial'),(12,1,12,1504513123,1,'Initial'),(13,1,13,1504513124,1,'Initial');
/*!40000 ALTER TABLE `cms_nav_item_page` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_nav_item_page_block_item`
--

DROP TABLE IF EXISTS `cms_nav_item_page_block_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_nav_item_page_block_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `block_id` int(11) NOT NULL,
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
  `is_hidden` tinyint(1) DEFAULT '0',
  `variation` varchar(255) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_nav_item_page_block_item`
--

LOCK TABLES `cms_nav_item_page_block_item` WRITE;
/*!40000 ALTER TABLE `cms_nav_item_page_block_item` DISABLE KEYS */;
/*!40000 ALTER TABLE `cms_nav_item_page_block_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_nav_item_redirect`
--

DROP TABLE IF EXISTS `cms_nav_item_redirect`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_nav_item_redirect` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_nav_item_redirect`
--

LOCK TABLES `cms_nav_item_redirect` WRITE;
/*!40000 ALTER TABLE `cms_nav_item_redirect` DISABLE KEYS */;
INSERT INTO `cms_nav_item_redirect` VALUES (1,1,'2'),(2,1,'3'),(3,1,'8'),(4,2,'https://luya.io');
/*!40000 ALTER TABLE `cms_nav_item_redirect` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_nav_permission`
--

DROP TABLE IF EXISTS `cms_nav_permission`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_nav_permission` (
  `group_id` int(11) NOT NULL,
  `nav_id` int(11) NOT NULL,
  `inheritance` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_nav_permission`
--

LOCK TABLES `cms_nav_permission` WRITE;
/*!40000 ALTER TABLE `cms_nav_permission` DISABLE KEYS */;
/*!40000 ALTER TABLE `cms_nav_permission` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_nav_property`
--

DROP TABLE IF EXISTS `cms_nav_property`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_nav_property` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nav_id` int(11) NOT NULL,
  `admin_prop_id` int(11) NOT NULL,
  `value` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_nav_property`
--

LOCK TABLES `cms_nav_property` WRITE;
/*!40000 ALTER TABLE `cms_nav_property` DISABLE KEYS */;
/*!40000 ALTER TABLE `cms_nav_property` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migration`
--

DROP TABLE IF EXISTS `migration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migration`
--

LOCK TABLES `migration` WRITE;
/*!40000 ALTER TABLE `migration` DISABLE KEYS */;
INSERT INTO `migration` VALUES ('m000000_000000_base',1504513120),('m141104_104622_admin_group',1504513120),('m141104_104631_admin_user_group',1504513120),('m141104_114809_admin_user',1504513120),('m141203_121042_admin_lang',1504513120),('m141203_143052_cms_cat',1504513120),('m141203_143059_cms_nav',1504513120),('m141203_143111_cms_nav_item',1504513120),('m141208_134038_cms_nav_item_page',1504513120),('m150106_095003_cms_layout',1504513120),('m150108_154017_cms_block',1504513120),('m150108_155009_cms_nav_item_page_block_item',1504513120),('m150122_125429_cms_nav_item_module',1504513120),('m150205_141350_block_group',1504513120),('m150304_152220_admin_storage_folder',1504513120),('m150304_152238_admin_storage_file',1504513120),('m150304_152244_admin_storage_filter',1504513121),('m150304_152250_admin_storage_effect',1504513121),('m150304_152256_admin_storage_image',1504513121),('m150309_142652_admin_storage_filter_chain',1504513121),('m150323_125407_admin_auth',1504513121),('m150323_132625_admin_group_auth',1504513121),('m150331_125022_admin_ngrest_log',1504513121),('m150615_094744_admin_user_login',1504513121),('m150617_200836_admin_user_online',1504513121),('m150626_084948_admin_search_data',1504513121),('m150915_081559_admin_config',1504513121),('m150924_112309_cms_nav_prop',1504513121),('m150924_120914_admin_prop',1504513121),('m151012_072207_cms_log',1504513121),('m151022_143429_cms_nav_item_redirect',1504513121),('m151026_161841_admin_tag',1504513121),('m160629_092417_cmspermissiontable',1504513121),('m160915_081618_create_admin_logger_table',1504513121),('m161219_150240_admin_lang_soft_delete',1504513121),('m161220_183300_lcp_base_tables',1504513121),('m170116_120553_cms_block_variation_field',1504513121),('m170131_104109_user_model_updates',1504513122),('m170218_215610_cms_nav_layout_file',1504513122),('m170301_084325_cms_config',1504513122),('m170619_103728_cms_blocksettings',1504513122);
/*!40000 ALTER TABLE `migration` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-09-04 10:18:44
