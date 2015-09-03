<?php

namespace tests\data\modules\ctrlmodule\controllers;

class DefaultController extends \luya\base\Controller
{
    public function actionIndex()
    {
        return 'ctrlmodule/default/index';
    }
}