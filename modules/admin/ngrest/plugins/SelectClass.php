<?php
namespace admin\ngrest\plugins;

/**
 * @todo rename to SelectModel instead of SelectClass
 * @author nadar
 *
 */
class SelectClass extends \admin\ngrest\plugins\Select
{
    public function __construct($class, $valueField, $labelField)
    {
        if (is_object($class)) {
            $class = $class::className();
        }

        $options = ['model' => ['class' => $class, 'value' => $valueField, 'label' => $labelField]];

        parent::__construct($options);
    }
}
