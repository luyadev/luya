<?php

namespace luya\account\frontend\base;

use Yii;

class Controller extends \luya\web\Controller
{
    public function getRules()
    {
        return [
            [
                'allow' => true,
                'actions' => [], // apply to all actions by default
                'roles' => ['@'],
            ],
        ];
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'user' => Yii::$app->getModule('account')->getUserIdentity(),
                'rules' => $this->getRules(),
            ],
        ];
    }
    
    public function isGuest()
    {
        return Yii::$app->getModule('account')->getUserIdentity()->isGuest;
    }
}
