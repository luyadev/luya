<?php

namespace luya\helpers;

use Yii;
use yii\base\Model;
use yii\base\InvalidParamException;

/**
 * Rest API Helper.
 * 
 * @since 1.0.20
 * @author Basil Suter <basil@nadar.io>
 */
class RestHelper
{
    /**
     * Send Model errors with correct headers.
     *
     * Helper method to correctly send model errors with the correct response headers.
     *
     * Example return value:
     *
     * ```php
     * Array
     * (
     *     [0] => Array
     *         (
     *             [field] => firstname
     *             [message] => Firstname cannot be blank.
     *         )
     *     [1] => Array
     *         (
     *             [field] => email
     *             [message] => Email cannot be blank.
     *         )
     * )
     * ```
     *
     * @param \yii\base\Model $model The model to find the first error.
     * @throws \yii\base\InvalidParamException
     * @return array If the model has errors InvalidParamException will be thrown, otherwise an array with message and field key.
     */
    public static function sendModelError(Model $model)
    {
        if (!$model->hasErrors()) {
            throw new InvalidParamException('The model as thrown an uknown Error.');
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
    
    /**
     * Send Array validation error.
     *
     * Example input:
     *
     * ```php
     * return $this->sendArrayError(['firstname' => 'Firstname cannot be blank']);
     * ```
     *
     * Example return value:
     *
     * ```php
     * Array
     * (
     *     [0] => Array
     *         (
     *             [field] => firstname
     *             [message] => Firstname cannot be blank.
     *         )
     * )
     * ```
     * @param array $errors Provide an array with messages. Where key is the field and value the message.
     * @return array Returns an array with field and message keys for each item.
     * @since 1.0.3
     */
    public static function sendArrayError(array $errors)
    {
        Yii::$app->response->setStatusCode(422, 'Data Validation Failed.');
        $result = [];
        foreach ($errors as $key => $value) {
            $messages = (array) $value;
            
            foreach ($messages as $msg) {
                $result[] = ['field' => $key, 'message' => $msg];
            }
        }
        
        return $result;
    }
}