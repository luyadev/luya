<?php

namespace luya\rest;

use Yii;
use yii\base\Model;
use yii\web\ServerErrorHttpException;
use luya\traits\RestBehaviorsTrait;

/**
 * Basic Rest Controller.
 *
 * The below test controller can be access for everyone and is public.
 *
 * ```php
 * class TestPublicController extends \luya\rest\Controller
 * {
 *     // this method is public and visible for everyone.
 *     public function actionIndex()
 *     {
 *         return ['foo', 'bar'];
 *     }
 * }
 * ```
 *
 * In order to provide secure rest controllers you have to implement the {{luya\rest\UserBehaviorInterface}}.
 *
 * ```php
 * class TestSecureController extends \luya\rest\Controller implements \luya\rest\UserBehaviorInterface
 * {
 *     public function userAuthClass()
 *     {
 *         return \app\models\User::class;
 *     }
 *
 *     // this method is protected by the `app\models\User` model.
 *     public function actionIndex()
 *     {
 *         return ['foo', 'bar'];
 *     }
 * }
 * ```
 *
 * @author Basil Suter <basil@nadar.io>
 */
class Controller extends \yii\rest\Controller
{
    use RestBehaviorsTrait;
    
    /**
     * Helper method to correctly send model erros and add correct response headers.
     *
     * @param \yii\base\Model $model The model to find the first error.
     * @throws \yii\web\ServerErrorHttpException
     * @return array If the model has errors ServerErrorHttpException will be thrown
     */
    public function sendModelError(Model $model)
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
