<?php

namespace luya\cms\admin\controllers;

use luya\admin\base\Controller;

/**
 * Config Controller.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class ConfigController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}
