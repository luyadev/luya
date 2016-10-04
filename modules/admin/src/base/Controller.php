<?php

namespace luya\admin\base;

use Yii;
use yii\filters\AccessControl;
use luya\admin\models\UserOnline;

/**
 * Base controller for all Admin-Module controllers.
 *
 * @author nadar
 */
class Controller extends \luya\web\Controller
{
    /**
     * @var string Path to the admin layout
     */
    public $layout = '@admin/views/layouts/main';

    /**
     * @var bool When enabling `$disablePermissionCheck` all actions are not secured by access controller but
     *           are do require an authtenticated user (logged in user).
     */
    public $disablePermissionCheck = false;

    /**
     * Returns the default behavior for the AccessControl filter:
     * + Must be logged in.
     * + apply to all actions.
     * + ignore if disabledPermissionCheck is enabled.
     * + Check permission with `\admin\components\Auth::matchRoute()`.
     * + By default not logged in users.
     *
     * @return array Rule-Definitions
     *
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
                    
                    UserOnline::refreshUser(Yii::$app->adminuser->getId(), $route);
                    
                    // check the access inside auth->matchRoute and return true/false.
                    return Yii::$app->auth->matchRoute(Yii::$app->adminuser->getId(), $route);
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
        return [
            'access' => [
                'class' => AccessControl::className(),
                'user' => Yii::$app->adminuser,
                'rules' => $this->getRules(),
            ],
        ];
    }
}
