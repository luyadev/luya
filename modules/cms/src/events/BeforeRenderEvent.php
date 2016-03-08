<?php

namespace cms\events;

class BeforeRenderEvent extends \yii\base\Event
{
    public $isValid = true;
    
    public $menu = null;
}
