<?php

namespace luya\base;

use Yii;
use ReflectionClass;
use luya\Exception;
use luya\web\Application as WebApplication;
use luya\console\Application as ConsoleApplication;
use luya\helpers\ArrayHelper;

/**
 * LUYA Boot wrapper.
 *
 * Run the Luya/Yii Application based on the current enviroment which is determined trough get_sapi_name(). To run an application
 * a config file with custom Luya/Yii configuration must be provided via `$configFile` property. By default luya will try to find
 * the default config `../configs/env.php`.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
abstract class Boot
{
    /**
     * @var string The current LUYA version (see: https://github.com/luyadev/luya/blob/master/CHANGELOG.md)
     */
    const VERSION = '1.0.0-dev';
    
    /**
     * @var string The path to the config file, which returns an array containing you configuration.
     */
    public $configFile = '../configs/env.php';

    /**
     * @var \luya\web\Application|\luya\console\Application The application object.
     */
    public $app;

    /**
     * @var bool When enabled the boot process will not return/echo something, but the variabled will contain the Application object.
     */
    public $mockOnly = false;

    /**
     * @var string Path to the Yii.php file.
     */
    private $_baseYiiFile;

    /**
     * Setter method for the base Yii file.
     *
     * Example path to the yii base file:
     *
     * ```php
     * $boot->setYiiPath(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');
     * ```
     *
     * @param string $baseYiiFile The path to the Yii.php file.
     */
    public function setBaseYiiFile($baseYiiFile)
    {
        $this->_baseYiiFile = $baseYiiFile;
    }
    
    public function getBaseYiiFile()
    {
        return $this->_baseYiiFile;
    }

    public function isCli()
    {
        return $this->getSapiName() === 'cli';
    }
    
    /**
     * Returns the current sapi name in lower case.
     *
     * @return string e.g. cli or web
     */
    public function getSapiName()
    {
        return strtolower(php_sapi_name());
    }

    private $_configArray;
    
    /**
     * This method allows you to directly inject a configuration array instead of using the config file
     * method.
     *
     * This method is commonly used when running php unit tests which do not require an additional file.
     *
     * ```php
     * $app = new Boot();
     * $app->setConfigArray([
     *     // ...
     * ]);
     * ```
     *
     * @param array $config The configuration array for the application.
     */
    public function setConfigArray(array $config)
    {
        $this->_configArray = $config;
    }
    
    /**
     * The prependConfigArray will be merged into the config, this way you can prepand config values for a custom Boot class.
     *
     * > When using prependConfig inside a custom boot class, the custom boot class will not used in the vendor bin file `./vendor/bin/luya`,
     * > so make sure to generate your own bin file.
     *
     * @return array
     */
    public function prependConfigArray()
    {
        return [];
    }
    
    /**
     * Get the config array from the configFile path with the predefined values.
     *
     * @throws \luya\Exception Throws exception if the config file does not exists.
     * @return array The array which will be injected into the Application Constructor.
     */
    public function getConfigArray()
    {
        if ($this->_configArray === null) {
            if (!file_exists($this->configFile)) {
                if (!$this->isCli()) {
                    throw new Exception("Unable to load the config file '".$this->configFile."'.");
                }
                
                $config = ['id' => 'consoleapp', 'basePath' => dirname(__DIR__)];
            } else {
                $config = require $this->configFile;
            }
    
            if (!is_array($config)) {
                throw new Exception("config file '".$this->configFile."' found but no array returning.");
            }
    
            // adding default configuration timezone if not set
            if (!array_key_exists('timezone', $config)) {
                $config['timezone'] = 'Europe/Berlin';
            }
            
            // preset the values from the defaultConfigArray
            if (!empty($this->prependConfigArray())) {
                $config = ArrayHelper::merge($config, $this->prependConfigArray());
            }
         
            $this->_configArray = $config;
        }

        return $this->_configArray;
    }

    /**
     * Run the application based on the Sapi Name.
     *
     * @return \luya\web\Application|\luya\cli\Application Application objected based on the sapi name.
     */
    public function run()
    {
        if ($this->isCli()) {
            return $this->applicationConsole();
        }

        return $this->applicationWeb();
    }

    /**
     * Run Cli-Application based on the provided config file.
     *
     * @return string|integer
     */
    public function applicationConsole()
    {
        $config = $this->getConfigArray();
        $config['defaultRoute'] = 'help';
        if (isset($config['components'])) {
            if (isset($config['components']['composition'])) {
                unset($config['components']['composition']);
            }
        }
        
        $baseUrl = null;
        if (isset($config['consoleBaseUrl'])) {
            $baseUrl = $config['consoleBaseUrl'];
        } elseif (isset($config['consoleHostInfo'])) {
            $baseUrl = '/';
        }
        
        $this->includeYii();
        $this->app = new ConsoleApplication(ArrayHelper::merge([
            'bootstrap' => ['luya\console\Bootstrap'],
            'components' => [
                'urlManager' => [
                    'class' => 'yii\web\UrlManager',
                    'enablePrettyUrl' => true,
                    'showScriptName' => false,
                    'baseUrl' => $baseUrl,
                    'hostInfo' => isset($config['consoleHostInfo']) ? $config['consoleHostInfo'] : null,
                ],
            ],
        ], $config));
        if (!$this->mockOnly) {
            exit($this->app->run());
        }
    }

    /**
     * Run Web-Application based on the provided config file.
     *
     * @return string Returns the Yii Application run() method if mock is disabled. Otherwise returns void
     */
    public function applicationWeb()
    {
        $config = $this->getConfigArray();
        $this->includeYii();
        $this->app = new WebApplication(ArrayHelper::merge(['bootstrap' => ['luya\web\Bootstrap']], $config));
        if (!$this->mockOnly) {
            return $this->app->run();
        }
    }
    
    /**
     * Returns the path to luya core files
     *
     * @return string The base path to the luya core folder.
     */
    public function getCoreBasePath()
    {
        $reflector = new ReflectionClass(get_class($this));
        return dirname($reflector->getFileName());
    }
    
    /**
     * Helper method to check whether the provided Yii Base file exists, if yes include and
     * return the file.
     *
     * @return bool Return value based on require_once command.
     * @throws Exception Throws Exception if the YiiBase file does not exists.
     */
    private function includeYii()
    {
        if (file_exists($this->_baseYiiFile)) {
            defined('LUYA_YII_VENDOR') ?: define('LUYA_YII_VENDOR', dirname($this->_baseYiiFile));
            
            $baseYiiFolder = LUYA_YII_VENDOR . DIRECTORY_SEPARATOR;
            $luyaYiiFile = $this->getCoreBasePath() . DIRECTORY_SEPARATOR .  'Yii.php';
            
            if (file_exists($luyaYiiFile)) {
                require_once($baseYiiFolder . 'BaseYii.php');
                require_once($luyaYiiFile);
            } else {
                require_once($baseYiiFolder . 'Yii.php');
            }
            
            Yii::setAlias('@luya', $this->getCoreBasePath());
            
            return true;
        }

        throw new Exception("YiiBase file does not exits '".$this->_baseYiiFile."'.");
    }
}
