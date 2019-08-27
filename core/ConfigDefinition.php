<?php

namespace luya;

class ConfigDefinition
{
    const GROUP_COMPONENTS = 1;

    const GROUP_MODULES = 2;

    const GROUP_APPLICATIONS = 3;

    private $_group;

    private $_key;

    private $_config = [];

    public function __construct($group, $key, $config)
    {
        $this->_group = $group;
        $this->_key = $key;
        
        if (empty($config)) {
            $config = [];
        }

        $this->_config = is_array($config) ? $config : ['class' => $config];
    }

    private $_env = Config::ENV_ALL;

    public function env($env)
    {
        $this->_env = $env;

        return $this;
    }

    private $_runtime = Config::RUNTIME_ALL;

    public function runtime($runtime)
    {
        $this->_runtime = $runtime;

        return $this;
    }
    
    public function consoleRuntime()
    {
        $this->_runtime = Config::RUNTIME_CONSOLE;

        return $this;
    }

    public function webRuntime()
    {
        $this->_runtime = Config::RUNTIME_WEB;

        return $this;
    }

    public function validateRuntime($runtime)
    {
        return $this->_runtime == $runtime;
    }

    public function validateEnvs(array $envs)
    {
        return in_array($this->_env, $envs);

    }

    public function getGroup()
    {
        return $this->_group;
    }

    public function getKey()
    {
        return $this->_key;
    }

    public function getConfig()
    {
        return $this->_config;
    }
}