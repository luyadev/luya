<?php

namespace tests\data\modules\unitmodule\controllers;

class UnitTestController extends \luya\base\Controller
{
    public function actionIndex()
    {
        return [
            'id' => $this->id,
            'module' => $this->module->id,
            'viewPath' => $this->getViewPath(),
            'moduleLayoutViewPath' => $this->getModuleLayoutViewPath(),
            'assets' => $this->assets,
        ];
    }
}