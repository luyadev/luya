<?php
namespace luya\ngrest\plugins;

use luya\ngrest\PluginAbstract;

class Select extends PluginAbstract
{
    public function renderList($doc)
    {
        $elmn = $doc->createElement("crud-plugin-select");
        $elmn->setAttribute("id", $this->id);
        $elmn->setAttribute("field-value", "item.".$this->config['name']);
        $elmn->setIdAttribute("id", true);
        $doc->appendChild($elmn);

        return $doc;
    }

    public function renderCreate($doc)
    {
        $elmn = $doc->createElement("select", "");
        $elmn->setAttribute("name", $this->name);
        $elmn->setAttribute("id", $this->id);
        $elmn->setIdAttribute("id", true);
        $elmn->setAttribute("ng-model", $this->config['ngModel']);
        $doc->appendChild($elmn);

        return $doc;
    }

    public function renderUpdate($doc)
    {
        $elmn = $doc->createElement("select", "");
        $elmn->setAttribute("name", $this->name);
        $elmn->setAttribute("id", $this->id);
        $elmn->setIdAttribute("id", true);
        $elmn->setAttribute("ng-model", $this->config['ngModel']);
        $doc->appendChild($elmn);

        return $doc;
    }
}
