<?php
namespace account\controllers;

class RegisterController extends \account\base\Controller
{
    public function getRules()
    {
        return [
            [
                'allow' => true,
                'actions' => ['index'],
                'roles' => ['?'],
            ]
        ];
    }
    
    public function actionIndex()
    {
        $model = new \account\models\User();
        $model->scenario = 'register';
        if (isset($_POST['Register'])) {
            $model->attributes = $_POST['Register'];
            if ($model->validate()) {
                $model->encodePassword();
                $save = $model->save();
            }
        }
        
        return $this->render('index', ['model' => $model, 'errors' => $model->getErrors(), 'save' => (isset($save)) ? $save : false ]);
    }
}