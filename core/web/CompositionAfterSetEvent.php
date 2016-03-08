<?php

namespace luya\web;

/**
 * Event class for the composition after set key trigger.
 *
 * @author nadar
 */
class CompositionAfterSetEvent extends \yii\base\Event
{
    /**
     * @var string The key identifiere where the value will be set (array key).
     */
    public $key = null;
    
    /**
     * @var string The value for the specific key to set (array value).
     */
    public $value = null;
}
