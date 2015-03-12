<?php
namespace luya\base;

use yii\helpers\ArrayHelper;

if (!version_compare(PHP_VERSION, '5.4.0', '>=')) {
    trigger_error('Some functions of luya need php version 5.4.0 or higher! You are currently using Version: '.PHP_VERSION, E_USER_ERROR);
}

/**
 * Wrapping class to set config informations and also load default configuration informations which belongs to the luya module.
 *
 * @author nadar
 */
class Boot
{
    const SAPI_WEB = 'web';

    const SAPI_CLI = 'cli';

    public $configValue = [];

    /**
     * The path where all the configuration files are located.
     *
     * @todo us configs instead of config?
     *
     * @var string
     */
    public $configPath = '../config/';

    public $configName = 'server.php';

    public $yiiPath = null;

    private function beforeRun()
    {
        $this->setConfigValue(require_once($this->getBaseConfig()));
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
                throw new \Exception("This sapi type is not allowed");
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
        return \luya\helpers\Url::trailing($this->configPath).$this->configName;
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
        $this->configValue = \yii\helpers\ArrayHelper::merge($this->configValue, $values);
    }

    public function getConfigValue()
    {
        return $this->configValue;
    }

    /**
     * @return yii console application
     */
    private function applicationCli()
    {
        $this->beforeRun();
        $this->setConfigValue(include(__DIR__.'/../config/'.self::SAPI_CLI.'.php'));
        require_once $this->yiiPath;
        $application = new \yii\console\Application($this->getConfigValue(self::SAPI_CLI));
        $exitCode = $application->run();
        exit($exitCode);
    }

    /**
     * @return yii web application
     */
    private function applicationWeb()
    {
        $this->beforeRun();
        $this->setConfigValue(include(__DIR__.'/../config/'.self::SAPI_WEB.'.php'));
        require_once $this->yiiPath;
        $yii = new \yii\web\Application($this->getConfigValue(self::SAPI_WEB));
        $yii->run();
    }
}
