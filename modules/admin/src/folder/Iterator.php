<?php

namespace luya\admin\folder;

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
     * Iterator get current element, generates a new object for the current item on access.
     *
     * @return \luya\admin\folder\Item
     */
    public function current()
    {
        return Item::create(current($this->data));
    }
}
