<?php

namespace luya;

use luya\helpers\ArrayHelper;

/**
 * Configuration array Helper.
 *
 * The {{luya\Config}} allows you to create the configuration for different hosts and difference between web and console config.
 *
 * ```php
 * $config = new Config('myapp', dirname(__DIR__), [
 *     'siteTitle' => 'My LUYA Project',
 *     'defaultRoute' => 'cms',
 *     // other application level configurations
 * ]);
 *
 * // define global components which works either for console or web runtime
 *
 * $config->component('mail', [
 *     'host' => 'xyz',
 *     'from' => 'from@luya.io',
 * ]);
 *
 * $config->component('db', [
 *     'class' => 'yii\db\Connection',
 *     'dsn' => 'mysql:host=localhost;dbname=prod_db',
 *     'username' => 'foo',
 *     'password' => 'bar',
 * ]);
 *
 * // define components which are only for web or console runtime:
 *
 * $config->webComponent('request', [
 *     'cookieValidationKey' => 'xyz',
 * ]);
 *
 * // which is equals to, but the above is better to read and structure in the config file
 *
 * $config->component('request', [
 *     'cookieValidationKey' => 'xyz',
 * ])->webRuntime();
 *
 * // adding modules
 *
 * $config->module('admin', [
 *     'class' => 'luya\admin\Module',
 *     'secureLogin' => true,
 * ]);
 *
 * $config->module('cms', 'luya\cms\frontend\Module'); // which is equals to $config->module('cms', ['class' => 'luya\cms\frontend\Module']);
 *
 * // export and generate the config for a given enviroment or environment independent.
 *
 * return $config->toArray(); // returns the config not taking care of enviroment variables like prod, env
 *
 * return $config->toArray([Config::ENV_PROD]);
 * ```
 *
 * ## Runtime
 *
 * Each method returns an {{luya\ConfigDefinition}} object and can therefore be configured for different runtimes (console/web). The given example will add a console command
 * only for console applications:
 *
 * ```php
 * $config->application([
 *     'controllerMap' => [
 *         's3' => 'luya\aws\commands\S3Command',
 *     ]
 * ])->consoleRuntime();
 * ```
 *
 * ## Envs
 *
 * Switching between envs can be usefull if certain configurations should only apply on a certain environment. Therefore you can add `env()` behind componenets, applications and modules.
 *
 * ```php
 * $config->component('db', [
 *     'class' => 'yii\db\Connection',
 *     'dsn' => 'mysql:host=localhost;dbname=local_db',
 *     'username' => 'foo',
 *     'password' => 'bar',
 * ])->env(Config::ENV_LOCAL);
 *
 * $config->component('db', [
 *     'class' => 'yii\db\Connection',
 *     'dsn' => 'mysql:host=localhost;dbname=dev_db',
 *     'username' => 'foo',
 *     'password' => 'bar',
 * ])->env(Config::ENV_DEV);
 *
 * $config->component('db', [
 *     'class' => 'yii\db\Connection',
 *     'dsn' => 'mysql:host=localhost;dbname=prod_db',
 *     'username' => 'foo',
 *     'password' => 'bar',
 * ])->env(Config::ENV_PROD);
 *
 * return $config->toArray(Config::ENV_PROD); // would only return the prod env db component
 * ```
 * 
 * > When mergin varaibles, the later will always override the former. If arrays are involved the values will be added, not replaced!
 * > Example: `'foo' => 'bar', 'values' => [1]` and `'foo' => 'baz', 'values' => [2]` will be merged to: `'foo' => 'baz', 'values' => [1,2]`.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.21
 */
class Config
{
    const ENV_ALL = 'all';

    /**
     * @var string Predefined constant for production
     */
    const ENV_PROD = 'prod';
    
    /**
     * @var string Predefined constant for preproduction
     */
    const ENV_PREP = 'prep';
    
    /**
     * @var string Predefined constant for development mode
     */
    const ENV_DEV = 'dev';
    
    /**
     * @var string Predefined constant for local development
     */
    const ENV_LOCAL = 'local';

    /**
     * @var string Predefined constant for ci enviroments
     */
    const ENV_CI = 'ci';

    const RUNTIME_ALL = 0;

    const RUNTIME_CONSOLE = 1;

    const RUNTIME_WEB = 2;
    
    /**
     * Constructor
     *
     * @param string $id
     * @param string $basePath
     * @param array $applicationConfig
     */
    public function __construct($id, $basePath, array $applicationConfig = [])
    {
        $applicationConfig['id'] = $id;
        $applicationConfig['basePath'] = $basePath;
        $this->application($applicationConfig);
    }
    
    private $_env;
    
    /**
     * Assign the env to each component, module or application that defined inside the callback.
     *
     * Callback function has one parameter with the current {{luya\Config}} object.
     * 
     * An example using env to wrap multiple configuration lines into a single environment:
     * 
     * ```php
     * $config->env(Config::ENV_LOCAL, function($config) {
     *   
     *     $config->callback(function() {
     *         define('YII_DEBUG', true);
     *         define('YII_ENV', 'local');
     *     });
     *   
     *     $config->component('db', [
     *         'dsn' => 'mysql:host=luya_db;dbname=luya_kickstarter',
     *         'username' => 'luya',
     *         'password' => 'luya',
     *         'enableSchemaCache' => false,
     *     ]);
     *   
     *     $config->module('debug', [
     *         'class' => 'yii\debug\Module',
     *         'allowedIPs' => ['*'],
     *     ]);
     *
     *     $config->bootstrap(['debug']);
     * });
     * ```
     * 
     * @param string $env The environment to assigne inside the callback.
     * @param callable $callback function(\luya\Config $config)
     * @return $this
     */
    public function env($env, callable $callback)
    {
        $this->_env = $env;
        
        try {
            call_user_func($callback, $this);
        } finally {
            $this->_env = null;
        }
        
        return $this;
    }

    /**
     * register application level config
     *
     * @param array $config The array to configure
     * @return ConfigDefinition
     */
    public function application(array $config)
    {
        return $this->addDefinition(new ConfigDefinition(ConfigDefinition::GROUP_APPLICATIONS, 'application', $config));
    }

    /**
     * Register one or more bootstrap entries into the bootstrap section.
     *
     * @param array $config An array with bootstrap entries, its common to use the module name
     * @return ConfigDefinition
     */
    public function bootstrap(array $config)
    {
        return $this->addDefinition(new ConfigDefinition(ConfigDefinition::GROUP_BOOTSTRAPS, 'bootstrap', $config));
    }

    /**
     * Register a module.
     *
     * @param string $id The module identifier.
     * @param string|array $config The configuration for the given module. If a string is given this will be taken as `class` property.
     * @return ConfigDefinition
     */
    public function module($id, $config)
    {
        return $this->addDefinition(new ConfigDefinition(ConfigDefinition::GROUP_MODULES, $id, $config));
    }

    /**
     * Run a callable functions for the defined env when toArray() is called.
     *
     * @param callable $fn The function to run, the first argument of the closure is the {{luya\Config}} object.
     * @return ConfigDefinition
     * @since 1.0.23
     */
    public function callback(callable $fn)
    {
        return $this->addDefinition(new ConfigDefinition(ConfigDefinition::GROUP_CALLABLE, false, $fn));
    }

    /**
     * Register a component
     *
     * @param string $id The id of the component
     * @param string|array $config The configuration for the given module. If a string is given this will be taken as `class` property.
     * @param string $runtime The runtime for the component: all, web or console
     * @return ConfigDefinition
     */
    public function component($id, $config, $runtime = self::RUNTIME_ALL)
    {
        return $this->addDefinition(new ConfigDefinition(ConfigDefinition::GROUP_COMPONENTS, $id, $config))->runtime($runtime);
    }

    /**
     * Register a web runtime component.
     *
     * @param string $id The id of the component
     * @param string|array $config The configuration for the given module. If a string is given this will be taken as `class` property.
     * @return ConfigDefinition
     */
    public function webComponent($id, $config)
    {
        return $this->component($id, $config, self::RUNTIME_WEB);
    }

    /**
     * Register a console runtime component.
     *
     * @param string $id The id of the component
     * @param string|array $config The configuration for the given module. If a string is given this will be taken as `class` property.
     * @return ConfigDefinition
     */
    public function consoleComponent($id, $config)
    {
        return $this->component($id, $config, self::RUNTIME_CONSOLE);
    }

    private $_definitions = [];

    /**
     * Add a definition into the definitions bag.
     *
     * @param ConfigDefinition $definition
     * @return ConfigDefinition
     */
    private function addDefinition(ConfigDefinition $definition)
    {
        if ($this->_env !== null) {
            $definition->env($this->_env);
        }
        
        $this->_definitions[] = $definition;

        return $definition;
    }

    private $_isCliRuntime;

    /**
     * Whether runtime is cli or not
     *
     * @return boolean
     */
    public function isCliRuntime()
    {
        if ($this->_isCliRuntime === null) {
            $this->_isCliRuntime = strtolower(php_sapi_name()) === 'cli';
        }

        return $this->_isCliRuntime;
    }

    /**
     * Setter method for runtime.
     *
     * > This method is mainly used for unit testing.
     *
     * @param boolean $value
     */
    public function setCliRuntime($value)
    {
        $this->_isCliRuntime = $value;
    }

    /**
     * Export the given configuration as array for certain envs.
     *
     * @param array|string $envs A list of environments to export. if nothing is given all enviroments will be returned. A string will be threated as array with 1 entry.
     * @return array The configuration array
     */
    public function toArray($envs = [])
    {
        $config = [];
        $envs = (array) $envs;
        $envs = array_merge($envs, [self::ENV_ALL]);
        foreach ($this->_definitions as $definition) { /** @var ConfigDefinition $definition */
            // validate if current export env is in the list of envs
            if (!$definition->validateEnvs($envs)) {
                continue;
            }
            // validate runtime circumstances
            if ($definition->validateRuntime(self::RUNTIME_ALL)) {
                $this->appendConfig($config, $definition);
            } elseif ($this->isCliRuntime() && $definition->validateRuntime(self::RUNTIME_CONSOLE)) {
                $this->appendConfig($config, $definition);
            } elseif (!$this->isCliRuntime() && $definition->validateRuntime(self::RUNTIME_WEB)) {
                $this->appendConfig($config, $definition);
            }
        }

        return $config;
    }

    /**
     * Append a given definition int othe config
     *
     * @param array $config
     * @param ConfigDefinition $definition
     */
    private function appendConfig(&$config, ConfigDefinition $definition)
    {
        switch ($definition->getGroup()) {
            case ConfigDefinition::GROUP_APPLICATIONS:
                foreach ($definition->getConfig() as $k => $v) {
                    $config[$k] = $v;
                }
                break;

            case ConfigDefinition::GROUP_COMPONENTS:
                $this->handleKeyBaseMerge($config, $definition, 'components');
                break;

            case ConfigDefinition::GROUP_MODULES:
                $this->handleKeyBaseMerge($config, $definition, 'modules');
                break;

            case ConfigDefinition::GROUP_BOOTSTRAPS:
                if (!array_key_exists('bootstrap', $config)) {
                    $config['bootstrap'] = [];
                }
                foreach ($definition->getConfig() as $v) {
                    $config['bootstrap'][] = $v;
                }
                break;

            case ConfigDefinition::GROUP_CALLABLE:
                call_user_func($definition->getConfig(), $this);
            break;
        }
    }

    /**
     * Add a array key based component definition.
     *
     * @param array $config
     * @param ConfigDefinition $definition
     * @param string $section
     */
    private function handleKeyBaseMerge(&$config, ConfigDefinition $definition, $section)
    {
        // ass missing section key
        if (!array_key_exists($section, $config)) {
            $config[$section] = [];
        }

        // array key from definition in order to merge with existing values
        $key = $definition->getKey();

        // if key exists, merge otherwise create key
        if (isset($config[$section][$key])) {
            $config[$section][$key] = ArrayHelper::merge($config[$section][$key], $definition->getConfig());
        } else {
            $config[$section][$key] = $definition->getConfig();
        }
    }
}
