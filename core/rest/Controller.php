<?php

namespace luya\rest;

use Yii;

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
class Controller extends \yii\web\Controller
{
    use \luya\rest\BehaviorTrait;

    public $serializer = 'yii\rest\Serializer';

    public $enableCsrfValidation = false;

    public function afterAction($action, $result)
    {
        $result = parent::afterAction($action, $result);

        return $this->serializeData($result);
    }

    protected function serializeData($data)
    {
        return Yii::createObject($this->serializer)->serialize($data);
    }

    public function sendModelError($model)
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
