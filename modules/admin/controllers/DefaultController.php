<?php
namespace admin\controllers;

class DefaultController extends \admin\base\Controller
{
    public function actionIndex()
    {
        return $this->render("index");
    }

    public function actionLogout()
    {
        $this->adminUser->logout();

        return $this->redirect(\Yii::$app->urlManager->createUrl(['admin']));
    }
}
