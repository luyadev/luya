<?php
namespace admin\base;

use yii\filters\RateLimiter;
use yii\filters\auth\QueryParamAuth;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBearerAuth;

/**
 * RestController Wrapper
 */
class RestActiveController extends \yii\rest\ActiveController
{
    const CREATE_SCENARIO = 'restcreate';

    const UPDATE_SCENARIO = 'restupdate';

    public $createScenario = self::CREATE_SCENARIO;

    public $updateScenario = self::UPDATE_SCENARIO;

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => CompositeAuth::className(),
            'user' => new \admin\components\User(),
            'authMethods' => [
                QueryParamAuth::className(),
                HttpBearerAuth::className(),
            ],
        ];
        $behaviors['rateLimiter'] = [
            'class' => RateLimiter::className(),
            'user' => new \admin\components\User(),
        ];

        return $behaviors;
    }
    
    public function actions()
    {
        $actions = parent::actions();
        
        // change index class
        $actions['index']['class'] = '\luya\rest\IndexAction';
        
        return $actions;
    }
}
