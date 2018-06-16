<?php

namespace luya;

use luya\helpers\ArrayHelper;

/**
 * Configuration array Helper.
 * 
 * The {{luya\Config}} allowy you to create the configuration for different hosts and between web and console config.
 * 
 * ```php
 * // base config which is the same for all envs, console and web
 * Config::base(['id' => 'myapp', 'basePath' => dirname(__DIR__)]);
 * ```
 * 
 * Register modules:
 * 
 * ```php
 * Config::module('admin', ['class' => 'luya\admin\Module', 'secureLogin' => false]);
 * Config::module('cms', 'luya\cms\frontend\Module'); // Same as: ['class' => 'luya\cms\frontend\Module']
 * ```
 * 
 * Setup components based on the env:
 * 
 * ```php
 * // prod database
 * Config::component('db', [
 *     'class' => 'yii\db\Connection',
 *     'dsn' => 'mysql:host=localhost;dbname=prod_db',
 *     'username' => 'foo',
 *     'password' => 'bar',
 * ], Config::ENV_PROD);
 * 
 * // local database
 * Config::component('db', [
 *     'class' => 'yii\db\Connection',
 *     'dsn' => 'mysql:host=localhost;dbname=local_db',
 *     'username' => 'foo',
 *     'password' => 'bar',
 * ], Config::ENV_LOCAL);
 * ```
 * 
 * Switch between console and web application:
 * 
 * ```php
 * Config::web([
 *     'components' => [
 *         'request' => [
 *             'luya\web\Request' => [
 *                 'cookieValidationKey' => '123123123123123123123',
 *             ]
 *         ]
 *     ]
 * ]);
 * ```
 * 
 * Configurations from {{luya\Config::web()}} and {{luya\Config::console()}} will override predefined configurations
 * from {{luya\Config::base()}}.
 * 
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.10
 */
class Config
{
    const ENV_PROD = 'prod';
    
    const ENV_PREP = 'prep';
    
    const ENV_DEV = 'dev';
    
    const ENV_LOCAL = 'local';
    
    protected static $config = [];
    
    protected static function merge($existing, $override)
    {
        return ArrayHelper::merge($existing, $override);
    }
    
    /**
     * Returns the current sapi name in lower case.
     *
     * @return string e.g. cli or web
     */
    public function isCli()
    {
        return strtolower(php_sapi_name()) === 'cli';
    }
    
    public static function base(array $config)
    {
        self::$config = self::merge(self::$config, $config);
    }
    
    public static function web(array $config, $env = null)
    {
        if (!self::isCli()) {
            self::$config = self::merge(self::$config, $config);
        }
    }
    
    public static function console(array $config, $env = null)
    {
        if (self::isCli()) {
            self::$config = self::merge(self::$config, $config);
        }
    }
    
    public static function component($id, array $config, $env = null)
    {
        
    }
    
    public static function module($id, array $config, $env = null)
    {
        
    }
}