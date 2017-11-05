<?php

namespace luya\admin\ngrest\plugins;

/**
 * Sortable Relation from Array Input.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class SortRelationArray extends SortRelation
{
    private $_data;
    
    public function getData()
    {
        $data = [];
        foreach ($this->_data as $value => $label) {
            $data[] = ['value' => $value, 'label' => $label];
        }
        return ['sourceData' => $data];
    }
    
    public function setData(array $data)
    {
        $this->_data = $data;
    }
}
