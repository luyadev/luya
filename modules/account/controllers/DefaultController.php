<?php

namespace account\controllers;

use Yii;
use account\models\LoginForm;
use luya\helpers\Url;

class DefaultController extends \account\base\Controller
{
    public function getRules()
    {
        return [
            [
                'allow' => true,
                'actions' => ['index'],
                'roles' => ['?', '@'],
            ], [
                'allow' => true,
                'actions' => ['lostpass'],
                'roles' => ['?'],
            ], [
                'allow' => true,
                'actions' => ['logout'],
                'roles' => ['@'],
            ],
        ];
    }

    /**
     * @param $_GET['redirect'] should be urlencoded
     * @param $_POST['LoginForm'] data to login
     */
    public function actionIndex($ref = null)
    {
        if (!empty($ref)) {
            Yii::$app->session->set('accountRef', $ref);
        }
        
        if (!$this->module->getUserIdentity()->isGuest) {
            if (Yii::$app->session->get('accountRef')) {
                $url = Yii::$app->session->get('accountRef');
                Yii::$app->session->remove('accountRef');
            } else {
                $url = Url::toManager('account/settings/index');
            }
            $this->redirect($url);
        }

        $model = new LoginForm();
        // see if values are sent via post
        if (Yii::$app->request->post('LoginForm')) {
            $model->attributes = Yii::$app->request->post('LoginForm');
            if (($userObject = $model->login()) !== false) {
                if ($this->module->getUserIdentity()->login($userObject)) {
                    $url = Yii::$app->session->get('accountRef');
                    if (!$url) {
                        $url = Url::toManager('account/settings/index');
                    } else {
                        Yii::$app->session->remove('accountRef');
                    }

                    $this->redirect($url);
                }
            }
        }

        return $this->renderLayout('index', ['model' => $model]);
    }

    public function actionLogout()
    {
        $this->module->getUserIdentity()->logout();

        return $this->goHome();
    }

    public function actionLostpass()
    {
        return $this->renderLayout('lostpass');
    }
}
