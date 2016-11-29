<?php

/**
 * This config should be used on production enviroment.
 * The production enviroment is the last "step" and is visible to all.
 *
 * The production configuration is mostly a copei of the local or prep configuration with additional database
 * component, for example:
 *
 * ```php
 * db' => [
 *     'class' => 'yii\db\Connection',
 *     'dsn' => 'mysql:host=localhost;dbname=DB_NAME',
 *     'username' => 'DB_USER',
 *     'password' => 'DB_PASS',
 *     'charset' => 'utf8',
 *     // 'enableSchemaCache' => true,
 *     // 'schemaCacheDuration' => 43200,
 * ]
 * ```
 *
 * In production environemtn `YII_ENV` is by default set to `prod` and `YII_DEBUG` is false by default.
 */

return [
    // Use the env-prep.php or env-local.php config and change the configs to match your prod enviroment settings and added env specific informations (database, caching, etc.)
];
