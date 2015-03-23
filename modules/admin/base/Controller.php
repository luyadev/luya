<?php

namespace admin\base;

use yii\filters\AccessControl;

class Controller extends \luya\base\Controller
{
    public $layout = '@admin/views/layouts/main';

    public $useModuleViewPath = true;

    public $adminUser = null;

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

    public function getUserId()
    {
        return new \admin\components\User();   
    }
    
    public function getRules()
    {
        return [
            [
                'allow' => true,
                'actions' => [], // apply to all actions by default
                'roles' => ['@'],
                'matchCallback' => function($rule, $action) {
                    /*
                    $actionName = $action->id;
                    $controllerName = $action->controller->id;
                    $moduleName = $action->controller->module->id;
                    */
                    return true;
                    //var_dump($action->controller->adminUser);
                    //var_dump($actionName, $controllerName, $moduleName);
                    
                    // \yii::$app->luya->auth->match($action->controller->getUserId(), $moduleName, $controllerName, $actionName);
                }
            ]
        ];
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'user' => '\admin\components\User',
                'rules' => $this->getRules(),
            ]
        ];
    }
}
