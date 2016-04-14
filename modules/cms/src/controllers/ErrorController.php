<?php

namespace cms\controllers;

use Yii;

class ErrorController extends \luya\web\Controller
{
    public function actionIndex()
    {
        $exception = Yii::$app->errorHandler->exception;
        return $this->render($this->module->errorViewFile, ['exception' => $exception]);
    }
}
