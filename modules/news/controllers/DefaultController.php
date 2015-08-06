<?php

namespace news\controllers;

use admin\base\actionIndex;

class DefaultController extends \luya\base\Controller
{
    public function actionIndex()
    {
        $model = \newsadmin\models\Article::className();

        return $this->render('index', [
            'model' => $model,
        ]);
    }

    public function actionDetail($id, $title)
    {
        $model = \newsadmin\models\Article::findOne($id);

        return $this->render('detail', [
            'model' => $model,
        ]);
    }
}
