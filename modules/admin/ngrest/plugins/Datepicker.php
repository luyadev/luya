<?php

namespace admin\ngrest\plugins;

use DateTime;

class Datepicker extends \admin\ngrest\base\Plugin
{
    public function renderList($doc)
    {
        $doc->appendChild($doc->createElement('span', '{{item.'.$this->name.'*1000 | date : \'dd.MM.yyyy\'}}'));
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
}
