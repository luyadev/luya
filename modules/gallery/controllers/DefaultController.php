<?php

namespace gallery\controllers;

class DefaultController extends \luya\base\PageController
{
    public function actionIndex()
    {
        return $this->render('index', [
            'model' => \galleryadmin\models\Album::className()
        ]);
    }
    
    public function actionDetail($id)
    {
        return $this->render('detail', [
            'model' => \galleryadmin\models\Album::find()->where(['id' => $id])->one(), 
        ]);
    }
}