<?php

namespace admin\ngrest\plugins;

/**
 * @todo rename to SelectModel instead of SelectClass
 *
 * @author nadar
 */
class SelectClass extends \admin\ngrest\plugins\Select
{
    public function __construct($class, $valueField, $labelField, $initValue = null)
    {
        $this->data[] = [
            'value' => null,
            'label' => \admin\Module::t('ngrest_select_no_selection'),
        ];
        $this->data[] = [
            'value' => null,
            'label' => "- - - - - - - - - - - - - - - -",
        ];

        if (is_object($class)) {
            $class = $class::className();
        }

        $this->initValue = $initValue;

        foreach ($class::find()->all() as $item) {
            $label = $item->$labelField;

            if (is_array($label)) {
                $label = reset($label);
            }

            $this->data[] = [
                'value' => (int) $item->$valueField,
                'label' => $label,
            ];
        }
    }
}
