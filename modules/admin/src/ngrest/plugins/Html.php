<?php

namespace luya\admin\ngrest\plugins;

use luya\Exception;
use luya\admin\ngrest\base\Plugin;

/**
 * Renders HTML in List View.
 *
 * This will bind the Api Response as trusted html and allow the html injection.
 *
 * The frontend output will not encoded, so make sure no user generated contnet is provided by the html plugin.
 *
 * @since 1.0.0-beta7
 * @author Basil Suter <basil@nadar.io>
 */
class Html extends Plugin
{
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
}
