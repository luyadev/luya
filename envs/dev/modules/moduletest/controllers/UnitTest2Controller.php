<?php

namespace moduletest\controllers;

class UnitTest2Controller extends \luya\base\Controller
{
    public $useModuleViewPath = true;
    
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