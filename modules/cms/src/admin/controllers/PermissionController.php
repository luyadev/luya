<?php

namespace luya\cms\admin\controllers;

use luya\admin\base\Controller;

/**
 * Controller for Angular Permissions
 *
 * @author Basil Suter <basil@nadar.io>
 */
class PermissionController extends Controller
{
    public function actionIndex()
    {
        return $this->renderPartial('index');
    }
}
