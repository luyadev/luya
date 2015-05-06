<?php

namespace admin\ngrest\plugins;

class SelectArray extends \admin\ngrest\plugins\Select
{
    public function __construct(array $assocArray)
    {
        foreach ($assocArray as $key => $value) {
            $this->data[] = [
                'value' => $key,
                'label' => $value,
            ];
        }
    }
}
