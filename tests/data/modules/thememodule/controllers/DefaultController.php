<?php

namespace luyatests\data\modules\thememodule\controllers;

class DefaultController extends \luya\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}
