<?php

namespace admin\ngrest\plugins;

class Date extends \admin\ngrest\base\Plugin
{
    public function renderList($doc)
    {
        $activatedElement = $doc->createElement('span', '{{item.'.$this->name.'*1000 | date : \'dd.MM.yyyy\'}}');
        $activatedElement->setAttribute('ng-if', 'item.'.$this->name);
        
        $disabledElement = $doc->createElement('span', '-');
        $disabledElement->setAttribute('ng-if', '!item.'.$this->name);
        
        $doc->appendChild($activatedElement);
        $doc->appendChild($disabledElement);

        return $doc;
    }

    public function renderCreate($doc)
    {
        $elmn = $this->createBaseElement($doc, 'zaa-date');
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
