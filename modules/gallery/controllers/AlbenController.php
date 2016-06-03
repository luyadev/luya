<?php

namespace gallery\controllers;

use galleryadmin\models\Album;
use galleryadmin\models\Cat;

class AlbenController extends \luya\web\Controller
{
    public function actionIndex($catId)
    {
        return $this->render('index', [
            'catData' => Cat::findOne($catId),
            'albenData' => Album::find()->where(['cat_id' => $catId])->orderBy(['is_highlight' => SORT_DESC, 'sort_index' => SORT_ASC])->all(),
        ]);
    }
}
