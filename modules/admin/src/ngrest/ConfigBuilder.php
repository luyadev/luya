<?php

namespace admin\ngrest;

use Yii;
use luya\Exception;
use luya\helpers\ArrayHelper;

class ConfigBuilder implements \admin\ngrest\interfaces\ConfigBuilder
{
    protected $pointer = null;

    protected $field = null;

    private $_pointersMap = ['list', 'create', 'update', 'delete', 'aw'];

    protected $config = [];

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
     * @return \admin\ngrest\ConfigBuilder
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
     * Assign a Plugin to a pointer['field'].
     *
     * @param unknown $name
     * @param unknown $args
     * @return \admin\ngrest\ConfigBuilder
     */
    public function __call($name, $args)
    {
        $args = (isset($args[0])) ? $args[0] : [];
        
        if (!is_array($args)) {
            throw new Exception("Since 1.0.0-beta6 ngrest plugin constructors must be provided as array config. Error in $name: $args");
        }
        
        return $this->addPlugin($name, $args);
    }
    
    /**
     * Add a Plugin to the current field pointer plugins array.
     * 
     * @TODO rename to addType
     * @TODO check if type is already defined
     * 
     * @param string $name The name of the ngrest\plugin
     * @param array $args
     * @return \admin\ngrest\ConfigBuilder
     * @since 1.0.0-beta4
     */
    public function addPlugin($name, array $args)
    {
        $plugin = ['class' => '\\admin\\ngrest\\plugins\\'.ucfirst($name), 'args' => $args];
        $this->config[$this->pointer][$this->field]['type'] = $plugin;
        
        return $this;
    }

    public function field($name, $alias = null, $i18n = false)
    {
        $this->config[$this->pointer][$name] = [
            'name' => $name,
            'i18n' => $i18n,
            'alias' => (is_null($alias)) ? $name : $alias,
            'type' => null, // @todo use text as default?
            'extraField' => false,
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
     * @param string|array $type the object type. This can be specified in one of the following forms:
     *
     * - a string: representing the class name of the object to be created
     * - a configuration array: the array must contain a `class` element which is treated as the object class,
     *   and the rest of the name-value pairs will be used to initialize the corresponding object properties
     *   
     * @since 1.0.0-beta4
     */
    public function load($objectType)
    {
        if ($this->pointer !== 'aw') {
            throw new Exception('Register method can only be used in aw pointer context.');
        }
        
        $object = Yii::createObject($objectType);
        
        $this->config[$this->pointer][$object->getHashName()] = [
            'object' => $object,
            'alias' => $object->getAlias(),
            'icon' => $object->getIcon(),
        ];
        
        return $this;
    }

    public function extraField($name, $alias, $i18n = false)
    {
        $this->config[$this->pointer][$name] = [
            'name' => $name, 'i18n' => $i18n, 'alias' => $alias, 'type' => null, 'extraField' => true,
        ];
        $this->field = $name;

        return $this;
    }

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

    public function getConfig()
    {
        return $this->config;
    }
}
