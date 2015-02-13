<?php
namespace admin\ngrest\plugins;

use admin\ngrest\PluginAbstract;

class Select extends PluginAbstract
{
    public $options = [
        'values' => [],
    ];

    public function init()
    {
        $values = [];
        foreach ($this->getOption('values') as $key => $value) {
            $values[] = [
                "id" => $key,
                "label" => $value,
            ];
        }
        $this->setOption('values', $values);
    }

    public function renderList($doc)
    {
        return $doc;
    }

    public function renderCreate($doc)
    {
        $elmn = $doc->createElement("zaa-input-select");
        $elmn->setAttribute("id", $this->id);
        $elmn->setIdAttribute("id", true);
        $elmn->setAttribute("model", $this->ngModel);
        $elmn->setAttribute("options", json_encode($this->getOption('values')));
        $elmn->setAttribute("class", "form__input");
        $doc->appendChild($elmn);

        return $doc;
    }

    public function renderUpdate($doc)
    {
        return $this->renderCreate($doc);
    }
}
