<?php

namespace luya\crawler\frontend\controllers;

use Yii;
use crawleradmin\models\Index;
use yii\helpers\Html;

class DefaultController extends \luya\web\Controller
{
    public function actionIndex($query = null)
    {
        return $this->render('index', [
            'query' => Html::encode($query),
            'results' => Index::searchByQuery($query, Yii::$app->composition->getKey('langShortCode')),
        ]);
    }
}
