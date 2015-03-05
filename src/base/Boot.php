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
    const SAPI_WEB = 1;

    const SAPI_CLI = 2;

    private $_modes = array(
        "web" => self::SAPI_WEB,
        "cli" => self::SAPI_CLI,
    );

    private $_config = array();

    /**
     * The path where all the configuration files are located.
     * @todo us configs instead of config?
     * @var string
     */
    public $configPath = '../config/';
    
    /**
     * Get the luya default configuration informations and store them to the config (belong to his mode)
     */
    public function __construct()
    {
        foreach ($this->_modes as $name => $value) {
            $this->setConfig($value, include(__DIR__.'/../config/'.$name.'.php'));
        }
    }

    /**
     * Run the mode specific (cli/web) application
     */
    public function run()
    {
        if ($this->getSapiType() == self::SAPI_CLI) {
            $this->applicationCli();
        } else {
            $this->applicationWeb();
        }
    }
    
    /**
     * finds the defined config in the configPath an includes the configuration file.
     * @param string $name The config file name, default server.php
     */
    public function findConfig($name = 'server.php')
    {
        return require_once($this->configPath . $name);
    }

    /**
     * Get the Sapi Type (interface between webserver and PHP)
     *
     * @todo use $_SERVER['argv'] instead of cli, cause this could trouble on diff environments
     */
    public function getSapiType()
    {
        if (strtoupper(php_sapi_name()) == "CLI") {
            return self::SAPI_CLI;
        }

        return self::SAPI_WEB;
    }

    /**
     *
     * @todo see if the sapi type is allowed
     * @param string $sapiType
     * @param array  $value
     */
    public function setConfig($sapiType, $value)
    {
        if (!isset($this->_config[$sapiType])) {
            $this->_config[$sapiType] = array();
        }
        $this->_config[$sapiType] = ArrayHelper::merge($this->_config[$sapiType], $value);
    }

    /**
     *
     * @param string $sapiType
     */
    private function getConfig($sapiType)
    {
        return $this->_config[$sapiType];
    }

    /**
     * @return yii console application
     */
    private function applicationCli()
    {
        $application = new \yii\console\Application($this->getConfig(self::SAPI_CLI));
        $exitCode = $application->run();
        exit($exitCode);
    }

    /**
     * @return yii web application
     */
    private function applicationWeb()
    {
        $yii = new \yii\web\Application($this->getConfig(self::SAPI_WEB));
        $yii->run();
    }
}
