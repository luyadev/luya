<?php

namespace admin\ngrest\plugins;

class ToggleStatus extends \admin\ngrest\base\Plugin
{
    public function renderList($doc)
    {
        $activatedElement = $doc->createElement('span');
        $activatedElement->setAttribute("ng-class", "{'mdi-navigation-check' : item.".$this->name."}");

        $disabledElement = $doc->createElement('span');
        $disabledElement->setAttribute("ng-class", "{'mdi-navigation-close' : !item.".$this->name."}");

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
