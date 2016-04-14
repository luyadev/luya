<?php

namespace cms\controllers;

use Yii;

class ErrorController extends \luya\web\Controller
{
    public function actionIndex()
    {
        return $this->renderPartial($this->module->errorViewFile, [
            'exception' => Yii::$app->errorHandler->exception
        ]);
    }
}
