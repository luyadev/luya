<?php

namespace luya\cms\frontend\controllers;

use Yii;

/**
 * CMS Error Handler Rendering
 *
 * @author Basil Suter <basil@nadar.io>
 */
class ErrorController extends \luya\web\Controller
{
    public function actionIndex()
    {
        return $this->renderPartial($this->module->errorViewFile, [
            'exception' => Yii::$app->errorHandler->exception
        ]);
    }
}
