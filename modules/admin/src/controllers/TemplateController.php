<?php

namespace admin\controllers;

class TemplateController extends \admin\base\Controller
{
    public $disablePermissionCheck = true;

    public function actionDefault()
    {
        return $this->renderPartial('default');
    }
}
