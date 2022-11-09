<?php

namespace luya\dev;

use luya\console\Command;
use luya\helpers\FileHelper;
use Yii;
use yii\helpers\Json;
use yii\helpers\VarDumper;

/**
 * BaseDevCommand Controller.
 *
 * Provides the IO for the configuration storage.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.1
 */
class BaseDevCommand extends Command
{
    /**
     * @var string The location of the devconfig json where data is stored.
     */
    public $configFile = '@appFolder/devconfig.json';

    /**
     * Display config data and location.
     *
     * @return boolean|void
     */
    public function actionConfigInfo()
    {
        $this->outputInfo("dev config file: " . Yii::getAlias($this->configFile));

        $config = $this->readConfig();

        if (!$config) {
            return $this->outputError("Unable to open config file.");
        }

        foreach ($config as $key => $value) {
            $this->output("{$key} => ".VarDumper::dumpAsString($value));
        }
    }

    /**
     * Read entire config and return as array.
     *
     * @return array|boolean
     */
    protected function readConfig()
    {
        $data = FileHelper::getFileContent($this->configFile);

        if ($data) {
            return Json::decode($data);
        }

        return false;
    }

    /**
     * Get a specific value for a given key.
     *
     * @param string $key
     * @param mixed $defaultValue The value used when nothing is given
     * @return boolean
     */
    protected function getConfig($key, $defaultValue = null)
    {
        $config = $this->readConfig();

        return isset($config[$key]) ? $config[$key] : $defaultValue;
    }

    /**
     * Save a value in the config for a given key.
     *
     * @param string $key
     * @param mixed $value
     * @return mixed
     */
    protected function saveConfig($key, $value)
    {
        $content = $this->readConfig();

        if (!$content) {
            $content = [];
        }

        $content[$key] = $value;

        $save = FileHelper::writeFile($this->configFile, Json::encode($content));

        if (!$save) {
            return $this->outputError("Unable to find config file " . $this->configFile. ". Please create and provide Permissions.");
        }

        return $value;
    }
}
