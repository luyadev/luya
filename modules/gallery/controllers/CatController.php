<?php

namespace gallery\controllers;

class CatController extends \luya\base\Controller
{
    public function actionIndex()
    {
        return $this->render('index', [
            'catData' => \galleryadmin\models\Cat::find()->all(),
        ]);
    }
}
