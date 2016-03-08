<?php

namespace admin\ngrest\plugins;

class Textarea extends \admin\ngrest\base\Plugin
{
    public $placeholder = null;

    public function __construct($placeholder = null)
    {
        $this->placeholder = $placeholder;
    }

    public function renderList($doc)
    {
        $elmn = $doc->createElement('span', '{{item.'.$this->name.'}}');
        $doc->appendChild($elmn);

        return $doc;
    }

    public function renderCreate($doc)
    {
        $elmn = $this->createBaseElement($doc, 'zaa-textarea');
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
