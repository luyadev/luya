<?php

namespace account\controllers;

class SettingsController extends \account\base\Controller
{
    public function actionIndex()
    {
        $model = $this->module->getUserIdentity()->getIdentity();

        return $this->renderLayout('index', ['model' => $model]);
    }
}
