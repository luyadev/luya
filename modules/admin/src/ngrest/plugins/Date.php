<?php

namespace luya\admin\ngrest\plugins;

use luya\admin\ngrest\base\Plugin;

/**
 * Data input field
 *
 * When dealing with empty time values you can configure `emptyMessage` in order to change the display default text in
 * the list view.
 *
 * Example empty Date configuration
 *
 * ```
 * ['timestamp', ['Date', 'emptyMessage' => 'No Date']],
 * ```
 *
 * @author Basil Suter <basil@nadar.io>
 */
class Date extends Plugin
{
    /**
     * @var string This text will be displayed in the list overview when no date has been slected
     * or date is null/empty.
     */
    public $emptyMessage = '-';

    /**
     * @var string The format of date will be use when showing data
     */
    public $dateFormat = 'shortDate';
    
    /**
     * @inheritdoc
     */
    public function renderList($id, $ngModel)
    {
        return [
            $this->createTag('span', null, ['ng-show' => $ngModel, 'ng-bind' => $ngModel.'*1000 | date : \'' . $this->dateFormat . '\'']),
            $this->createTag('span', $this->emptyMessage, ['ng-show' => '!'.$ngModel]),
        ];
    }

    /**
     * @inheritdoc
     */
    public function renderCreate($id, $ngModel)
    {
        return $this->createFormTag('zaa-date', $id, $ngModel, ['dateFormat' => $this->dateFormat]);
    }

    /**
     * @inheritdoc
     */
    public function renderUpdate($id, $ngModel)
    {
        return $this->renderCreate($id, $ngModel);
    }
}
