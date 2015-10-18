<?php

namespace admin\base;

use Yii;
use yii\filters\AccessControl;

/**
 * Base controller for all Admin-Module controllers.
 *
 * @author nadar
 */
class Controller extends \luya\base\Controller
{
    /**
     * @var string Path to the admin layout
     */
    public $layout = '@admin/views/layouts/main';

    /**
     * @var boolena Use the view folder inside the module
     * @see \luya\base\Module
     */
    public $useModuleViewPath = true;

    /**
     * @var boolean When enabling `$disablePermissionCheck` all actions are not secured by access controller but
     * are do require an authtenticated user (logged in user).
     */
    public $disablePermissionCheck = false;

    /**
     * Returns the default behavior for the AccessControl filter:
     * + Must be logged in.
     * + apply to all actions.
     * + ignore if disabledPermissionCheck is enabled.
     * + Check permission with `\admin\components\Auth::matchRoute()`.
     * + By default not logged in users 
     *
     * @return array Rule-Definitions
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
