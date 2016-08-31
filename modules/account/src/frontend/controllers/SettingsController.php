<?php

namespace luya\account\frontend\controllers;

use luya\account\frontend\base\Controller;

class SettingsController extends Controller
{
    public function actionIndex()
    {
        $model = $this->module->getUserIdentity()->getIdentity();

        return $this->renderLayout('index', ['model' => $model]);
    }
}
