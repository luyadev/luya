<?php

namespace luya\base;

use yii\base\BaseObject;

/**
 * Represents the extracted data from the LUYA composer plugin installer.php file inside the vendor.
 *
 * @property string $timestamp
 * @property PackageConfig[] $configs
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class PackageInstaller extends BaseObject
{
    private $_timestamp;

    /**
     * Setter method for timestamp.
     *
     * @param integer $timestamp
     */
    public function setTimestamp($timestamp)
    {
        $this->_timestamp = $timestamp;
    }

    /**
     * Getter method for timestamp.
     *
     * @return integer
     */
    public function getTimestamp()
    {
        return $this->_timestamp;
    }

    private $_configs = [];

    /**
     * Setter method for configurations (PackageConfig).
     *
     * @param array $configs
     */
    public function setConfigs(array $configs)
    {
        $objects = [];
        foreach ($configs as $key => $config) {
            // create package object
            $packageConfig = new PackageConfig();
            $packageConfig->setValues($config);
            // assign object
            $objects[$key] = $packageConfig;
        }

        $this->_configs = $objects;
    }

    /**
     * Getter method for Configs.
     *
     * @return PackageConfig[]
     */
    public function getConfigs()
    {
        return $this->_configs;
    }
}
