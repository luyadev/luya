<?php
namespace admin\base;

use yii\filters\RateLimiter;
use yii\filters\ContentNegotiator;
use yii\filters\auth\QueryParamAuth;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\web\Response;

class RestController extends \yii\web\Controller
{
    public $serializer = 'yii\rest\Serializer';

    public $enableCsrfValidation = false;

    public function behaviors()
    {
        return [
            'contentNegotiator' => [
                'class' => ContentNegotiator::className(),
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                    'application/xml' => Response::FORMAT_XML,
                ],
            ],
            'authenticator' => [
                'class' => CompositeAuth::className(),
                'user' => new \admin\components\User(),
                'authMethods' => [
                    QueryParamAuth::className(),
                    HttpBearerAuth::className(),
                ],
            ],
            'rateLimiter' => [
                'class' => RateLimiter::className(),
                'user' => new \admin\components\User(),
            ],
        ];
    }

    public function afterAction($action, $result)
    {
        $result = parent::afterAction($action, $result);

        return $this->serializeData($result);
    }

    protected function serializeData($data)
    {
        return \Yii::createObject($this->serializer)->serialize($data);
    }
}
