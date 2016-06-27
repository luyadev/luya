<?php

namespace admin\ngrest\plugins;

/**
 * Date and Time input field
 * 
 * When dealing with empty datetime values you can configure `emptyMessage` in order to change the display default text in
 * the list view.
 * 
 * Example empty Date configuration
 * 
 * ```
 * ['timestamp', ['Datetime', 'emptyMessage' => 'No Date']],
 * ```
 * 
 * @author nadar
 */
class Datetime extends \admin\ngrest\base\Plugin
{
    /**
     * @var string This text will be displayed in the list overview when no date has been slected
     * or date is null/empty.
     */
    public $emptyMessage = '-';
    
    /**
     * 
     * {@inheritDoc}
     * @see \admin\ngrest\base\Plugin::renderList()
     */
    public function renderList($id, $ngModel)
    {
        return [
            $this->createTag('span', null, ['ng-show' => $ngModel, 'ng-bind' => $ngModel.'*1000 | date : \'dd.MM.yyyy @ HH:mm\'']),
            $this->createTag('span', $this->emptyMessage, ['ng-show' => '!'.$ngModel]),
        ];
    }

    /**
     * 
     * {@inheritDoc}
     * @see \admin\ngrest\base\Plugin::renderCreate()
     */
    public function renderCreate($id, $ngModel)
    {
        return $this->createFormTag('zaa-datetime', $id, $ngModel);
    }

    /**
     * 
     * {@inheritDoc}
     * @see \admin\ngrest\base\Plugin::renderUpdate()
     */
    public function renderUpdate($id, $ngModel)
    {
        return $this->renderCreate($id, $ngModel);
    }
}
