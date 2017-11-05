<?php

namespace luya\admin\base;

use Yii;
use yii\filters\AccessControl;
use luya\admin\models\UserOnline;
use yii\filters\ContentNegotiator;
use yii\web\Response;

/**
 * Base controller for all Admin-Module controllers.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class Controller extends \luya\web\Controller
{
    /**
     * @var string Path to the admin layout
     */
    public $layout = false;

    /**
     * @var boolean When enabling `$disablePermissionCheck` all actions are not secured by access controller but still require an authtenticated user (logged in user) by session.
     */
    public $disablePermissionCheck = false;

    /**
     * @var array A list of actions which should be treated as api response, this will convert a returned array into an application/json header.
     *
     * An example controller with an api response action `actionQuery`.
     *
     * ```php
     * <?php
     *
     * namespace app\modules\mymodule\admin\controllers;
     *
     * use luya\admin\base\Controller;
     *
     * class MyTestController extends Controller
     * {
     *     public $disablePermissionCheck = true;
     *
     * 	   public $apiResponseActions = ['query'];
     *
     * 	   public function actionIndex()
     * 	   {
     * 	       return $this->render('index');
     * 	   }
     *
     * 	   public function actionQuery()
     * 	   {
     * 		   return ['foo' => time()];
     * 	   }
     * }
     * ```
     */
    public $apiResponseActions = [];
    
    /**
     * Returns the rules for the AccessControl filter behavior.
     *
     * The rules are applied as following:
     *
     * 1. Administration User must be logged in, this is by default for all actions inside the controller.
     * 2. Check the current given route against {{luya\admin\components\Auth::matchRoute()}}.
     *   2a. If {{luya\admin\base\Controller::$disabledPermissionCheck}} enabled, the match route behavior is disabled.
     *
     * @return array A list of rules.
     * @see yii\filters\AccessControl
     */
    public function getRules()
    {
        return [
            [
                'allow' => true,
                'actions' => [], // apply to all actions by default
                'roles' => ['@'],
                'matchCallback' => function ($rule, $action) {
                    // see if a controller property has been defined to disabled the permission checks
                    if ($action->controller->disablePermissionCheck) {
                        return true;
                    }
                    // get the route based on the current $action object
                    $route = implode('/', [$action->controller->module->id, $action->controller->id, $action->id]);
                    
                    UserOnline::refreshUser($this->user->id, $route);
                    
                    // check the access inside auth->matchRoute and return true/false.
                    return Yii::$app->auth->matchRoute($this->user->id, $route);
                },
            ],
        ];
    }

    /**
     * Attach the AccessControl filter behavior for the controler.
     *
     * @return array
     */
    public function behaviors()
    {
        $behaviors = [
            'access' => [
                'class' => AccessControl::className(),
                'user' => Yii::$app->adminuser,
                'rules' => $this->getRules(),
            ],
        ];
        
        if (!empty($this->apiResponseActions)) {
            $behaviors['negotiator'] = [
                'class' => ContentNegotiator::className(),
                'only' => $this->apiResponseActions,
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ];
        }
        
        return $behaviors;
    }
    
    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            Yii::$app->language = Yii::$app->adminuser->interfaceLanguage;
            return true;
        }
        
        return false;
    }
}
