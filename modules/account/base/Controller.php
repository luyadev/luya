<?php

namespace account\base;

class Controller extends \luya\base\PageController
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
                'user' => $this->module->getUserIdentity(),
                'rules' => $this->getRules(),
            ],
        ];
    }
}
