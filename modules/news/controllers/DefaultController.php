<?php
namespace news\controllers;

use admin\base\actionIndex;

class DefaultController extends \luya\base\PageController
{
    public function actionIndex()
    {
        $model = \newsadmin\models\Article::className();

        return $this->render('index', [
            'model' => $model,
        ]);
    }
}
