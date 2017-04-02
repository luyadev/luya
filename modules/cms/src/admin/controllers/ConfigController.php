<?php

namespace luya\cms\admin\controllers;

use luya\admin\base\Controller;

class ConfigController extends Controller
{
    public function actionIndex()
    {
        return $this->renderPartial('index');
    }
}
