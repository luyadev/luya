<?php

namespace luya\admin\ngrest\plugins;

use luya\helpers\ArrayHelper;

/**
 * Create a selection based on an assoc array provided via $data attribute.
 *
 * Example usage:
 *
 * ```
 * public function ngrestAttributeTypes()
 * {
 * 		'genres' => ['selectArray', 'data' => [1 => 'Male', 2 => 'Female']],
 * }
 * ```
 *
 * @author nadar
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
        $cleandata = [
            //['value' => 0,'label' => \admin\Module::t('ngrest_select_no_selection')],
            //['value' => null, 'label' => "- - - - - - - - - - - - - - - -"],
        ];
         
        foreach ($this->_data as $key => $value) {
            $cleandata[] = [
                'value' => $key,
                'label' => $value,
            ];
        }

        return ArrayHelper::typeCast($cleandata);
    }
}
