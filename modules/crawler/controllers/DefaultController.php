<?php

namespace crawler\controllers;

use crawleradmin\models\Index;
use yii\helpers\Html;

class DefaultController extends \luya\base\Controller
{   
    public function actionIndex($query = null)
    {
        return $this->render('index', [
            'query' => Html::encode($query),
            'results' => Index::searchByQuery($query),
        ]);
    }   
}