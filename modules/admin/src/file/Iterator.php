<?php

namespace luya\admin\file;

/**
 * Iterator class for file items.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class Iterator extends \luya\admin\storage\IteratorAbstract
{
    /**
     * Iterator get current element, generates a new object for the current item on acces.
     *
     * @return \luya\admin\file\Item
     */
    public function current()
    {
        return Item::create(current($this->data));
    }
}
