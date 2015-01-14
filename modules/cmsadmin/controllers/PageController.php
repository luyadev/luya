<?php
namespace cmsadmin\controllers;

class PageController extends \admin\base\Controller
{
    public function actionCreate()
    {
        return $this->renderPartial('create');
    }

    public function actionUpdate()
    {
        return $this->renderPartial('update');
    }
}
