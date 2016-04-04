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
            $this->createTag('span', null, ['ng-bind' => $ngModel.'*1000 | date : \'dd.MM.yyyy - HH.mm\'']),
        ];
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
