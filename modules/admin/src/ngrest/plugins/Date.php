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
     *
     * + `shortDate` Equivalent to 'M/d/yy' for en_US locale (e.g. 9/3/10)
     * + 'short': equivalent to 'M/d/yy h:mm a' for en_US locale (e.g. 9/3/10 12:05 PM)
     * + 'fullDate': equivalent to 'EEEE, MMMM d, y' for en_US locale (e.g. Friday, September 3, 2010)
     * + 'longDate': equivalent to 'MMMM d, y' for en_US locale (e.g. September 3, 2010)
     * + 'mediumDate': equivalent to 'MMM d, y' for en_US locale (e.g. Sep 3, 2010)
     * + 'shortDate': equivalent to 'M/d/yy' for en_US locale (e.g. 9/3/10)
     * + 'mediumTime': equivalent to 'h:mm:ss a' for en_US locale (e.g. 12:05:08 PM)
     *
     * Or you can type your own format: 'M/d/yy' or 'EEEE, MMMM d, y'
     * @see https://docs.angularjs.org/api/ng/filter/date
     */
    public $dateFormat = 'shortDate';

    /**
     * @var string The separator of date format when you use your own format
     * It will be use in js to convert date to timestamp. Default is '/'
     *
     * It very useful when your separator is not '/'
     */
    public $separator = '/';

    /**
     * @inheritdoc
     */
    public function renderList($id, $ngModel)
    {
        return [
            $this->createTag('span', null, ['ng-show' => $ngModel, 'ng-bind' => $ngModel . '*1000 | date : \'' . $this->dateFormat . '\'']),
            $this->createTag('span', $this->emptyMessage, ['ng-show' => '!' . $ngModel]),
        ];
    }

    /**
     * @inheritdoc
     */
    public function renderCreate($id, $ngModel)
    {
        return $this->createFormTag('zaa-date', $id, $ngModel, ['dateformat' => $this->dateFormat, 'separator' => $this->separator]);
    }

    /**
     * @inheritdoc
     */
    public function renderUpdate($id, $ngModel)
    {
        return $this->renderCreate($id, $ngModel);
    }
}
