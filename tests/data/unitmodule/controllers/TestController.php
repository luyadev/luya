<?php

namespace tests\data\unitmodule\controllers;

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