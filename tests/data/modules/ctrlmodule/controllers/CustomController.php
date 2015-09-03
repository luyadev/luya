<?php

namespace tests\data\modules\ctrlmodule\controllers;

class CustomController extends \luya\base\Controller
{
    public function actionBar()
    {
        return 'ctrlmodule/custom/bar';
    }
}