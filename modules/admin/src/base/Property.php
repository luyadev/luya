<?php

namespace admin\base;

use admin\helpers\I18n;

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
    
    public $i18n = false;

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
        if ($this->i18n) {
            $this->value = I18n::decode($this->value);
        }
        return $this->value;
    }
}
