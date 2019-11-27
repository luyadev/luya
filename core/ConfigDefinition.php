<?php

namespace luya;

/**
 * Contains the defintion of a config element.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.21
 */
class ConfigDefinition
{
    /**
     * @var integer componenets group
     */
    const GROUP_COMPONENTS = 1;

    /**
     * @var integer modules group
     */
    const GROUP_MODULES = 2;

    /**
     * @var integer applications group
     */
    const GROUP_APPLICATIONS = 3;

    /**
     * @var integer boostrap section group
     */
    const GROUP_BOOTSTRAPS = 4;

    const GROUP_CALLABLE = 5;

    private $_group;

    private $_key;

    private $_config;

    /**
     * Consturctor
     *
     * @param string $group
     * @param string $key
     * @param mixed $config
     */
    public function __construct($group, $key, $config)
    {
        $this->_group = $group;
        $this->_key = $key;
        $this->_config = is_scalar($config) ? ['class' => $config] : $config;
    }

    private $_env = Config::ENV_ALL;

    /**
     * Set env
     *
     * @param string $env
     * @return static
     */
    public function env($env)
    {
        $this->_env = $env;

        return $this;
    }

    private $_runtime = Config::RUNTIME_ALL;

    /**
     * Set runtime
     *
     * @param string $runtime
     * @return static
     */
    public function runtime($runtime)
    {
        $this->_runtime = $runtime;

        return $this;
    }
    
    /**
     * Set console runtime
     *
     * @return static
     */
    public function consoleRuntime()
    {
        $this->_runtime = Config::RUNTIME_CONSOLE;

        return $this;
    }

    /**
     * Set web runtime
     *
     * @return static
     */
    public function webRuntime()
    {
        $this->_runtime = Config::RUNTIME_WEB;

        return $this;
    }

    /**
     * Getter method for group
     *
     * @return string
     */
    public function getGroup()
    {
        return $this->_group;
    }

    /**
     * Getter method for config key
     *
     * @return string
     */
    public function getKey()
    {
        return $this->_key;
    }

    /**
     * Getter method for config
     *
     * @return array
     */
    public function getConfig()
    {
        return $this->_config;
    }

    /**
     * Validate whether its given runtime or not
     *
     * @param string $runtime
     * @return boolean
     */
    public function validateRuntime($runtime)
    {
        return $this->_runtime == $runtime;
    }

    /**
     * Validate whether given env exsts or not.
     *
     * @param array $envs
     * @return boolean
     */
    public function validateEnvs(array $envs)
    {
        return in_array($this->_env, $envs);
    }
}
