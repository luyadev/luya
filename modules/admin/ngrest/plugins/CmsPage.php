<?php

namespace admin\ngrest\plugins;

class CmsPage extends \admin\ngrest\base\Plugin
{
    public function renderList($doc)
    {
        $doc->appendChild($doc->createElement('span', '{{item.'.$this->name.'}}'));
        // return $doc
        return $doc;
    }
    
    public function renderCreate($doc)
    {
        $doc->appendChild($this->createBaseElement($doc, 'zaa-cms-page'));
        
        return $doc;
    }
    
    public function renderUpdate($doc)
    {
        return $this->renderCreate($doc);
    }
}