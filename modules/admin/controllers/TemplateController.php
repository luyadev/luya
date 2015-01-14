<?php
namespace admin\controllers;

class TemplateController extends \admin\base\Controller
{
    public function actionDefault()
    {
        return $this->renderPartial("default");
    }
}
