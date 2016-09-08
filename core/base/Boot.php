<?php

namespace luya\base;

use Exception;
use ReflectionClass;
use luya\web\Application as WebApplication;
use luya\console\Application as ConsoleApplication;
use luya\helpers\ArrayHelper;

/**
 * Luya Boot Wrapper.
 *
 * Run the Luya/Yii Application based on the current enviroment which is determined trough get_sapi_name(). To run an application
 * a config file with custom Luya/Yii configuration must be provided via `$configFile` property. By default luya will try to find
 * the default config `../configs/server.php`.
 *
 * @author Basil Suter <basil@nadar.io>
 */
abstract class Boot
{
    /**
     * The current luya version.
     *
     * @link https://github.com/zephir/luya/blob/master/CHANGELOG.md
     *
     * @var string
     */
    const VERSION = '1.0.0-RC1-dev';
    
    /**
     * @var string The path to the config file, which returns an array containing you configuration.
     */
    public $configFile = '../configs/server.php';

    /**
     * @var luya\web\Application|luya\cli\Application The application object.
     */
    public $app = null;

    /**
     * @var bool When enabled the boot process will not return/echo something, but the variabled will contain
     *           the Application object.
     */
    public $mockOnly = false;

    /**
     * @var string Path to the Yii.php file.
     */
    private $_baseYiiFile = null;

    /**
     * Setter method for the base Yii file.
     *
     * @todo rename to setYiiBaseFile, bc break.
     *
     * @param string $baseYiiFile The path to the Yii.php file.
     */
    public function setYiiPath($baseYiiFile)
    {
        $this->_baseYiiFile = $baseYiiFile;
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

    /**
     * Get the config array from the configFile path with the predefined values.
     *
     * @throws Exception Throws exception if the config file does not exists.
     *
     * @return array The array which will be injected into the Application Constructor.
     */
    public function getConfigArray()
    {
        if (!file_exists($this->configFile)) {
            throw new Exception("Unable to load the config file '".$this->configFile."'.");
        }

        $config = require $this->configFile;

        if (!is_array($config)) {
            throw new Exception("config file '".$this->configFile."' found but no array returning.");
        }

        // adding default configuration timezone if not set
        if (!array_key_exists('timezone', $config)) {
            $config['timezone'] = 'Europe/Berlin';
        }

        return $config;
    }

    /**
     * Run the application based on the Sapi Name.
     *
     * @return luya\web\Application|luya\cli\Application Application objected based on the sapi name.
     */
    public function run()
    {
        if ($this->getSapiName() === 'cli') {
            return $this->applicationConsole();
        }

        return $this->applicationWeb();
    }

    /**
     * Run Cli-Application based on the provided config file.
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
        $this->includeYii();
        $this->app = new ConsoleApplication(ArrayHelper::merge(['bootstrap' => ['luya\console\Bootstrap']], $config));
        if (!$this->mockOnly) {
            exit($this->app->run());
        }
    }

    /**
     * Run Web-Application based on the provided config file.
     *
     * @return string|void Returns the Yii Application run() method if mock is disabled. Otherwise returns void
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
    public static function getLuyaBasePath()
    {
        $reflector = new ReflectionClass(get_called_class());
        return dirname($reflector->getFileName());
    }
    
    /**
     * Helper method to check whether the provided Yii Base file exists, if yes include and
     * return the file.
     *
     * @return bool Return value based on require_once command.
     *
     * @throws Exception Throws Exception if the YiiBase file does not exists.
     */
    private function includeYii()
    {
        if (file_exists($this->_baseYiiFile)) {
            return require_once($this->_baseYiiFile);
        }

        throw new Exception("YiiBase file does not exits '".$this->_baseYiiFile."'.");
    }
}
