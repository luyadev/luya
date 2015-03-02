<?php
namespace account\controllers;

class DefaultController extends \account\base\Controller
{
    public function getRules()
    {
        return [
            [
                'allow' => true,
                'actions' => ['index'],
                'roles' => ['?', '@'],
            ]
        ];
    }
    
    public function actionIndex()
    {
        return 'hi';   
    }
}