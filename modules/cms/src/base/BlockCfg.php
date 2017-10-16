<?php

namespace luya\cms\base;

/**
 * Block CFG variables ensurence.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class BlockCfg extends BlockConfigElement
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
