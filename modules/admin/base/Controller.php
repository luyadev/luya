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
        foreach (\luya\Luya::getParams('adminAssets') as $class) {
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
