<?php

namespace luya\admin\base;

use luya\admin\helpers\I18n;
use yii\base\Component;

/**
 * Abstract Page Property Class.
 *
 * @todo remove defaultValue change to initvalue like in blocks!
 *
 * @author nadar
 */
abstract class Property extends Component implements TypesInterface
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
