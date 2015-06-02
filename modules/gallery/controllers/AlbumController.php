<?php

namespace gallery\controllers;

class AlbumController extends \luya\base\PageController
{
    public function actionIndex($albumId)
    {
        $model = \galleryadmin\models\Album::find()->where(['id' => $albumId])->one();
    
        $this->view->registerMetaTag([
            'name' => 'description',
            'content' => $model->description,
        ]);
    
        $this->pageTitle = $model->title;
    
        return $this->render('index', [
            'model' => $model,
        ]);
    }
}