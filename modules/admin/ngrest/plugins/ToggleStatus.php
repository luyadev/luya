<?php

namespace admin\ngrest\plugins;

class ToggleStatus extends \admin\ngrest\base\Plugin
{
    public function renderList($doc)
    {
        $activatedElement = $doc->createElement('i');
        $activatedElement->setAttribute('ng-if', 'item.'.$this->name);
        $activatedElement->setAttribute('ng-bind', '\'check\'');
        $activatedElement->setAttribute('class', 'material-icons');

        $disabledElement = $doc->createElement('i');
        $disabledElement->setAttribute('ng-if', '!item.'.$this->name);
        $disabledElement->setAttribute('ng-bind', '\'close\'');
        $disabledElement->setAttribute('class', 'material-icons');

        $doc->appendChild($activatedElement);
        $doc->appendChild($disabledElement);

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
