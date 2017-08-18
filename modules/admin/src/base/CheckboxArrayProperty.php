<?php

namespace luya\admin\base;

use yii\helpers\Json;

/**
 * Checkbox Array Property.
 *
 * Provide items to select and returns the selected items.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
abstract class CheckboxArrayProperty extends Property
{
    abstract public function items();
    
    /**
     * @inheritdoc
     */
    public function type()
    {
        return self::TYPE_CHECKBOX_ARRAY;
    }

    /**
     * @inheritdoc
     */
    public function options()
    {
        $options = [];
        foreach ($this->items as $value => $label) {
            $options = ['value' => $value, 'label' => $label];
        }
        
        return ['items' => $options];
    }

    public function getAdminValue()
    {
        $value = parent::getValue();
        return Json::decode($value);
    }
    
    public function getValue()
    {
        $value = parent::getValue();
        return Json::decode($value);
    }
}
