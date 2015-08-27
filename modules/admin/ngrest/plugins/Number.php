<?php

namespace admin\ngrest\plugins;

class Number extends \admin\ngrest\base\Plugin
{
    public $placeholder = null;

    public function __construct($placeholder = null)
    {
        $this->placeholder = $placeholder;
    }

    public function renderList($doc)
    {
        $doc->appendChild($doc->createElement('span', '{{item.'.$this->name.'}}'));

        return $doc;
    }

    public function renderCreate($doc)
    {
        $elmn = $this->createBaseElement($doc, 'zaa-number');
        $elmn->setAttribute('placeholder', $this->placeholder);
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
