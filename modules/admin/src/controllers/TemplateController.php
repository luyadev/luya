<?php

namespace admin\controllers;

/**
 * TemplateController renders angular templates.
 * 
 * @author Basil Suter <basil@nadar.io>
 */
class TemplateController extends \admin\base\Controller
{
    public $disablePermissionCheck = true;

    public function actionDefault()
    {
        return $this->renderPartial('default');
    }
}
