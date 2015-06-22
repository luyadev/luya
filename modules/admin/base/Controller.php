<?php

namespace admin\base;

use yii\filters\AccessControl;

class Controller extends \luya\base\Controller
{
    public $layout = '@admin/views/layouts/main';

    public $useModuleViewPath = true;
    
    public $disablePermissionCheck = false;
    
    public function init()
    {
        // provided the current module more assets from all admin assets
        $this->module->assets = \yii\helpers\ArrayHelper::merge($this->module->assets, \luya\helpers\Param::get('adminAssets'));
        // call the parent init which executes the inclusion of assets (luya\base\Controller)
        parent::init();
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
                    $route = implode('/', [$action->controller->module->id, $action->controller->id, $action->id]);
                    // check the access inside luya->auth->matchRoute and return true/false.
                    return \yii::$app->auth->matchRoute((new \admin\components\User())->getIdentity()->id, $route);
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
