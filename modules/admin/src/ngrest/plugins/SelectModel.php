<?php

namespace admin\ngrest\plugins;

/**
 * Create a selection dropdown based on an ActiveRecord Model.
 * 
 * Example usage:
 * 
 * ```
 * public function ngrestAttributeTypes()
 * {
 * 		'genres' => ['selectModel', 'modelClass' => path\to\Genres::className(), 'valueField' => 'id', 'labelField' => 'title']],
 * }
 * ```
 *
 * @author nadar
 */
class SelectModel extends \admin\ngrest\plugins\Select
{
    public $modelClass = null;
    
    public $valueField = null;
    
    public $labelField = null;
    
    public function init()
    {
        parent::init();
        
        $this->data[] = [
            'value' => null,
            'label' => \admin\Module::t('ngrest_select_no_selection'),
        ];
        $this->data[] = [
            'value' => null,
            'label' => "- - - - - - - - - - - - - - - -",
        ];
        
        $class = $this->modelClass;
        
        if (is_object($class)) {
            $class = $class::className();
        }
        
        foreach ($class::find()->all() as $item) {
            $label = $item->{$this->labelField};
        
            if (is_array($label)) {
                $label = reset($label);
            }
        
            $this->data[] = [
                'value' => (int) $item->{$this->valueField},
                'label' => $label,
            ];
        }
    }
    /*
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
    */
}
