<?php

namespace luya\cms\frontend\events;

/**
 * Event after Menu component is loaded and ready.
 *
 * Each Menu Item does have en event which will be trigger after create. You can also access
 * this event in your config like this for instance:
 *
 * ```php
 * 'menu' => [
 *     'class' => 'cms\menu\Container',
 *     'on menuItemEvent' => function($event) {
 *         if ($event->item->alias == 'this-is-my-alias') {
 *             // will turn this item to invisble
 *             $event->visible = false;
 *         }
 *     }
 *  ],
 *  ```
 *
 * @author nadar
 * @since 1.0.0-beta5
 */
class MenuItemEvent extends \yii\base\Event
{
    public $item = null;
    
    private $_visible = null;
    
    public function getVisible()
    {
        return !$this->item->isHidden;
    }
    
    public function setVisible($state)
    {
        $this->item->isHidden = !$state;
    }
}
