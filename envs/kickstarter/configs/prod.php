<?php

/**
 * This config should be used on production enviroment.
 * The production enviroment is the last "step" and is visible to all.
 */

/**
 * Enable or disable the debugging, if those values are deleted YII_DEBUG is false and YII_ENV is prod.
 * The YII_ENV value will also be used to load assets based on enviroment (see assets/ResourcesAsset.php)
 */
defined('YII_ENV') or define('YII_ENV', 'prod');
defined('YII_DEBUG') or define('YII_DEBUG', false);

return [
    // Use the prep.php config and change the configs to match your prod enviroment settings (for Example: Databse name, user and password)
];
