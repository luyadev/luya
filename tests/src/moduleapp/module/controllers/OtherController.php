<?php

namespace tests\src\moduleapp\module\controllers;

class OtherController extends \luya\base\Controller
{
    public function actionIndex()
    {
        return 'index';
    }
    
    public function actionBaz()
    {
        return 'baz';
    }
}