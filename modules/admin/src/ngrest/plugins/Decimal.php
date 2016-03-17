<?php

namespace admin\ngrest\plugins;

class Decimal extends \admin\ngrest\base\Plugin
{
    public $steps = 0;

    public function __construct($decimalSteps = 0.001)
    {
        $this->steps = $decimalSteps;
    }

    public function renderList($doc)
    {
        $doc->appendChild($doc->createElement('span', '{{item.'.$this->name.'}}'));

        return $doc;
    }

    public function renderCreate($doc)
    {
        $elmn = $this->createBaseElement($doc, 'zaa-decimal');
        $elmn->setAttribute('options', json_encode(['steps' => $this->steps ]));
        // append to document
        $doc->appendChild($elmn);
        // return DomDocument
        return $doc;
    }

    public function renderUpdate($doc)
    {
        return $this->renderCreate($doc);
    }
    
    public function onAfterNgRestFind($fieldValue)
    {
        return (float) $fieldValue;
    }
}
