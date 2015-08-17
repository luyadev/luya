<?php

namespace luya\base;

use luya\helpers\Url;
use yii\helpers\ArrayHelper;

/**
 * Wrapping class to set config informations and also load default configuration informations which belongs to the luya module.
 *
 * @author nadar
 */
abstract class Boot
{
    const SAPI_WEB = 'web';

    const SAPI_CLI = 'cli';

    public $configValue = [];

    /**
     * The path where all the configuration files are located.
     *
     * @var string
     */
    public $configPath = '../configs/';

    public $configName = 'server.php';

    public $yiiPath = null;

    public $yii = null;

    public $mockOnly = false;

    private function beforeRun()
    {
        $this->setConfigValue(require($this->getBaseConfig()));
        defined('YII_DEBUG') or define('YII_DEBUG', false);
        defined('YII_ENV') or define('YII_ENV', 'prod');
    }

    /**
     * Run the mode specific (cli/web) application.
     */
    public function run()
    {
        switch ($this->getSapiType()) {
            case self::SAPI_CLI:
                $this->applicationCli();
                break;
            case self::SAPI_WEB:
                $this->applicationWeb();
                break;
            default:
                throw new \Exception('This sapi type is not allowed');
                break;
        }
    }

    /**
     * finds the defined config in the configPath an includes the configuration file.
     *
     * @param string $name The config file name, default server.php
     */
    public function setConfigName($name)
    {
        $this->configName = $name;
    }

    public function setConfigPath($path)
    {
        $this->configPath = $path;
    }

    public function getBaseConfig()
    {
        return Url::trailing($this->configPath).$this->configName;
    }

    public function setYiiPath($yiiPath)
    {
        $this->yiiPath = $yiiPath;
    }

    public function getYiiPath()
    {
        return $this->yiiPath;
    }

    /**
     * Get the Sapi Type (interface between webserver and PHP).
     *
     * @todo use $_SERVER['argv'] instead of cli, cause this could trouble on diff environments
     */
    public function getSapiType()
    {
        if (strtolower(php_sapi_name()) == self::SAPI_CLI) {
            return self::SAPI_CLI;
        }

        return self::SAPI_WEB;
    }

    public function setConfigValue(array $values = [])
    {
        $this->configValue = ArrayHelper::merge($this->configValue, $values);
    }

    public function getConfigValue()
    {
        return $this->configValue;
    }

    /**
     * @return yii console application
     */
    public function applicationCli()
    {
        $this->beforeRun();
        $this->setConfigValue(include(__DIR__.'/../config/'.self::SAPI_CLI.'.php'));
        require_once($this->yiiPath);
        $this->yii = new \luya\cli\Application($this->getConfigValue(self::SAPI_CLI));
        if (!$this->mockOnly) {
            $exitCode = $this->yii->run();
            exit($exitCode);
        }
    }

    /**
     * @return yii web application
     */
    public function applicationWeb()
    {
        $this->beforeRun();
        $this->setConfigValue(include(__DIR__.'/../config/'.self::SAPI_WEB.'.php'));
        require_once($this->yiiPath);
        $this->yii = new \luya\web\Application($this->getConfigValue(self::SAPI_WEB));
        if (!$this->mockOnly) {
            $this->yii->run();
        }
    }
}
