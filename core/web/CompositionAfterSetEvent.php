<?php

namespace luya\web;

/**
 * Event class for the composition after set key trigger.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class CompositionAfterSetEvent extends \yii\base\Event
{
    /**
     * @var string The key identifiere where the value will be set (array key).
     */
    public $key;
    
    /**
     * @var string The value for the specific key to set (array value).
     */
    public $value;
}
