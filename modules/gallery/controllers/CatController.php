<?php

namespace gallery\controllers;

class CatController extends \luya\base\PageController
{
    public function actionIndex()
    {
        return $this->render('index', [
            'catData' => \galleryadmin\models\Cat::find()->all(),
        ]);
    }
}
