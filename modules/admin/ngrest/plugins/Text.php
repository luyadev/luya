<?php

namespace admin\ngrest\plugins;

use admin\ngrest\PluginAbstract;

class Text extends PluginAbstract
{
    public function renderList($doc)
    {
        $elmn = $doc->createElement('span', '{{item.'.$this->name.'}}');
        $doc->appendChild($elmn);

        return $doc;
    }

    public function renderCreate($doc)
    {
        $elmn = $doc->createElement('zaa-input-text');
        $elmn->setAttribute('id', $this->id);
        $elmn->setIdAttribute('id', true);
        $elmn->setAttribute('model', $this->ngModel);
        $elmn->setAttribute('class', '');
        $doc->appendChild($elmn);

        return $doc;
    }

    public function renderUpdate($doc)
    {
        return $this->renderCreate($doc);
    }
}
