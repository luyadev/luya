<?php

namespace luya\traits;

use yii\filters\auth\CompositeAuth;
use yii\filters\auth\QueryParamAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\ContentNegotiator;
use yii\web\Response;

/**
 * Rest Behavior Trait to implement basic Rest behaviors.
 * 
 * The RestBehaviorTraits is going to override the default behaviors of rest controllers based on yii2. If the implementation class
 * itself has the user behavior interface the user restrication is enabled.
 * 
 * @author Basil Suter <basil@nadar.io>
 */
trait RestBehaviorsTrait
{
    private function getUserAuthClass()
    {
        if ($this instanceof UserBehaviorInterface) {
            $class = $this->userAuthClass();
            if (!is_object($class)) {
                if (is_string($class)) {
                    $class = new $class();
                }
            }
    
            return $class;
        }
        
        return false;
    }

    public function behaviors()
    {
        // get the parent behaviors to overwrite
        $behaviors = parent::behaviors();

        if (!$this->getUserAuthClass()) {
            unset($behaviors['authenticator']);
        } else {
            // change to admin user auth class
            $behaviors['authenticator'] = [
                'class' => CompositeAuth::className(),
                'user' => $this->getUserAuthClass(),
                'authMethods' => [
                    QueryParamAuth::className(),
                    HttpBearerAuth::className(),
                ],
            ];
        }

        $behaviors['contentNegotiator'] = [
            'class' => ContentNegotiator::className(),
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
                'application/xml' => Response::FORMAT_XML,
            ],
        ];
        
        // by default rate limiter behavior is removed as its not implememented.
        if (isset($behaviors['rateLimiter'])) {
            unset($behaviors['rateLimiter']);
        }

        return $behaviors;
    }
}
