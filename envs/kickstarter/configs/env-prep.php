<?php

/**
 * This config should be used on preproduction enviroment.
 * The preproduction enviroment will be used to show the website to the customer and prepare it for prod deployment.
 */

/*
 * Enable or disable the debugging, if those values are deleted YII_DEBUG is false and YII_ENV is prod.
 * The YII_ENV value will also be used to load assets based on enviroment (see assets/ResourcesAsset.php)
 */
defined('YII_ENV') or define('YII_ENV', 'prep');
defined('YII_DEBUG') or define('YII_DEBUG', false);

return [
    // Use the env-dev.php config and change the configs to match your prep enviroment settings (for Example: Databse name, user and password)
];
