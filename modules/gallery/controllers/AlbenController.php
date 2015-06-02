<?php

namespace gallery\controllers;

class AlbenController extends \luya\base\PageController
{
    public function actionIndex($catId)
    {
        return $this->render('index', [
            'albenData' => \galleryadmin\models\Album::find()->where(['cat_id' => $catId])->all(),
        ]);
    }
}