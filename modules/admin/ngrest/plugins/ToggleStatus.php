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
        $elmn = $doc->createElement('input');
        $elmn->setAttribute('id', $this->id);
        $elmn->setIdAttribute('id', true);
        $elmn->setAttribute('ng-model', $this->ngModel);
        $elmn->setAttribute('ng-true-value', '1');
        $elmn->setAttribute('ng-false-value', '0');
        $elmn->setAttribute('value', 1);
        $elmn->setAttribute('class', 'form__input');
        $elmn->setAttribute('type', 'checkbox');
        $doc->appendChild($elmn);

        return $doc;
    }

    public function renderUpdate($doc)
    {
        return $this->renderCreate($doc);
    }
}
