<?php

namespace luya\admin\ngrest\plugins;

use Yii;

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
class SelectModel extends Select
{
    public $modelClass = null;
    
    public $valueField = null;
    
    public $labelField = null;
    
    private static $_dataInstance = [];

    public static function getDataInstance($class, $labelField)
    {
        if (!isset(static::$_dataInstance[$class])) {
            static::$_dataInstance[$class] = $class::find()->orderBy([$labelField => SORT_ASC])->all();
        }
        
        return static::$_dataInstance[$class];
    }
    
    public function getData()
    {
        $data = [
            //['value' => 0,'label' => \admin\Module::t('ngrest_select_no_selection')],
            //['value' => null, 'label' => "- - - - - - - - - - - - - - - -"],
        ];
        
        $class = $this->modelClass;
        
        if (is_object($class)) {
            $class = $class::className();
        }
        
        foreach (static::getDataInstance($class, $this->labelField) as $item) {
            $label = $item->{$this->labelField};
        
            if (is_array($label)) {
                $label = reset($label);
            }
        
            $data[] = [
                'value' => (int) $item->{$this->valueField},
                'label' => $label,
            ];
        }
        
        return $data;
    }
    
    public function renderCreate($id, $ngModel)
    {
        return [
            $this->createCrudLoaderTag($this->modelClass),
            $this->createFormTag('zaa-select', $id, $ngModel, ['initvalue' => $this->initValue, 'options' => $this->getServiceName('selectdata')]),
        ];
    }
}
