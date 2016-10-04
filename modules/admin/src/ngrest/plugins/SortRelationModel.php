<?php

namespace luya\admin\ngrest\plugins;

/**
 * Create a releation array based on an ActiveRecord Model.
 *
 * Example usage:
 *
 * ```
 * public function ngrestAttributeTypes()
 * {
 * 		'genres' => ['sortRelationModel', 'modelClass' => path\to\Genres::className(), 'valueField' => 'id', 'labelField' => 'title']],
 * }
 * ```
 *
 * @author nadar
 */
class SortRelationModel extends SortRelation
{
    public $modelClass = null;
    
    public $valueField = null;
    
    public $labelField = null;
    
    public function getData()
    {
        $class = $this->modelClass;
        
        if (is_object($class)) {
            $class = $class::className();
        }
        $data = [];
        
        foreach ($class::find()->orderBy([$this->labelField => SORT_ASC])->all() as $item) {
            $label = $item->{$this->labelField};
        
            if (is_array($label)) {
                $label = reset($label);
            }
        
            $data[] = [
                'value' => (int) $item->{$this->valueField},
                'label' => $label,
            ];
        }
        
        return ['sourceData' => $data];
    }
    
    public function onAfterFind($event)
    {
        $data = $event->sender->getAttribute($this->name);
        
        if (!empty($data)) {
            $ids = [];
            foreach ($data as $key) {
                $ids[]=$key['value'];
            }
            $class = $this->modelClass;
            $event->sender->setAttribute($this->name, $class::find()->where(['in', 'id', $ids])->all());
        }
    }
}
