<?php

namespace account\controllers;

use Yii;
use account\models\User;

class RegisterController extends \account\base\Controller
{
    public function getRules()
    {
        return [
            [
                'allow' => true,
                'actions' => ['index'],
                'roles' => ['?'],
            ],
        ];
    }

    public function actionIndex()
    {
        $model = new User();
        $model->scenario = 'register';
        if (isset($_POST['Register'])) {
            $model->attributes = $_POST['Register'];
            if ($model->validate()) {
                $model->encodePassword();
                $save = $model->save();
                if ($save) {
                    Yii::$app->mail->compose('Registrierung', 'Sie haben sich erfolgreich registriert.<br />E-Mail: '.$model->email.'<br />Passwort: '.$model->plainPassword.'<br /><br />Sie können Sich nun einloggen.')->address($model->email)->send();
                }
            }
        }

        return $this->render('index', [
            'model' => $model, 
            'errors' => $model->getErrors(), 
            'save' => (isset($save)) ? $save : false,
        ]);
    }
}
