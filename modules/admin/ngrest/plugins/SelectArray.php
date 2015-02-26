<?php
namespace admin\ngrest\plugins;

class SelectArray extends \admin\ngrest\plugins\Select
{
    public function __construct(array $assocArray)
    {
        $options = ['array' => $assocArray];
        
        parent::__construct($options);
    }
}