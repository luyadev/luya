<?php

namespace luyatests\data\controllers;

use luya\web\Controller;

class FooController extends Controller
{
    public function actionIndex()
    {
        return 'bar';
    }
}
