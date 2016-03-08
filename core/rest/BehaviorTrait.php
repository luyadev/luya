<?php

namespace luya\rest;

trait BehaviorTrait
{
    private function getUserAuthClass()
    {
        $class = $this->userAuthClass();
        if (!is_object($class)) {
            if (is_string($class)) {
                $class = new $class();
            }
        }

        return $class;
    }

    public function behaviors()
    {
        // get the parent behaviors to overwrite
        $behaviors = parent::behaviors();

        if (!$this->getUserAuthClass()) {
            unset($behaviors['authenticator']);
            unset($behaviors['rateLimiter']);
        } else {
            // change to admin user auth class
            $behaviors['authenticator'] = [
                'class' => \yii\filters\auth\CompositeAuth::className(),
                'user' => $this->getUserAuthClass(),
                'authMethods' => [
                    \yii\filters\auth\QueryParamAuth::className(),
                    \yii\filters\auth\HttpBearerAuth::className(),
                ],
            ];

            // change to admin rate limiter
            $behaviors['rateLimiter'] = [
                'class' => \yii\filters\RateLimiter::className(),
                'user' => $this->getUserAuthClass(),
            ];
        }

        $behaviors['contentNegotiator'] = [
            'class' => \yii\filters\ContentNegotiator::className(),
            'formats' => [
                'application/json' => \yii\web\Response::FORMAT_JSON,
                'application/xml' => \yii\web\Response::FORMAT_XML,
            ],
        ];

        return $behaviors;
    }
}
