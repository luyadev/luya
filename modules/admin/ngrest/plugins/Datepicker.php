<?php
namespace admin\ngrest\plugins;

use DateTime;
use admin\ngrest\PluginAbstract;

class Datepicker extends PluginAbstract
{
    public function renderList($doc)
    {
        $elmn = $doc->createElement("span", " {{item.".$this->name."}}");
        $icon = $doc->createElement("i", ""); // fa-clock-o
        $icon->setAttribute("class", "fa fa-clock-o");
        $doc->appendChild($icon);
        $doc->appendChild($elmn);
        return $doc;
    }

    public function renderCreate($doc)
    {
        $elmn = $doc->createElement("zaa-datepicker");
        $elmn->setAttribute("id", $this->id);
        $elmn->setIdAttribute("id", true);
        $elmn->setAttribute("model", $this->ngModel);
        $elmn->setAttribute("class", "form__input");
        $doc->appendChild($elmn);
        return $doc;
    }

    public function renderUpdate($doc)
    {
        return $this->renderCreate($doc);
    }
    
    public static function onBeforeCreate($value)
    {
        return DateTime::createFromFormat("d-m-Y", $value)->getTimestamp();
    }
    
    public static function onBeforeUpdate($value)
    {
        return DateTime::createFromFormat("d-m-Y", $value)->getTimestamp();
    }
    
    public static function onAfterList($value)
    {
        return (is_numeric($value)) ? date("d-m-Y", $value) : $value;
    }
}
