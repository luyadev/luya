<?php

namespace admin\ngrest\plugins;

class SelectArray extends \admin\ngrest\plugins\Select
{
    public $data = [];
    
    /*
    public function __construct(array $assocArray, $initValue = null)
    {
        $this->initValue = $initValue;

        foreach ($assocArray as $key => $value) {
            $this->data[] = [
                'value' => (int) $key,
                'label' => $value,
            ];
        }
    }
    */
}
