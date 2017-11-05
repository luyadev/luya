<?php

namespace luya\cms\frontend\events;

/**
 * An event will be triggered before the rendering of cms controller content happends.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class BeforeRenderEvent extends \yii\base\Event
{
    public $isValid = true;
    
    public $menu;
}
