<?php

namespace moduletest\controllers;

class DefaultController extends \luya\base\Controller
{
    public function actionIndex()
    {
        $this->view->registerMetaTag(['name' => 'keywords', 'content' => 'luya, yii, php']);
        
        return $this->renderLayout('index', ['foo' => 'bar']);
    }
}