<?php

namespace luya\admin\controllers;

use Yii;
use yii\web\Response;
use luya\helpers\Url;
use luya\admin\models\LoginForm;
use luya\admin\Module;
use luya\admin\base\Controller;
use luya\admin\models\UserOnline;

/**
 * Login Controller contains async actions, async token send action and login mechanism.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class LoginController extends Controller
{
    public $layout = '@admin/views/layouts/nosession';

    /**
     * {@inheritDoc}
     * @see \luya\admin\base\Controller::getRules()
     */
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

    /**
     * Show Login Form.
     *
     * @return \yii\web\Response|string
     */
    public function actionIndex()
    {
        // redirect logged in users
        if (!Yii::$app->adminuser->isGuest) {
            return $this->redirect(['/admin/default/index']);
        }
       
        $this->registerAsset('\luya\admin\assets\Login');
        
        $this->view->registerJs("
        	$('#email').focus(); 
        	checkInputLabels();
        	observeLogin('#loginForm', '".Url::toAjax('admin/login/async')."', '".Url::toAjax('admin/login/async-token')."');
        ");
    
        UserOnline::clearList();
        
        return $this->render('index');
    }
    
    /**
     * Async Secure Token Login.
     *
     * @return array
     */
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
                    return ['refresh' => true, 'message' => null];
                }
            } else {
                return ['errors' => Module::t('login_async_token_error'), 'refresh' => false];
            }
        }

        return ['errors' => Module::t('login_async_token_globalerror'), 'refresh' => false];
    }

    /**
     * Async Login Form.
     *
     * @return array
     */
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
                        return ['refresh' => false, 'errors' => ['Unable to send and store secure token.'], 'enterSecureToken' => false];
                    }
                } else {
                    if (Yii::$app->adminuser->login($userObject)) {
                        return ['refresh' => true, 'errors' => false, 'enterSecureToken' => false];
                    }
                }
            }
        }

        return ['refresh' => false, 'errors' => $model->getErrors(), 'enterSecureToken' => false];
    }
}
