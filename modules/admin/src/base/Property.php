<?php

namespace admin\base;

/**
 * Abstract Page Property Class.
 * 
 * @todo remove defaultValue change to initvalue like in blocks!
 *
 * @author nadar
 */
abstract class Property extends \yii\base\Component
{
    const EVENT_BEFORE_RENDER = 'EVENT_BEFORE_RENDER';

    public $moduleName = null;

    public $value = null;

    abstract public function varName();

    abstract public function label();

    abstract public function type();

    public function options()
    {
        return [];
    }

    public function defaultValue()
    {
        return false;
    }
    
    public function getValue()
    {
        return $this->value;
    }
}
