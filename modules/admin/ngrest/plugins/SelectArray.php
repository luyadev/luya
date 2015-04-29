<?php
namespace admin\ngrest\plugins;

class SelectArray extends \admin\ngrest\plugins\Select
{
    public function __construct(array $assocArray)
    {
        foreach ($this->getOption('array') as $key => $value) {
            $this->data[] = [
                "value" => $key,
                "label" => $value,
            ];
        }
    }
}
