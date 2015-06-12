<?php

namespace admin\controllers;

use Yii;

class DefaultController extends \admin\base\Controller
{
    public $disablePermissionCheck = true;

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionDashboard()
    {
        return $this->renderPartial('dashboard.php');
    }

    public function actionLogout()
    {
        $this->adminUser->logout();
        $url = \luya\helpers\Url::to('admin/login/index');
        return Yii::$app->getResponse()->redirect($url);
    }
}
