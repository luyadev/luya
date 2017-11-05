<?php

namespace luya\admin\ngrest\plugins;

/**
 * Sortable Relation from Active Record Input.
 *
 * Example usage:
 *
 * ```php
 * public function ngRestAttributeTypes()
 * {
 * 		'genres' => ['sortRelationModel', 'modelClass' => path\to\Genres::className(), 'valueField' => 'id', 'labelField' => 'title']],
 * }
 * ```
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class SortRelationModel extends SortRelation
{
    public $modelClass;
    
    public $valueField;
    
    public $labelField;
    
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
