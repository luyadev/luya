<?php
namespace admin\ngrest\plugins;

use admin\ngrest\PluginAbstract;

class OptionValue extends PluginAbstract
{
    public $values = array();

    public function __construct($values)
    {
        $this->values = $values;
    }

    public function renderList($doc)
    {
        $select = $doc->getElementById($this->id);
        $select->setAttribute("field-args", json_encode($this->values));

        return $doc;
    }

    public function renderCreate($doc)
    {
        $select = $doc->getElementById($this->id);

        $option = $doc->createElement("option", "Bitte wählen");
        $option->setAttribute("value", 0);
        $select->appendChild($option);

        foreach ($this->values as $k => $value) {
            $elmn = $doc->createElement("option", $value);
            $elmn->setAttribute("value", $k);
            $select->appendChild($elmn);
        }

        return $doc;
    }

    public function renderUpdate($doc)
    {
        $select = $doc->getElementById($this->id);
        foreach ($this->values as $k => $value) {
            $elmn = $doc->createElement("option", $value);
            $elmn->setAttribute("value", $k);
            $select->appendChild($elmn);
        }

        return $doc;
    }
}
