<?php
namespace admin\controllers;

class DefaultController extends \admin\base\Controller
{
    public function actionIndex()
    {
        return $this->render("index");
    }

    public function actionTest()
    {
        return 'hi';
    }

    public function actionDashboard()
    {
        return $this->renderPartial("dashboard.php");
    }

    public function actionLogout()
    {
        $this->adminUser->logout();

        return $this->redirect(\Yii::$app->urlManager->createUrl(['admin']));
    }
}
