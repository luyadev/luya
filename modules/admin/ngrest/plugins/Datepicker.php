<?php

namespace admin\ngrest\plugins;

use DateTime;
use admin\ngrest\PluginAbstract;

class Datepicker extends PluginAbstract
{
    public function renderList($doc)
    {
        $elmn = $doc->createElement('span', ' {{item.'.$this->name.'}}');
        $doc->appendChild($elmn);

        return $doc;
    }

    public function renderCreate($doc)
    {
        $elmn = $doc->createElement('zaa-datepicker');
        $elmn->setAttribute('id', $this->id);
        $elmn->setIdAttribute('id', true);
        $elmn->setAttribute('model', $this->ngModel);
        $elmn->setAttribute('label', $this->alias);
        $elmn->setAttribute('grid', $this->gridCols);
        $doc->appendChild($elmn);

        return $doc;
    }

    public function renderUpdate($doc)
    {
        return $this->renderCreate($doc);
    }

    //

    public function onBeforeCreate($value)
    {
        if (empty($value)) {
            return 0;
        }

        return strtotime($value);
    }

    public function onBeforeUpdate($value, $oldValue)
    {
        return $this->onBeforeCreate($value);
    }

    public function onAfterList($value)
    {
        return $value;
        //return (is_numeric($value)) ? date('D M d Y H:i:s O', $value) : $value;
    }
}
