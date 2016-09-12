<?php

namespace luya\admin\image;

/**
 * Iterator class for file items.
 *
 * @since 1.0.0-beta2
 *
 * @author nadar
 */
class Iterator extends \luya\admin\storage\IteratorAbstract
{
    /**
     * Iterator get current element, generates a new object for the current item on access.
     *
     * @return \cms\menu\Item
     */
    public function current()
    {
        return Item::create(current($this->data));
    }
}
