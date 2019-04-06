<?php

namespace luyatests\data\modules\unitmodule\controllers;

class DefaultController extends \luya\web\Controller
{
    public function actionIndex()
    {
        $this->view->registerMetaTag(['name' => 'keywords', 'content' => 'luya, yii, php']);

        return $this->renderLayout('index', ['foo' => 'bar']);
    }
}
