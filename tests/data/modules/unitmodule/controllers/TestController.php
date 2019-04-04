<?php

namespace luyatests\data\modules\unitmodule\controllers;

class TestController extends \luya\web\Controller
{
    public function actionIndex()
    {
        return 'foo';
    }

    public function actionBar()
    {
        return 'bar';
    }
}
