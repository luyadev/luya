<?php

namespace luya\admin\controllers;

use Yii;
use luya\admin\base\Controller;

class AccountController extends Controller
{
    public $disablePermissionCheck = true;
    
    public function actionDashboard()
    {
        return $this->render('dashboard', [
            'user' => Yii::$app->adminuser->identity,
        ]);
    }
}
