<?php

namespace gallery\controllers;

class CatController extends \luya\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index', [
            'catData' => \galleryadmin\models\Cat::find()->all(),
        ]);
    }
}
