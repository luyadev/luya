<?php

namespace luya\cms\base;

use Exception;

abstract class BlockConfigElement
{
    public $item = [];

    protected $id = null;

    public function __construct($item)
    {
        $this->item = $item;
        if (!$this->has(['var', 'label', 'type'])) {
            throw new Exception('Required attributes in config var element is missing. var, label and type are required.');
        }
        $this->id = md5($this->get('var').uniqid());
    }

    protected function has($key)
    {
        if (!is_array($key)) {
            return (array_key_exists($key, $this->item));
        }

        foreach ($key as $value) {
            if (!array_key_exists($value, $this->item)) {
                return false;
            }
        }

        return true;
    }

    protected function get($key, $default = null)
    {
        if (!$this->has($key)) {
            return $default;
        }

        return $this->item[$key];
    }

    abstract public function toArray();
}
