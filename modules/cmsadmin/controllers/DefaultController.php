<?php
namespace cmsadmin\controllers;

class DefaultController extends \admin\base\Controller
{
    public function actionIndex()
    {
        return $this->renderPartial('index');
    }
}
