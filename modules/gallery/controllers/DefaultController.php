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
        $model = \galleryadmin\models\Album::find()->where(['id' => $id])->one();
        
        $this->view->registerMetaTag([
            'name' => 'description',
            'content' => $model->description
        ]);
        
        $this->pageTitle = $model->title;
        
        return $this->render('detail', [
            'model' => $model, 
        ]);
    }
}