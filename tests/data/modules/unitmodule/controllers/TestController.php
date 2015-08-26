<?php

namespace tests\data\modules\unitmodule\controllers;

class TestController extends \luya\base\Controller
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