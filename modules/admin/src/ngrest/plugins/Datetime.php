<?php

namespace luya\admin\ngrest\plugins;

use luya\admin\ngrest\base\Plugin;

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
class Datetime extends Plugin
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
        return $this->createListTag($ngModel);
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
    
    /**
     * 
     * {@inheritDoc}
     * @see \luya\admin\ngrest\base\Plugin::onAfterListFind()
     */
    public function onAfterListFind($event)
    {
        $event->sender->setAttribute($this->name, strftime("%x", $event->sender->getAttribute($this->name))); // %x = Preferred date representation based on locale, without the time	
    }
}
