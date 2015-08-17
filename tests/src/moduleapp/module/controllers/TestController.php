<?php

namespace tests\src\moduleapp\module\controllers;

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