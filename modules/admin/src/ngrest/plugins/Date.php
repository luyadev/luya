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
            $this->createTag('span', null, ['ng-bind' => $ngModel.'*1000 | date : \'dd.MM.yyyy\'']),
        ];
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
