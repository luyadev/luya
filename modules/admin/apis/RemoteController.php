<?php

namespace admin\apis;

use Yii;
use Exception;
use Luya\Module;

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
        ];
    }
}