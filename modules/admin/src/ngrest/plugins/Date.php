<?php

namespace admin\ngrest\plugins;

/**
 * Data input field
 * 
 * @author nadar
 */
class Date extends \admin\ngrest\base\Plugin
{
    public function renderList($id, $ngModel)
    {
        return [
            $this->createListTag($ngModel),
        ];
        
        /*
        $activatedElement = $doc->createElement('span', '{{item.'.$this->name.'*1000 | date : \'dd.MM.yyyy\'}}');
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
        return $this->createFormTag('zaa-date', $id, $ngModel);
    }

    public function renderUpdate($id, $ngModel)
    {
        return $this->renderCreate($id, $ngModel);
    }
}
