<?php

namespace cms\menu;

use Yii;
use FilterIterator;
use Countable;
use cms\events\MenuItemEvent;

/**
 * Iterator filter to verify valid events
 * 
 * @author nadar
 * @since 1.0.0-beta5
 */
class QueryIteratorFilter extends FilterIterator implements Countable
{
    /**
     * Verifys if an menu item does have valid event response.
     * 
     * {@inheritDoc}
     * @see FilterIterator::accept()
     */
    public function accept()
    {
        $event = new MenuItemEvent();
        $event->item = $this->current();
        Yii::$app->menu->trigger(Container::MENU_ITEM_EVENT, $event);
        return $event->visible;
    }
    
    /**
     * Callculate to number of items when using count() function against the QueryIterator object.
     *
     * @return int The number of elements in the object.
     */
    public function count()
    {
        return count($this->getInnerIterator()->data);
    }
}