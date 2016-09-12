<?php

namespace luya\admin\controllers;

use luya\admin\base\Controller;

/**
 * TemplateController renders angular templates.
 *
 * @author Basil Suter <basil@nadar.io>
 */
class TemplateController extends Controller
{
    public $disablePermissionCheck = true;

    public function actionDefault()
    {
        return $this->renderPartial('default');
    }
}
