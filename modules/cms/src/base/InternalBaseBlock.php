<?php

namespace luya\cms\base;

use yii\helpers\Inflector;
use luya\helpers\Url;
use luya\helpers\ArrayHelper;
use luya\admin\base\TypesInterface;
use luya\cms\frontend\blockgroups\MainGroup;
use yii\base\BaseObject;

/**
 * Concret Block implementation based on BlockInterface.
 *
 * This is an use case for the block implemenation as InternBaseBlock fro
 * two froms of implementations.
 *
 * + {{\luya\cms\base\PhpBlock}}
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
abstract class InternalBaseBlock extends BaseObject implements BlockInterface, TypesInterface, \ArrayAccess
{
    /**
     * Returns the configuration array.
     *
     * @return array
     */
    abstract public function config();
    
    /**
     * @var string Defines the injector config type `var`.
     */
    const INJECTOR_VAR = 'var';
    
    /**
     * @var string Defines the injector config type `cfg`.
     */
    const INJECTOR_CFG = 'cfg';

    private $_injectorObjects;
    
    /**
     * Setup injectors.
     */
    protected function injectorSetup()
    {
        if ($this->_injectorObjects === null) {
            foreach ($this->injectors() as $varName => $injector) {
                $injector->setContext($this);
                $injector->varName = $varName;
                $injector->setup();
                $this->_injectorObjects[$injector->varName] = $injector;
            }
        }
    }
    
    public function offsetSet($offset, $value)
    {
        $this->_injectorObjects[$offset] = $value;
    }
    
    public function offsetExists($offset)
    {
        return isset($this->_injectorObjects[$offset]);
    }
    
    public function offsetUnset($offset)
    {
        unset($this->_injectorObjects[$offset]);
    }
    
    /**
     *
     * @param string $offset The name of the registered Injector name.
     * @return \luya\cms\base\BaseBlockInjector
     */
    public function offsetGet($offset)
    {
        return isset($this->_injectorObjects[$offset]) ? $this->_injectorObjects[$offset] : null;
    }
    
    /**
     * @var bool Enable or disable the block caching
     */
    public $cacheEnabled = false;
    
    /**
     * @var int The cache lifetime for this block in seconds (3600 = 1 hour), only affects when cacheEnabled is true. 0 means never expire.
     */
    public $cacheExpiration = 3600;
    
    /**
     * @var bool Choose whether block is a layout/container/segmnet/section block or not, Container elements will be optically displayed
     * in a different way for a better user experience. Container block will not display isDirty colorizing.
     */
    public $isContainer = false;

    /**
     * @var string Containing the name of the environment (used to find the view files to render). The
     * module(Name) can be started with the Yii::getAlias() prefix `@`, otherwhise the `@` will be
     * added automatically.
     */
    public $module = 'app';
    
    /**
     * @inheritdoc
     */
    public function getIsCacheEnabled()
    {
        return $this->cacheEnabled;
    }
    
    /**
     * @inheritdoc
     */
    public function getCacheExpirationTime()
    {
        return $this->cacheExpiration;
    }
    
    /**
     * @inheritdoc
     */
    public function getIsDirtyDialogEnabled()
    {
        return true;
    }
    
    /**
     * @inheritdoc
     */
    public function getIsContainer()
    {
        return $this->isContainer;
    }
    
    /**
     * Contains the class name for the block group class
     *
     * @return string The classname on which the block should be stored in.
     * @since 1.0.0
     */
    public function blockGroup()
    {
        return MainGroup::className();
    }
    
    /**
     * Injectors are like huge helper objects which are going to automate functions, configs and variable assignement.
     *
     * An example of an Injector which builds a select dropdown and assigns the active query data into the extra vars `foobar`.
     *
     * ```php
     * public function injectors()
     * {
     *     return [
     *         'foobar' => new cms\injector\ActiveQueryCheckboxInjector([
     *             'query' => MyModel::find()->where(['id' => 1]),
     *             'type' => self::INJECTOR_VAR, // could be self::INJECTOR_CFG,
     *             'varLabel' => 'The Field Label',
     *         ]);
     *     ];
     * }
     * ```
     *
     * Now the generated injector ActiveQueryCheckbox is going to grab all informations from the defined query and assign
     * them into the extra var foobar. Now you can access `$this->extraValue('foobar')` which returns all seleced rows from the checkbox
     * you have assigend.
     *
     * In order to access the injectors object api you can use the ArrayAccess getter method like `$this['foobar']` and you can access the public
     * method for this Injector.
     */
    public function injectors()
    {
        return [];
    }
    
    /**
     * Return link for usage in ajax request, the link will call the defined callback inside
     * this block. All callback methods must start with `callback`. An example for a callback method:.
     *
     * ```php
     * public function callbackTestAjax($arg1)
     * {
     *     return 'hello callback test ajax with argument: arg1 ' . $arg1;
     * }
     * ```
     *
     * The above defined callback link can be created with the follow code:
     *
     * ```php
     * $this->createAjaxLink('TestAjax', ['arg1' => 'My Value for Arg1']);
     * ```
     *
     * The most convient way to assign the variable is via extraVars
     *
     * ```php
     * public function extraVars()
     * {
     *     return [
     *         'ajaxLinkToTestAjax' => $this->createAjaxLink('TestAjax', ['arg1' => 'Value for Arg1']),
     *     ];
     * }
     * ```
     *
     * @param string $callbackName The callback name in uppercamelcase to call. The method must exists in the block class.
     * @param array  $params       A list of parameters who have to match the argument list in the method.
     *
     * @return string
     */
    public function createAjaxLink($callbackName, array $params = [])
    {
        $params['callback'] = Inflector::camel2id($callbackName);
        $params['id'] = $this->getEnvOption('id', 0);
        return Url::toAjax('cms/block/index', $params);
    }

    /**
     * Contains the icon
     */
    public function icon()
    {
        return;
    }

    /**
     * Returns true if block is active in backend.
     *
     * @return bool
     */
    public function isAdminContext()
    {
        return ($this->getEnvOption('context', false) === 'admin') ? true : false;
    }

    /**
     * Returns true if block is active in frontend.
     *
     * @return bool
     */
    public function isFrontendContext()
    {
        return ($this->getEnvOption('context', false) === 'frontend') ? true : false;
    }

    private $_envOptions = [];
    
    /**
     * Sets a key => value pair in env options.
     *
     * @param string $key   The string to be set as key
     * @param mixed  $value The value that will be stored associated with the given key
     */
    public function setEnvOption($key, $value)
    {
        $this->_envOptions[$key] = $value;
    }
    
    /**
     * Returns all environment/context informations where the block have been placed. Example Data.
     *
     * + id (unique identifier for the block in cms context)
     * + blockId (id in the block list database, which is not unique)
     * + context
     * + pageObject
     *
     * @return array Returns an array with key value parings.
     */
    public function getEnvOptions()
    {
        return $this->_envOptions;
    }

    /**
     * Get a env option by $key. If $key does not exist it will return given $default or false.
     *
     * @param $key
     * @param mixed $default
     *
     * @return mixed
     */
    public function getEnvOption($key, $default = false)
    {
        return (array_key_exists($key, $this->_envOptions)) ? $this->_envOptions[$key] : $default;
    }

    private $_placeholderValues = [];
    
    /**
     * @inheritdoc
     */
    public function setPlaceholderValues(array $placeholders)
    {
        $this->_placeholderValues = $placeholders;
    }
    
    /**
     * @inheritdoc
     */
    public function getPlaceholderValues()
    {
        return $this->_placeholderValues;
    }
    
    /**
     *
     * @param unknown $placholder
     * @return boolean
     */
    public function getPlaceholderValue($placholder)
    {
        return (isset($this->getPlaceholderValues()[$placholder])) ? $this->getPlaceholderValues()[$placholder] : false;
    }

    private $_varValues = [];

    /**
     * @inheritdoc
     */
    public function setVarValues(array $values)
    {
        foreach ($values as $key => $value) {
            $this->_varValues[$key] = $value;
        }
    }
    
    /**
     *
     * @return array
     */
    public function getVarValues()
    {
        return $this->_varValues;
    }
    
    /**
     * Get var value.
     *
     * If the key does not exist in the array, is an empty string or null the default value will be returned.
     *
     * @param string $key The name of the key you want to retrieve
     * @param mixed  $default A default value that will be returned if the key isn't found or empty.
     * @return mixed
     */
    public function getVarValue($key, $default = false)
    {
        return (isset($this->_varValues[$key]) && $this->_varValues[$key] != '') ? $this->_varValues[$key] : $default;
    }
    
    private $_cfgValues = [];
    
    /**
     * @inheritdoc
     */
    public function setCfgValues(array $values)
    {
        foreach ($values as $key => $value) {
            $this->_cfgValues[$key] = $value;
        }
    }

    /**
     *
     * @return array
     */
    public function getCfgValues()
    {
        return $this->_cfgValues;
    }

    /**
     * Get cfg value.
     *
     * If the key does not exist in the array, is an empty string or null the default value will be returned.
     *
     * @param string $key The name of the key you want to retrieve
     * @param mixed  $default A default value that will be returned if the key isn't found or empty.
     * @return mixed
     */
    public function getCfgValue($key, $default = false)
    {
        return (isset($this->_cfgValues[$key]) && $this->_cfgValues[$key] != '') ? $this->_cfgValues[$key] : $default;
    }
    
    /**
     * Define additional variables.
     *
     * @return array
     */
    public function extraVars()
    {
        return [];
    }
    
    /**
     * Add an extra var entry.
     *
     * If the extra var is defined in extraVars() the key will be overriden.
     * @param string $key
     * @param mixed $value
     */
    public function addExtraVar($key, $value)
    {
        $this->_extraVars[$key] = $value;
    }
    
    private $_extraVars = [];
    
    /**
     * @inheritdoc
     */
    public function getExtraVarValues()
    {
        $this->_extraVars = ArrayHelper::merge($this->extraVars(), $this->_extraVars);
        return $this->_extraVars;
    }
    
    private $_assignExtraVars = false;
    
    /**
     *
     * @param string $key
     * @param string $default
     * @return string|mixed
     */
    public function getExtraValue($key, $default = false)
    {
        if (!$this->_assignExtraVars) {
            $this->getExtraVarValues();
            $this->_assignExtraVars = true;
        }
        return (isset($this->_extraVars[$key])) ? $this->_extraVars[$key] : $default;
    }
    
    /**
     * Returns an array with additional help informations for specific field (var or cfg).
     *
     * @return array An array where the key is the cfg/var field var name and the value the helper text.
     */
    public function getFieldHelp()
    {
        return [];
    }

    private $_vars = [];
    
    /**
     * @inheritdoc
     */
    public function getConfigVarsExport()
    {
        $config = $this->config();
        
        if (isset($config['vars'])) {
            foreach ($config['vars'] as $item) {
                $iteration = count($this->_vars) + 500;
                $this->_vars[$iteration] = (new BlockVar($item))->toArray();
            }
        }
        ksort($this->_vars);
        return array_values($this->_vars);
    }

    /**
     * Add a var variable to the config.
     *
     * @param array $varConfig
     * @param boolean Whether the variable should be append to the end instead of prepanding.
     */
    public function addVar(array $varConfig, $append = false)
    {
        $count = count($this->_vars);
        $iteration = $append ? $count + 1000 : $count;
        $this->_vars[$iteration] = (new BlockVar($varConfig))->toArray();
    }
    
    /**
     * @inheritdoc
     */
    public function getConfigPlaceholdersExport()
    {
        $array =  (array_key_exists('placeholders', $this->config())) ? $this->config()['placeholders'] : [];
        
        $holders = [];
        
        foreach ($array as $holder) {
            if (isset($holder['var'])) {
                $holders[] = $holder;
            } else {
                foreach ($holder as $columnHolder) {
                    $holders[] = $columnHolder;
                }
            }
        }
        
        return $holders;
    }
    
    /**
     * @inheritdoc
     */
    public function getConfigPlaceholdersByRowsExport()
    {
        $array =  (array_key_exists('placeholders', $this->config())) ? $this->config()['placeholders'] : [];
        
        $rows = [];
        
        foreach ($array as $holder) {
            if (isset($holder['var'])) {
                $holder['cols'] = 12;
                $rows[] = [$holder];
            } else {
                $rows[] = $holder;
            }
        }
        
        return $rows;
    }
    
    private $_cfgs = [];

    /**
     * @inheritdoc
     */
    public function getConfigCfgsExport()
    {
        $config = $this->config();
        
        if (isset($config['cfgs'])) {
            foreach ($config['cfgs'] as $item) {
                $iteration = count($this->_cfgs) + 500;
                $this->_cfgs[$iteration] = (new BlockCfg($item))->toArray();
            }
        }
        ksort($this->_cfgs);
        return array_values($this->_cfgs);
    }
    
    /**
     * Add a cfg variable to the config.
     *
     * @param array $cfgConfig
     * @param boolean Whether the variable should be append to the end instead of prepanding.
     */
    public function addCfg(array $cfgConfig, $append = false)
    {
        $count = count($this->_cfgs);
        $iteration = $append ? $count + 1000 : $count;
        $this->_cfgs[$iteration] = (new BlockCfg($cfgConfig))->toArray();
    }
    
    /**
     * Returns the name of the php file to be rendered.
     *
     * @return string The name of the php file (example.php)
     */
    public function getViewFileName($extension)
    {
        $className = get_class($this);
    
        if (preg_match('/\\\\([\w]+)$/', $className, $matches)) {
            $className = $matches[1];
        }
    
        return $className.'.'.$extension;
    }
    
    /**
     * Make sure the module contains its alias prefix @
     *
     * @return string The module name with alias prefix @.
     */
    protected function ensureModule()
    {
        $moduleName = $this->module;
        if (substr($moduleName, 0, 1) !== '@') {
            $moduleName = '@'.$moduleName;
        }
        
        return $moduleName;
    }
    
    /**
     * Configure Variations.
     *
     * ```php
     * TextBlock::variations()
     *     ->add('bold', 'Bold Font with Markdown')->cfgs(['cssClass' => 'bold-font-class'])->vars(['textType' => 1])
     *     ->add('italic', 'Italic Font')->cfgs(['cssClass' => 'italic-font-class'])
     *     ->register(),
     * VideoBlock::variations()
     *     ->add('bold', 'Bold Videos')->cfgs([])->register(),
     * ```
     *
     * @return \luya\cms\base\BlockVariationRegister
     */
    public static function variations()
    {
        return (new BlockVariationRegister(new static));
    }
}
