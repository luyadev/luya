<?php

namespace luyatests\data\controllers;

use luya\web\Controller;
use yii\rest\IndexAction;

class FooController extends Controller
{
    public function actionIndex()
    {
        return 'bar';
    }

    public function actions()
    {
        return [
            'xyz' => IndexAction::class,
        ];
    }
}
