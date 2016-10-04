<?php

namespace luya\admin\controllers;

use luya\admin\base\Controller;

/**
 * StorageController renders the Filemanager Template.
 *
 * @author Basil Suter <basil@nadar.io>
 */
class StorageController extends Controller
{
    public function actionIndex()
    {
        return $this->renderPartial('index');
    }
}
