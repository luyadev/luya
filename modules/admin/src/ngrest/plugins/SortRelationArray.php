<?php

namespace luya\admin\ngrest\plugins;

/**
 * Sort Relation Array Plugin.
 *
 * Generate a multi selectable and sortable list based on an arry input.
 *
 * Example usage:
 *
 * ```php
 * public function ngRestAttributeTypes()
 * {
 *     'genres' => ['sortRelationArray', 'data' => [1 => 'Jazz', 2 => 'Funk', 3 => 'Soul']
 * }
 * ```
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class SortRelationArray extends SortRelation
{
    private $_data;
    
    /**
     * @inheritdoc
     */
    public function getData()
    {
        $data = [];
        foreach ($this->_data as $value => $label) {
            $data[] = ['value' => $value, 'label' => $label];
        }
        
        return ['sourceData' => $data];
    }
    
    /**
     * Setter method for the data.
     *
     * @param array $data
     */
    public function setData(array $data)
    {
        $this->_data = $data;
    }
}
