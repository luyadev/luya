<?php
namespace admin\controllers;

use yii;

class LoginController extends \admin\base\Controller
{
    public $layout = '@admin/views/layouts/nosession';

    public function getRules()
    {
        return [
            [
                'allow' => true,
                'actions' => ['index'],
                'roles' => ['?', '@'],
            ],
        ];
    }

    public function actionIndex()
    {
        // redirect logged in users
        if (!$this->adminUser->isGuest) {
            return $this->redirect(Yii::$app->urlManager->createUrl(['admin']));
        }

        // get the login form model
        $model = new \admin\models\LoginForm();
        // see if values are sent via post
        if (isset($_POST['login'])) {
            $model->attributes = $_POST['login'];
            if (($userObject = $model->login()) !== false) {
                if ($this->adminUser->login($userObject)) {
                    return $this->redirect(Yii::$app->urlManager->createUrl(['admin']));
                }
            }
        }

        return $this->render("index", ['model' => $model]);
    }
}
