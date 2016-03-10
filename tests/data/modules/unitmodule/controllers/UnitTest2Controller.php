<?php

namespace luyatests\data\modules\unitmodule\controllers;

class UnitTest2Controller extends \luya\web\Controller
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
