<?php

namespace luya\cms\menu;

use Yii;
use FilterIterator;
use Countable;
use luya\cms\frontend\events\MenuItemEvent;
use luya\cms\Menu;

/**
 * Iterator filter to verify valid events
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
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
        if (isset($this->getInnerIterator()->with['hidden'])) {
            $event->visible = true;
        }
        Yii::$app->menu->trigger(Menu::EVENT_ON_ITEM_FIND, $event);
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
