<?php

namespace admin\ngrest\plugins;

class ToggleStatus extends \admin\ngrest\base\Plugin
{
    public function renderList($doc)
    {
        $elmn = $doc->createElement('span', '{{item.'.$this->name.'}}');
        $doc->appendChild($elmn);

        return $doc;
    }

    public function renderCreate($doc)
    {
        $elmn = $this->createBaseElement($doc, 'zaa-checkbox');
        $elmn->setAttribute('options', json_encode(['true-value' => 1, 'false-value' => 0]));
        // append to document
        $doc->appendChild($elmn);
        // return DomDocument
        return $doc;
    }

    public function renderUpdate($doc)
    {
        return $this->renderCreate($doc);
    }
}
