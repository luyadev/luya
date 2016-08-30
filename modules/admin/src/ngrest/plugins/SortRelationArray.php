<?php

namespace luya\admin\ngrest\plugins;

class SortRelationArray extends SortRelation
{
    private $_data = null;
    
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
