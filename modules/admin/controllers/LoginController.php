<?php

namespace admin\controllers;

use yii;
use \luya\helpers\Url;

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
            $url = \luya\helpers\Url::to('admin');
            return Yii::$app->getResponse()->redirect($url);
            //return $this->redirect(Yii::$app->urlManager->createUrl(['admin']));
        }

        // get the login form model
        $model = new \admin\models\LoginForm();
        // see if values are sent via post
        if (isset($_POST['login'])) {
            $model->attributes = $_POST['login'];
            if (($userObject = $model->login()) !== false) {
                if ($this->adminUser->login($userObject)) {
                    $url = \luya\helpers\Url::to('admin');
                    return Yii::$app->getResponse()->redirect($url);
                }
            }
        }

        return $this->render('index', ['model' => $model]);
    }
}
