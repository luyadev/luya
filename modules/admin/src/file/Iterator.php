<?php

namespace luya\admin\file;

/**
 * Iterator class for file items.
 *
 * @since 1.0.0-beta2
 *
 * @author Basil Suter <basil@nadar.io>
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
