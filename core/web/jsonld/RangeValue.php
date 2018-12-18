<?php

namespace luya\web\jsonld;

use yii\base\InvalidConfigException;

class RangeValue extends BaseValue
{
    private $_value;

    public function __construct($value)
    {
        $this->_value = $value;
    }

    public function ensureRange($min, $max)
    {
        if ($this->_value < $min || $this->_value > $max) {
            throw new InvalidConfigException("Value {$this->_value} must be min {$min} or max {$max}.");
        }
    }

    public function getValue()
    {
        return $this->_value;
    }
}
