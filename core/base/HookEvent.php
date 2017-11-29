<?php

namespace luya\base;

use yii\base\BaseObject;

/**
 * HookEvent Object.
 *
 * Each Hook Event is represented and evaluated by this Object. See {{luya\Hook}}.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
final class HookEvent extends BaseObject implements \ArrayAccess
{
    /**
     * @var array|callable The executable handler to use when calling the hook event in order to generate the $output.
     */
    public $handler;
    
    /**
     * @var string The output which is generated when the $handler is called, this is used in order to return string outputs.
     */
    public $output;
    
    /**
     * @var boolean Whether the hook event is handled already or not.
     */
    public $isHandled = false;
    
    /**
     * @var boolean Whether the current event is valid or not, if set to false, this event will not be triggered on output.
     */
    public $isValid = true;
    
    private $_iterations = [];
    
    /**
     * Getter method for iteration.
     *
     * @return array
     */
    public function getIterations()
    {
        return $this->_iterations;
    }
    
    /**
     * Add Iteration
     * @param mixed $value The value of the key
     * @param string $key The key of the array
     */
    public function iteration($value, $key = null)
    {
        if (is_null($key)) {
            $this->_iterations[] = $value;
        } else {
            $this->_iterations[$key] = $value;
        }
    }
    
    public function offsetSet($offset, $value)
    {
        $this->iteration($value, $offset);
    }
    
    public function offsetExists($offset)
    {
        return isset($this->_iterations[$offset]);
    }
    
    public function offsetUnset($offset)
    {
        unset($this->_iterations[$offset]);
    }
    
    public function offsetGet($offset)
    {
        return isset($this->_iterations[$offset]) ? $this->_iterations[$offset] : null;
    }
}
