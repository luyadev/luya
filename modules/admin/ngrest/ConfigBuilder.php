<?php

namespace admin\ngrest;

use Exception;

class ConfigBuilder
{
    protected $pointer = null;
    
    protected $field = null;
    
    private $_pointersMap = ['list', 'create', 'update', 'delete', 'aw'];
    
    public $config = [];
    
    public function __set($key, $value)
    {
        if (!array_key_exists($key, $this->config)) {
            $this->config[$key] = $value;
        }
    }
    
    /**
     * Set the pointer of the current object (example $config->list) se pointer['key'] = $key
     *
     * @param string $key
     * @throws Exception
     * @return \admin\ngrest\Config
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
     * Assign a Plugin to a pointer['field']
     *
     * @param unknown $name
     * @param unknown $args
     * @return \admin\ngrest\Config
     */
    public function __call($name, $args)
    {
        $plugin = ['class' => '\\admin\\ngrest\\plugins\\'.ucfirst($name), 'args' => $args ];
        $this->config[$this->pointer][$this->field]['plugins'][] = $plugin;
        return $this;
    }
    
    public function field($name, $alias = null, $gridCols = 12)
    {
        $this->config[$this->pointer][$name] = [
            'name' => $name,
            'gridCols' => $gridCols,
            'alias' => (is_null($alias)) ? $name : $alias,
            'plugins' => [],
            'i18n' => false,
            'extraField' => false,
        ];
    
        $this->field = $name;
        
        return $this;
    }
    
    public function register($activeWindowObject, $alias)
    {
        if ($this->pointer !== 'aw') {
            throw new Exception('register method can only be used in aw pointer context.');
        }
        
        $activeWindowClass = get_class($activeWindowObject);
        $activeWindowHash = sha1($alias.$activeWindowClass);
        $this->config[$this->pointer][$activeWindowHash] = [
            'object' => $activeWindowObject,
            'activeWindowHash' => $activeWindowHash,
            'class' => $activeWindowClass,
            'alias' => $alias,
        ];
    
        return $this;
    }
    
    public function extraField($name, $alias, $gridCols = 12)
    {
        /*
        if (!$this->extraFieldExists($name)) {
            throw new \Exception('If you set extraFields, you have to define them first as a property inside your AR model.');
        }
        */
    
        $this->config[$this->pointer][$name] = [
            'name' => $name, 'gridCols' => $gridCols, 'alias' => $alias, 'plugins' => [], 'i18n' => false, 'extraField' => true,
        ];
        $this->field = $name;
    
        return $this;
    }
    
    public function copyFrom($key, $removeFields = [])
    {
        $temp = $this->config[$key];
        foreach ($removeFields as $name) {
            if (!array_key_exists($name, $temp)) {
                //throw new \Exception("Unable to remove field '$name' from '$key' config. The field does not exists in the provided config.");
            }
            unset($temp[$name]);
        }
        $this->config[$this->pointer] = $temp;
    }
    
    
    public function getConfig()
    {
        return $this->config;
    }
}