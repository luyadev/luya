<?php

namespace admin\base;

use yii\filters\AccessControl;

class Controller extends \luya\base\Controller
{
    public $layout = '@admin/views/layouts/main';

    public $useModuleViewPath = true;

    public $adminUser = null;

    public $disablePermissionCheck = false;
    
    public function init()
    {
        parent::init();
        // @TODO: delete
        $this->adminUser = \yii::$app->getModule('admin')->getAdminUser();

        // get asset bundles which are defined in the module and register them into the view
        foreach (\luya\helpers\Param::get('adminAssets') as $class) {
            // autoload $class and register with current view
            $class::register($this->view);
        }
    }

    public function getRules()
    {
        return [
            [
                'allow' => true,
                'actions' => [], // apply to all actions by default
                'roles' => ['@'],
                'matchCallback' => function ($rule, $action) {
                    // see if a controller property has been defined to disabled the permission checks
                    // @todo but we should check for logged in admin?
                    if ($action->controller->disablePermissionCheck) {
                        return true;
                    }
                    // get the route based on the current $action object
                    $route = implode("/", [$action->controller->module->id, $action->controller->id, $action->id]);
                    // check the access inside luya->auth->matchRoute and return true/false.
                    return \yii::$app->luya->auth->matchRoute((new \admin\components\User())->getIdentity()->id, $route);
                },
            ],
        ];
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'user' => '\admin\components\User',
                'rules' => $this->getRules(),
            ],
        ];
    }
}
