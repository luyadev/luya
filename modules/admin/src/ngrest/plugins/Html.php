<?php

namespace luya\admin\ngrest\plugins;

use luya\admin\ngrest\base\Plugin;

/**
 * Renders HTML in List View.
 *
 * This will bind the Api Response as trusted html and allow the html injection.
 *
 * The frontend output will not encoded, so make sure no user generated contnet is provided by the html plugin.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class Html extends Plugin
{
    /**
     * @var boolean Whether the text should parse newlines to br or not, its enabled by default.
     */
    public $nl2br = true;
    
    /**
     * @inheritdoc
     */
    public function renderList($id, $ngModel)
    {
        return $this->createTag('div', null, ['ng-bind-html' => $ngModel . ' | trustAsUnsafe']);
    }

    /**
     * @inheritdoc
     */
    public function renderCreate($id, $ngModel)
    {
        return $this->createFormTag('zaa-textarea', $id, $ngModel);
    }

    /**
     * @inheritdoc
     */
    public function renderUpdate($id, $ngModel)
    {
        return $this->renderCreate($id, $ngModel);
    }
    
    /**
     * @inheritdoc
     */
    public function onAfterFind($event)
    {
        if ($this->nl2br) {
            $event->sender->setAttribute($this->name, nl2br($event->sender->getAttribute($this->name)));
        }
    }
}
