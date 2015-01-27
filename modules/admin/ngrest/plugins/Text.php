<?php
namespace admin\ngrest\plugins;

use admin\ngrest\PluginAbstract;

class Text extends PluginAbstract
{
    public function renderList($doc)
    {
        $elmn = $doc->createElement("span", "{{item.".$this->config['name']."}}");
        $doc->appendChild($elmn);

        return $doc;
    }

    public function renderCreate($doc)
    {
        $elmn = $doc->createElement("input");
        $elmn->setAttribute("type", "text");
        $elmn->setAttribute("name", $this->name);
        $elmn->setAttribute("id", $this->id);
        $elmn->setIdAttribute("id", true);
        $elmn->setAttribute("ng-model", $this->config['ngModel']);
        $elmn->setAttribute("class", "form__input");
        $doc->appendChild($elmn);

        return $doc;
    }

    public function renderUpdate($doc)
    {
        return $this->renderCreate($doc);
    }
}
