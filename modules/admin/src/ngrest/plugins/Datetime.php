<?php

namespace admin\ngrest\plugins;

/**
 * Date and Time input field
 * 
 * @author nadar
 */
class Datetime extends \admin\ngrest\base\Plugin
{
    public function renderList($id, $ngModel)
    {
        return [
            $this->createListTag($ngModel),
        ];
        /*
        $activatedElement = $doc->createElement('span', '{{item.'.$this->name.'*1000 | date : \'dd.MM.yyyy - HH.mm\'}}');
        $activatedElement->setAttribute('ng-if', 'item.'.$this->name);

        $disabledElement = $doc->createElement('span', '-');
        $disabledElement->setAttribute('ng-if', '!item.'.$this->name);

        $doc->appendChild($activatedElement);
        $doc->appendChild($disabledElement);

        return $doc;
        */
    }

    public function renderCreate($id, $ngModel)
    {
        return $this->createFormTag('zaa-datetime', $id, $ngModel);
    }

    public function renderUpdate($id, $ngModel)
    {
        return $this->renderCreate($id, $ngModel);
    }
}
