<?php

namespace luya\cms\admin\controllers;

use luya\admin\base\Controller;

/**
 *
 * @author Basil Suter <basil@nadar.io>
 *
 */
class ConfigController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}
