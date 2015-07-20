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
        $elmn = $this->createBaseElement($doc, 'input');
        $elmn->setAttribute('ng-true-value', '1');
        $elmn->setAttribute('ng-false-value', '0');
        $elmn->setAttribute('value', 1);
        $elmn->setAttribute('class', 'form__input');
        $elmn->setAttribute('type', 'checkbox');
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
