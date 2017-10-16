<?php

namespace luya\cms\base;

use Exception;

/**
 * Config Element abstraction.
 *
 * In order to make sure all config() elements has same values, this class implement
 * check routines for
 *
 * + {{\luya\cms\base\BlockCfg}}
 * + {{\luya\cms\base\BlockVar}}
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
abstract class BlockConfigElement
{
    public $item = [];

    protected $id;

    /**
     *
     * @param array $item The element config with all fields.
     * @throws Exception
     */
    public function __construct(array $item)
    {
        $this->item = $item;
        if (!$this->has(['var', 'label', 'type'])) {
            throw new Exception('Required attributes in config var element is missing. var, label and type are required.');
        }
        $this->id = md5($this->get('var').uniqid());
    }

    /**
     * Has the config element an element or not.
     *
     * @param string $key
     * @return boolean
     */
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

    /**
     * Get the element value.
     *
     * @param string $key
     * @param mixed $default
     * @return string
     */
    protected function get($key, $default = null)
    {
        if (!$this->has($key)) {
            return $default;
        }

        return $this->item[$key];
    }

    /**
     * Extract the data from the element.
     *
     * @return array
     */
    abstract public function toArray();
}
