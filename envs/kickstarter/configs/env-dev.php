<?php

/**
 * This config should be used on development enviroment.
 * The development enviroment can be used to show the website to an agency / the designer and prepare it for prep deployment.
 */

/*
 * Enable or disable the debugging, if those values are deleted YII_DEBUG is false and YII_ENV is prod.
 * The YII_ENV value will also be used to load assets based on enviroment (see assets/ResourcesAsset.php)
 */
defined('YII_ENV') or define('YII_ENV', 'dev');
defined('YII_DEBUG') or define('YII_DEBUG', false);

$config = [
    // Use the env-local.php config and change the configs to match your dev enviroment settings (for Example: Databse name, user and password)
];
