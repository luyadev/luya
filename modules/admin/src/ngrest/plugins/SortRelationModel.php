<?php

namespace luya\admin\ngrest\plugins;

/**
 * Sort Relation Model Plugin.
 *
 * Generate a multi selectable and sortable input from an ActiveRecord Model.
 *
 * Example usage:
 *
 * ```php
 * public function ngRestAttributeTypes()
 * {
 *     'genres' => ['sortRelationModel', 'modelClass' => 'app\models\GenresActiveRecord', 'valueField' => 'id', 'labelField' => 'title']]
 * }
 * ```
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class SortRelationModel extends SortRelation
{
    /**
     * @var string The model class to take the data from.
     */
    public $modelClass;

    /**
     * @var string The name of the field which should be used as value, like the id or any other identifier.
     */
    public $valueField;
    
    /**
     *
     * @var string The name of the field which should display the record label.
     */
    public $labelField;
    
    /**
     * @inheritdoc
     */
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
    
    /**
     * @inheritdoc
     */
    public function onAfterFind($event)
    {
        $data = $event->sender->getAttribute($this->name);
        
        if (!empty($data)) {
            $ids = [];
            foreach ($data as $key) {
                $ids[] = $key['value'];
            }
            $class = $this->modelClass;
            $event->sender->setAttribute($this->name, $class::find()->where(['in', 'id', $ids])->all());
        }
    }
}
