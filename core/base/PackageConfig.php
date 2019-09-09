<?php

namespace luya\base;

use yii\base\BaseObject;

/**
 * Represents a package config item from the PackageInstaller.
 *
 * @property array $themes
 * @property array $bootstrap
 * @property array $blocks
 * @property string $package
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class PackageConfig extends BaseObject
{
    private $_values = [];

    /**
     * Setter method for the values.
     *
     * @param array $data
     * @since 1.0.21
     */
    public function setValues(array $data)
    {
        $this->_values = $data;
    }

    /**
     * Set only a given value for a given key.
     *
     * @param string $key
     * @param mixed $value
     * @since 1.0.21
     */
    public function setValue($key, $value)
    {
        $this->_values[$key] = $value;
    }

    /**
     * Get a certain value by key
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     * @since 1.0.21
     */
    public function getValue($key, $default = null)
    {
        return array_key_exists($key, $this->_values) ? $this->_values[$key] : $default;
    }

    /**
     * Getter method for bootstrap
     *
     * Example content:
     *
     * ```php
     * return [
     *  0 => '\\luya\\admin\\Bootstrap',
     * ]
     * ```
     *
     * @return array An array with bootstrap classes.
     * @since 1.0.21
     */
    public function getBootstrap()
    {
        return $this->getValue('bootstrap', []);
    }

    /**
     * Getter method for blocks
     *
     * Example content:
     *
     * ```php
     * return [
     *    0 => 'vendor/luyadev/luya-module-cms/src/frontend/blocks',
     * ]
     * ```
     *
     * @return array An array with block defintions.
     * @since 1.0.21
     */
    public function getBlocks()
    {
        return $this->getValue('blocks', []);
    }
    
    /**
     * Getter method for package
     *
     * Example content:
     *
     * ```php
     * return [
     *   'name' => 'luyadev/luya-module-admin',
     *   'prettyName' => 'luyadev/luya-module-admin',
     *   'version' => '2.0.3.0',
     *   'targetDir' => NULL,
     *   'installSource' => 'dist',
     *   'sourceUrl' => 'https://github.com/luyadev/luya-module-admin.git',
     *   'packageFolder' => 'luyadev/luya-module-admin',
     * ]
     * ```
     *
     * @return array An array with all informations about the package.
     * @since 1.0.21
     */
    public function getPackage()
    {
        return $this->getValue('package', []);
    }

    /**
     * Getter method for themes
     * @var array
     * @since 1.0.21
     */
    public function getThemes()
    {
        return $this->getValue('themes', []);
    }
}
