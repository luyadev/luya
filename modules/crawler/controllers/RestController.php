<?php

namespace crawler\controllers;

use Yii;
use crawleradmin\models\Index;
use yii\helpers\Html;

class RestController extends \luya\rest\Controller
{
    public function userAuthClass()
    {
        return false;
    }

    public function actionIndex($query = null)
    {
        return [
            'query' => Html::encode($query),
            'results' => Index::searchByQuery($query, Yii::$app->composition->getKey('langShortCode')),
        ];
    }
}
