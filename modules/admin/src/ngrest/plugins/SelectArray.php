<?php

namespace luya\admin\ngrest\plugins;

use luya\helpers\ArrayHelper;

/**
 * Create a selection based on an assoc array provided via $data attribute.
 *
 * Example usage:
 *
 * ```php
 * public function ngRestAttributeTypes()
 * {
 *     'genres' => ['selectArray', 'data' => [1 => 'Male', 2 => 'Female']],
 * }
 * ```
 *
 * @property array $data Setter/Getter for the dropdown values.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class SelectArray extends Select
{
    private $_data;
    
    /**
     * Setter method for Data.
     *
     * @param array $data
     */
    public function setData(array $data)
    {
        $this->_data = $data;
    }
    
    /**
     *
     * {@inheritDoc}
     * @see \luya\admin\ngrest\plugins\Select::getData()
     */
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
