<?php

namespace cmsadmin\base;

use Exception;

class BlockVar extends \cmsadmin\base\BlockConfigElement
{
    public function toArray()
    {
        if (!$this->has(['var', 'label', 'type'])) {
            throw new Exception("Required attributes in config var element is missing. var, label and type are required.");
        }
        
        return [
            'var' => $this->item['var'],
            'label' => $this->item['label'],
            'type' => $this->item['type'],
            'placeholder' => ($this->has('placeholder')) ? $this->item['placeholder'] : null,
        ];
    }    
}