<?php

namespace luya\admin\storage;

use Iterator;
use Countable;
use yii\base\BaseObject;

/**
 * Iterator class for file items.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
abstract class IteratorAbstract extends BaseObject implements Iterator, Countable
{
    /**
     * @var array An array containing the data to iterate.
     */
    public $data = [];
    
    /**
     * Callculate to number of items when using count() function against the QueryIterator object.
     *
     * @return int The number of elements in the object.
    */
    public function count()
    {
        return count($this->data);
    }
    
    /**
     * Iterator get current key.
     *
     * @return string The current key
     */
    public function key()
    {
        return key($this->data);
    }
    
    /**
     * Iterator go to next element.
     *
     * @return array
     */
    public function next()
    {
        return next($this->data);
    }
    
    /**
     * Iterator rewind.
     *
     * @return array
     */
    public function rewind()
    {
        return reset($this->data);
    }
    
    /**
     * Iterator valid.
     *
     * @return bool
     */
    public function valid()
    {
        return key($this->data) !== null;
    }
    
    abstract public function current();
}
