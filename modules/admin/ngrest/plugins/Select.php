<?php
namespace admin\ngrest\plugins;

use admin\ngrest\PluginAbstract;

class Select extends PluginAbstract
{
    public function renderList($doc)
    {
        $elmn = $doc->createElement("crud-plugin-select");
        $elmn->setAttribute("id", $this->id);
        $elmn->setAttribute("field-value", "item.".$this->name);
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
        $elmn->setAttribute("ng-model", $this->ngModel);
        $elmn->setAttribute("class", "form__select");
        $doc->appendChild($elmn);

        return $doc;
    }

    public function renderUpdate($doc)
    {
        return $this->renderCreate($doc);
    }
}
