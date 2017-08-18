<?php

namespace luya\admin\base;

/**
 * Checkbox Base Property.
 *
 * Whether is checked or not:
 *
 * ```php
 * echo Yii::$app->menu->current->getProperty('myCheckbox')->getValue() ? 'Its checked!' : 'Its NOT checked...';
 * ```
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
abstract class CheckboxProperty extends Property
{
    /**
     * @inheritdoc
     */
    public function type()
    {
        return self::TYPE_CHECKBOX;
    }

    /**
     * @inheritdoc
     */
    public function options()
    {
        return [
            'true-value' => 1,
            'false-value' => 0,
        ];
    }

    /**
     * @inheritdoc
     */
    public function getValue()
    {
        return (bool) parent::getValue();
    }
}
