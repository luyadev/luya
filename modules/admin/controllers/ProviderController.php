<?php

namespace admin\controllers;

use yii;
use yii\helpers\Json;

class ProviderController extends \admin\base\Controller
{
    public function actionTemplate()
    {
        $data = Json::decode(yii::$app->request->getRawBody(), true);

        var_dump($data);
    }
}
