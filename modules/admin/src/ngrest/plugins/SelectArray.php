<?php

namespace luya\admin\ngrest\plugins;

use luya\helpers\ArrayHelper;

/**
 * Create a selection based on an assoc array provided via $data attribute.
 *
 * Example usage:
 *
 * ```
 * public function ngRestAttributeTypes()
 * {
 * 		'genres' => ['selectArray', 'data' => [1 => 'Male', 2 => 'Female']],
 * }
 * ```
 *
 * @author Basil Suter <basil@nadar.io>
 */
class SelectArray extends Select
{
    private $_data = null;
    
    public function setData(array $data)
    {
        $this->_data = $data;
    }
    
    public function getData()
    {
        $cleandata = [];
         
        foreach ($this->_data as $key => $value) {
            $cleandata[] = [
                'value' => $key,
                'label' => $value,
            ];
        }

        return ArrayHelper::typeCast($cleandata);
    }
}
