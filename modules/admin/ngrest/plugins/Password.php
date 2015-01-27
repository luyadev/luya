<?php
namespace admin\ngrest\plugins;

use admin\ngrest\PluginAbstract;

class Password extends PluginAbstract
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
        $elmn->setAttribute("type", "password");
        $elmn->setAttribute("name", $this->name);
        $elmn->setAttribute("placeholder", $this->alias);
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
