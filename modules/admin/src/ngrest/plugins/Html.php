<?php

namespace luya\admin\ngrest\plugins;

use luya\Exception;
use luya\admin\ngrest\base\Plugin;

/**
 * Renders HTML in List View. Update/Create are disabled.
 *
 * This will bind the Api Response as trusted html and allow the html injection.
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
        throw new Exception("HTML Plugin does not support create form.");
    }

    /**
     * @inheritdoc
     */
    public function renderUpdate($id, $ngModel)
    {
        throw new Exception("HTML Plugin does not support update form.");
    }
}
