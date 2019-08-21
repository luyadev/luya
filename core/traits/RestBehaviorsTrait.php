<?php

namespace luya\traits;

use Yii;
use yii\web\Response;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\QueryParamAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\ContentNegotiator;
use yii\filters\Cors;
use yii\base\Model;
use luya\rest\UserBehaviorInterface;
use luya\web\filters\JsonCruftFilter;
use luya\helpers\RestHelper;

/**
 * Rest Behaviors Trait.
 *
 * This class overrides the default behaviors method of {{yii\rest\Controller}} controllers.
 *
 * The following changes are differ to the base implementation:
 *
 * + If {{luya\rest\UserBehaviorInterface}} is **not** implemented, the `authenticator` behavior ({{yii\filters\auth\CompositeAuth}}) is removed.
 * + If {{luya\rest\UserBehaviorInterface}} **is** implemented, the `authenticator` behavior ({{yii\filters\auth\CompositeAuth}}) is enabled.
 * + If {{luya\rest\UserBehaviorInterface}} **is** implemented, the `contentNegotiator` behavior ({{yii\filters\ContentNegotiator}}) is enabled.
 * + The `rateLimiter` behavior filter is **removed** by default.
 *
 * Read the {{luya\rest\UserBehaviorInterface}} about the configuration ability to protect the controller.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
trait RestBehaviorsTrait
{
    /**
     * @var boolean Whether CORS should be enabled or not.
     */
    public $enableCors = false;
    
    /**
     * @var array An array with languages which are passed to {{yii\filters\ContentNegotiator::$languages}}. Example
     *
     * ```php
     * 'languages' => [
     *     'en',
     *     'de',
     * ],
     * ```
     * @since 1.0.7
     */
    public $languages = [];
    
    /**
     * @var boolean Whether a unparsable cruf should be added to the json response or not. When enabled you have to parse the json response first before interpreting
     * as json.
     * @since 1.0.7
     */
    public $jsonCruft = false;
    
    /**
     * Whether the rest controller is protected or not.
     *
     * @return boolean|\yii\web\User
     */
    private function getUserAuthClass()
    {
        if ($this instanceof UserBehaviorInterface) {
            $class = $this->userAuthClass();
            
            if (!$class) { // return false;
                return false;
            }
            
            if (!is_object($class)) {
                return Yii::createObject($class);
            }
    
            return $class;
        }
        
        return false;
    }
    
    /**
     * Return all Auth methods for Composite Auth.
     *
     * @return array
     * @since 1.0.21
     */
    public function getCompositeAuthMethods()
    {
        return [
            QueryParamAuth::class,
            HttpBearerAuth::class,
        ];   
    }

    /**
     * Override the default {{yii\rest\Controller::behaviors()}} method.
     * The following changes are differ to the base implementation:
     *
     * + If {{luya\rest\UserBehaviorInterface}} is **not** implemented, the `authenticator` behavior ({{yii\filters\auth\CompositeAuth}}) is removed.
     * + If {{luya\rest\UserBehaviorInterface}} **is** implemented, the `authenticator` behavior ({{yii\filters\auth\CompositeAuth}}) is enabled.
     * + If {{luya\rest\UserBehaviorInterface}} **is** implemented, the `contentNegotiator` behavior ({{yii\filters\ContentNegotiator}}) is enabled.
     * + The `rateLimiter` behavior filter is **removed** by default.
     *
     * @return array Returns an array with registered behavior filters based on the implementation type.
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        if (!$this->getUserAuthClass()) {
            unset($behaviors['authenticator']);
        } else {
            // change to admin user auth class
            $behaviors['authenticator'] = [
                'class' => CompositeAuth::class,
                'user' => $this->getUserAuthClass(),
                'authMethods' => $this->getCompositeAuthMethods(),
            ];
            
            if ($this->enableCors) {
                $behaviors['authenticator']['except'] = ['options'];
            }
        }
        
        if ($this->enableCors) {
            $behaviors['cors'] = Cors::class;
        }

        $behaviors['contentNegotiator'] = [
            'class' => ContentNegotiator::class,
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
                'application/xml' => Response::FORMAT_XML,
            ],
            'languages' => $this->languages,
        ];
        
        // by default rate limiter behavior is removed as it requires a database
        // user given from the admin module.
        if (isset($behaviors['rateLimiter'])) {
            unset($behaviors['rateLimiter']);
        }

        if ($this->jsonCruft) {
            $behaviors['cruft'] = JsonCruftFilter::class;
        }
        
        return $behaviors;
    }

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
    public function sendModelError(Model $model)
    {
        return RestHelper::sendModelError($model);
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
    public function sendArrayError(array $errors)
    {
        return RestHelper::sendArrayError($errors);
    }
}
