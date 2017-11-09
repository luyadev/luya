<?php

namespace luya\admin\ngrest;

use Yii;
use luya\Exception;
use luya\helpers\ArrayHelper;

/**
 * Config Builder class to make the NgRest Configs
 *
 * @property \luya\admin\ngrest\ConfigBuilder $list Set the pointer to list and return the ConfigBuilder for this pointer.
 * @property \luya\admin\ngrest\ConfigBuilder $create Set the pointer to create and return the ConfigBuilder for this pointer.
 * @property \luya\admin\ngrest\ConfigBuilder $update Set the pointer to update and return the ConfigBuilder for this pointer.
 * @property \luya\admin\ngrest\ConfigBuilder $aw Set the pointer to aw and return the ConfigBuilder for this pointer.
 * @property boolean $delete Define whether the delete button is availabe or not
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class ConfigBuilder implements ConfigBuilderInterface
{
    protected $pointer;

    protected $field;

    protected $config = [];

    private $_pointersMap = ['list', 'create', 'update', 'delete', 'aw', 'options'];
    
    public function __construct($ngRestModelClass)
    {
        $this->ngRestModelClass = $ngRestModelClass;
    }
    
    /**
     * @var string When the ConfigBuilder is created, this property must be fulfilled by the constructor:
     */
    public $ngRestModelClass;
    
    /**
     * Maig setter function, defines whether a pointer exists or not, if not existing it will be created.
     *
     * @param string $key
     * @param mixed $value
     */
    public function __set($key, $value)
    {
        if (!array_key_exists($key, $this->config)) {
            $this->config[$key] = $value;
        }
    }

    /**
     * Set the pointer of the current object (example $config->list) se pointer['key'] = $key.
     *
     * @param string $key
     * @throws Exception
     * @return \luya\admin\ngrest\ConfigBuilder
     */
    public function __get($key)
    {
        if (!in_array($key, $this->_pointersMap)) {
            throw new Exception("the requested pointer $key does not exists in the pointer map config");
        }

        if (!array_key_exists($key, $this->config)) {
            $this->config[$key] = [];
        }
        $this->pointer = $key;

        return $this;
    }

    /**
     * Assign a Plugin to a pointer['field']. Example of using plugin
     *
     * ```php
     * ->create->field('mytext')->textarea(['placeholer' => 'example']);
     * ```
     *
     * this will call
     *
     * ```php
     * $this->addPlugin('textarea', ['placeholder' => 'example']);
     * ```
     *
     * @param unknown $name
     * @param unknown $args
     * @return ConfigBuilder
     * @throws Exception
     */
    public function __call($name, $args)
    {
        $args = (isset($args[0])) ? $args[0] : [];
        
        if (!is_array($args)) {
            throw new Exception("Ngrest plugin constructors must be provided as array config. Error in $name: $args");
        }
        
        return $this->addPlugin($this->prepandAdminPlugin($name), $args);
    }
    
    /**
     * Use the admin ngrest plugin base namespace as default
     *
     * @param unknown $name
     * @return string
     * @since 1.0.0
     */
    public function prepandAdminPlugin($name)
    {
        return '\\luya\\admin\\ngrest\\plugins\\'.ucfirst($name);
    }
    
    /**
     * Add a Plugin to the current field pointer plugins array.
     *
     * @param string $name The name of the ngrest\plugin
     * @param array $args
     * @return \luya\admin\ngrest\ConfigBuilder
     * @since 1.0.0
     */
    public function addPlugin($name, array $args)
    {
        $plugin = ['class' => $name, 'args' => $args];
        $this->config[$this->pointer][$this->field]['type'] = $plugin;
        
        return $this;
    }

    /**
     * Define a field.
     *
     * @param string $name
     * @param string $alias
     * @param boolean $i18n
     * @return \luya\admin\ngrest\ConfigBuilder
     */
    public function field($name, $alias = null, $i18n = false)
    {
        $this->config[$this->pointer][$name] = [
            'name' => $name,
            'i18n' => $i18n,
            'alias' => (is_null($alias)) ? $name : $alias,
            'type' => null,
            'extraField' => false,
        ];

        $this->field = $name;

        return $this;
    }

    /**
     * Define an extra field.
     *
     * @param string $name
     * @param string $alias
     * @param boolean $i18n
     * @return \luya\admin\ngrest\ConfigBuilder
     */
    public function extraField($name, $alias, $i18n = false)
    {
        $this->config[$this->pointer][$name] = [
            'name' => $name, 'i18n' => $i18n, 'alias' => (is_null($alias)) ? $name : $alias, 'type' => null, 'extraField' => true,
        ];
        $this->field = $name;
    
        return $this;
    }

    /**
     * Creates a new active window object using the given configuration.
     *
     * Below are some usage examples:
     *
     * ```php
     * // create an object using a class name
     * load('app\modules\foobar\test\MyActiveWindow');
     *
     * // create an object using a configuration array
     * load([
     *     'class' => 'app\modules\foobar\test\MyActiveWindow',
     *     'property1' => 'value for property 1'
     * ]);
     *
     * ```
     *
     * @param string|array $objectType the object type. This can be specified in one of the following forms:
     * + a string: representing the class name of the object to be created
     * + a configuration array: the array must contain a `class` element which is treated as the object class,
     *   and the rest of the name-value pairs will be used to initialize the corresponding object properties
     * @return $this
     * @throws Exception
     * @since 1.0.0
     */
    public function load($objectType)
    {
        if ($this->pointer !== 'aw') {
            throw new Exception('Register method can only be used in a pointer context.');
        }
        
        $object = Yii::createObject($objectType);
        
        if (is_string($objectType)) {
            $config['class'] = $objectType;
        } else {
            $config = $objectType;
        }
        
        $config['ngRestModelClass'] = $this->ngRestModelClass;
        
        $this->config[$this->pointer][$object->getHashName()] = [
            'objectConfig' => $config,
            'label' => $object->getLabel(),
            'icon' => $object->getIcon(),
        ];
        
        return $this;
    }

    /**
     * Copy from a pointer into another with optional removal of fields, the copie will applied
     * to the current active pointer.
     *
     * @param string $key The pointer to copy from
     * @param array $removeFields
     */
    public function copyFrom($key, $removeFields = [])
    {
        $temp = $this->config[$key];
        foreach ($removeFields as $name) {
            if (array_key_exists($name, $temp)) {
                unset($temp[$name]);
            }
        }

        $this->config[$this->pointer] = ArrayHelper::merge($this->config[$this->pointer], $temp);
    }

    /**
     * @inheritdoc
     */
    public function getConfig()
    {
        return $this->config;
    }
}
