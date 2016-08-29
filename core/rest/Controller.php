<?php

namespace luya\rest;

use Yii;
use luya\traits\RestBehaviorsTrait;
use yii\rest\Controller as BaseController;
use yii\db\ActiveRecordInterface;

/**
 * Basic Rest Controller class
 *
 * ```php
 * class TestController extends \luya\rest\Controller
 * {
 *     public function actionFooBar()
 *     {
 *         return ['foo', 'bar'];
 *     }
 * }
 * ```
 * 
 * @author Basil Suter <basil@nadar.io>
 */
class Controller extends BaseController
{
    use RestBehaviorsTrait;
    
    /**
     * Helper method to correctly send model erros and add correct response headers.
     * 
     * @param ActiveRecordInterface $model
     * @throws ServerErrorHttpException
     * @return array
     */
    public function sendModelError(ActiveRecordInterface $model)
    {
        if (!$model->hasErrors()) {
            throw new ServerErrorHttpException('Object error for unknown reason.');
        }

        Yii::$app->response->setStatusCode(422, 'Data Validation Failed.');
        $result = [];
        foreach ($model->getFirstErrors() as $name => $message) {
            $result[] = [
                'field' => $name,
                'message' => $message,
            ];
        }

        return $result;
    }
}
