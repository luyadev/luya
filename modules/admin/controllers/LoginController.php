<?php

namespace admin\controllers;

use Yii;
use luya\helpers\Url;

class LoginController extends \admin\base\Controller
{
    public $layout = '@admin/views/layouts/nosession';

    public $skipModuleAssets = ['*'];

    public $assets = ["\admin\assets\Login"];

    public function getRules()
    {
        return [
            [
                'allow' => true,
                'actions' => ['index', 'async', 'asyncToken', 'async-token'],
                'roles' => ['?', '@'],
            ],
        ];
    }
    
    public function actionAsyncToken()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        $model = new \admin\models\LoginForm();
        // see if values are sent via post
        if (Yii::$app->request->post('secure_token', false)) {
            
            $user = $model->validateSecureToken(Yii::$app->request->post('secure_token'), Yii::$app->session->get('secureId'));
            
            if ($user) {
                if (Yii::$app->adminuser->login($user)) {
                    Yii::$app->session->remove('secureId');
                    return ['refresh' => true, 'message' => 'top!'];
                } else {
                    // misc error while login ?!
                }
            } else {
                return ['errors' => 'Der eingegeben Sicherheitscode ist falsch.', 'refresh' => false];
            }
        }
        
        return ['errors' => 'Ein Globaler-Fehler ist enstanden. Bitte kontaktieren Sie Ihren Seitenbetreiber.', 'refresh' => false];
    }

    public function actionAsync()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        // get the login form model
        $model = new \admin\models\LoginForm();
        Yii::$app->session->remove('secureId');
        // see if values are sent via post
        if (Yii::$app->request->post('login')) {
            $model->attributes = Yii::$app->request->post('login');
            if (($userObject = $model->login()) !== false) {
                
                if ($this->module->secureLogin) {
                    if($model->sendSecureLogin()) {
                        Yii::$app->session->set('secureId', $model->getUser()->id);
                        return ['refresh' => false, 'errors' => false, 'enterSecureToken' => true];
                    } else {
                        // misc error while secure token sent ?!
                    }
                } else {
                    if (Yii::$app->adminuser->login($userObject)) {
                        return ['refresh' => true, 'errors' => false, 'enterSecureToken' => false];
                    } else {
                        // misc error while login ?!
                    }
                }
            }
        }
        
        return ['refresh' => false, 'errors' => $model->getErrors(), 'enterSecureToken' => false];
    }
    
    public function actionIndex()
    {
        $url = Url::base(true) . '/admin';

        // redirect logged in users
        if (!Yii::$app->adminuser->isGuest) {
            return $this->redirect($url);
        }

        // get the login form model
        $model = new \admin\models\LoginForm();
        // see if values are sent via post
        if (Yii::$app->request->post('login')) {
            $model->attributes = Yii::$app->request->post('login');
            if (($userObject = $model->login()) !== false) {
                if (Yii::$app->adminuser->login($userObject)) {
                    return $this->redirect($url);
                }
            }
        }

        $this->view->registerJs("$('#email').focus();");
        $this->view->registerJs("observeLogin('#loginForm', '".Url::toAjax('admin/login/async')."', '".Url::toAjax('admin/login/async-token')."');");

        return $this->render('index', ['model' => $model]);
    }
}
