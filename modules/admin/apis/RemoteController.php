<?php

namespace admin\apis;

use Yii;
use Exception;
use Luya\Module;
use admin\models\UserOnline;

class RemoteController extends \luya\rest\Controller
{
    public function userAuthClass()
    {
        return false;
    }
    
    public function actionIndex($token)
    {
        if (!Yii::$app->remoteToken || sha1(Yii::$app->remoteToken) !== $token) {
            throw new Exception("Wrong token");
            exit;
        }
        
        return [
            'yii_version' => Yii::getVersion(),
            'luya_version' => Module::VERSION,
            'app_title' => Yii::$app->siteTitle,
            'app_debug' => (int) YII_DEBUG,
            'app_env' => YII_ENV,
            'app_transfer_exceptions' => (int) Yii::$app->errorHandler->transferException,
            'admin_online_count' => UserOnline::getCount(),
        ];
    }
}