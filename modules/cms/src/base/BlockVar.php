<?php

namespace luya\cms\base;

class BlockVar extends BlockConfigElement
{
    public function toArray()
    {
        return [
            'id' => $this->id,
            'var' => $this->item['var'],
            'label' => $this->item['label'],
            'type' => $this->item['type'],
            'placeholder' => $this->get('placeholder'),
            'options' => $this->get('options'),
            'initvalue' => $this->get('initvalue'),
        ];
    }
}
