<?php

namespace luya\admin\controllers;

use Yii;
use yii\web\Response;
use luya\helpers\Url;
use luya\admin\models\LoginForm;
use luya\admin\Module;
use luya\admin\base\Controller;

/**
 * Login Controller contains async actions, async token send action and login mechanism.
 *
 * @author Basil Suter <basil@nadar.io>
 */
class LoginController extends Controller
{
    public $layout = '@admin/views/layouts/nosession';

    public $skipModuleAssets = ['*'];

    public $assets = ["\luya\admin\assets\Login"];

    public function getRules()
    {
        return [
            [
                'allow' => true,
                'actions' => ['index', 'async', 'async-token'],
                'roles' => ['?', '@'],
            ],
        ];
    }

    public function actionIndex()
    {
        // redirect logged in users
        if (!Yii::$app->adminuser->isGuest) {
            return $this->redirect(['/admin/default/index']);
        }
        
        $this->view->registerJs("$(function(){ $('#email').focus(); observeLogin('#loginForm', '".Url::toAjax('admin/login/async')."', '".Url::toAjax('admin/login/async-token')."'); });", \luya\web\View::POS_END);
    
        return $this->render('index');
    }
    
    public function actionAsyncToken()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $model = new LoginForm();
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
                return ['errors' => Module::t('login_async_token_error'), 'refresh' => false];
            }
        }

        return ['errors' => Module::t('login_async_token_globalerror'), 'refresh' => false];
    }

    public function actionAsync()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        // get the login form model
        $model = new LoginForm();
        Yii::$app->session->remove('secureId');
        // see if values are sent via post
        if (Yii::$app->request->post('login')) {
            $model->attributes = Yii::$app->request->post('login');
            if (($userObject = $model->login()) !== false) {
                if ($this->module->secureLogin) {
                    if ($model->sendSecureLogin()) {
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
}
