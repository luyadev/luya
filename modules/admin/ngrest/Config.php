<?php

namespace admin\ngrest;

/**
 * ['list' => [
 *         'firstname' => [
 *             'name' => 'firstname',
 *             'alias' => 'Vorname',
 *             'plugins' => [
 *                 'class' => '\\luya\\ngrest\\plugins\\Dropdown',
 *                 'args' => ['arg1' => 'arg1_value', 'arg2' => 'arg2_value']
 *             ]
 *         ]
 *     ]
 * ].
 *
 * @author nadar
 */
class Config implements \admin\ngrest\base\ConfigInterface
{
    private $config = [];

    private $pointer = [];

    private $pointersMap = ['list', 'create', 'update', 'delete', 'aw'];

    private $options = [];

    public $i18n = [];

    public $extraFields = [];

    private $restUrlPrefix = 'admin/'; /* could be: http://www.yourdomain.com/admin/; */

    public function __construct($restUrl, $restPrimaryKey, $options = [])
    {
        $this->restUrl = $this->restUrlPrefix.$restUrl;
        $this->restPrimaryKey = $restPrimaryKey;
        $this->options = $options;
        $this->list->field($restPrimaryKey, 'ID')->text();
    }

    public function __set($key, $value)
    {
        if (!array_key_exists($key, $this->config)) {
            $this->config[$key] = $value;
        }
    }

    public function pointerExists($pointer)
    {
        return array_key_exists($pointer, $this->config);
    }

    public function __get($key)
    {
        // @TODO see if pointer exists in $this->$pointersMap
        if (!in_array($key, $this->pointersMap)) {
            throw new \Exception("the requested pointer $key does not exists in the pointer map config");
        }
        $this->$key = [];
        $this->pointer['key'] = $key;

        return $this;
    }

    public function __call($name, $args)
    {
        $this->config[$this->pointer['key']][$this->pointer['field']]['plugins'][] = [
            'class' => '\\admin\\ngrest\\plugins\\'.ucfirst($name), 'args' => $args,
        ];

        return $this;
    }

    /**
     * return the all plugins fore this type.
     *
     * @todo should we directly return the static class method from the plugin as lambda function?
     */
    public function getPlugins($type)
    {
        $events = [];
        foreach ($this->getKey($type) as $item) {
            foreach ($item['plugins'] as $plugin) {
                $events[$item['name']][] = $plugin;
            }
        }

        return $events;
    }

    /**
     * testing purpose.
     *
     * @param array $fields
     */
    public function i18n(array $fields)
    {
        $this->i18n = $fields;
    }

    public function field($name, $alias, $gridCols = 12)
    {
        $this->config[$this->pointer['key']][$name] = [
            'name' => $name, 'gridCols' => $gridCols, 'alias' => $alias, 'plugins' => [], 'i18n' => false, 'extraField' => false,
        ];
        $this->pointer['field'] = $name;

        return $this;
    }

    public function extraField($name, $alias, $gridCols = 12)
    {
        if (!$this->extraFieldExists($name)) {
            throw new \Exception('If you set extraFields, you have to define them first as a property inside your AR model.');
        }

        $this->config[$this->pointer['key']][$name] = [
            'name' => $name, 'gridCols' => $gridCols, 'alias' => $alias, 'plugins' => [], 'i18n' => false, 'extraField' => true,
        ];
        $this->pointer['field'] = $name;

        return $this;
    }

    public function fieldArgAppend($fieldName, $key, $value)
    {
        foreach ($this->pointersMap as $pointer) {
            if ($this->pointerExists($pointer)) {
                foreach ($this->config[$pointer] as $field => $args) {
                    if ($fieldName !== $field) {
                        continue;
                    }
                    $this->config[$pointer][$field][$key] = $value;
                }
            }
        }
    }

    public function copyFrom($key, $removeFields = [])
    {
        $temp = $this->config[$key];
        foreach ($removeFields as $name) {
            if (!array_key_exists($name, $temp)) {
                throw new \Exception('Error'); // @todo create exception class
            }
            unset($temp[$name]);
        }
        $this->config[$this->pointer['key']] = $temp;
    }

    public function register($activeWindowObject, $alias)
    {
        if ($this->pointer['key'] !== 'aw') {
            throw new \Exception('register method can only be used in aw pointer context.');
        }
        $activeWindowClass = get_class($activeWindowObject);
        $activeWindowHash = sha1($this->getNgRestConfigHash().$activeWindowClass);
        $this->config[$this->pointer['key']][$activeWindowHash] = [
            'object' => $activeWindowObject,
            'activeWindowHash' => $activeWindowHash,
            'class' => $activeWindowClass,
            'alias' => $alias,
            'on' => [], // remove fully
        ];
        $this->pointer['register'] = $activeWindowHash;

        return $this;
    }

    public function get()
    {
        return $this->config;
    }

    public function getOption($key, $defaultValue = '')
    {
        return (isset($this->options[$key])) ? $this->options[$key] : $defaultValue;
    }

    public function getKey($key)
    {
        if (isset($this->config[$key])) {
            return $this->config[$key];
        }

        return [];
    }

    public function getRestUrl()
    {
        return $this->config['restUrl'];
    }

    public function getRestPrimaryKey()
    {
        return $this->config['restPrimaryKey'];
    }

    public function getNgRestConfigHash()
    {
        return ucfirst(sha1($this->config['restUrl'].$this->config['restPrimaryKey']));
    }

    public function extraFieldExists($name)
    {
        if (in_array($name, $this->extraFields)) {
            return true;
        }

        return false;
    }

    public function setExtraFields(array $extraFields)
    {
        $this->extraFields = $extraFields;
    }

    public function onFinish()
    {
        foreach ($this->i18n as $fieldName) {
            $this->fieldArgAppend($fieldName, 'i18n', true);
        }
    }
}
