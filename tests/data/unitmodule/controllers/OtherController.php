<?php

namespace tests\data\unitmodule\controllers;

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