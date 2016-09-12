<?php

namespace luya\admin\apis;

use Yii;
use Exception;
use luya\admin\models\UserOnline;
use luya\rest\Controller;

/**
 * Remove API, allows to collect system data with a valid $token.
 *
 * @author Basil Suter <basil@nadar.io>
 */
class RemoteController extends Controller
{
    public function userAuthClass()
    {
        return false;
    }

    public function actionIndex($token)
    {
        if (empty(Yii::$app->remoteToken) || sha1(Yii::$app->remoteToken) !== $token) {
            throw new Exception('Wrong token');
            exit;
        }

        return [
            'yii_version' => Yii::getVersion(),
            'luya_version' => \luya\Boot::VERSION,
            'app_title' => Yii::$app->siteTitle,
            'app_debug' => (int) YII_DEBUG,
            'app_env' => YII_ENV,
            'app_transfer_exceptions' => (int) Yii::$app->errorHandler->transferException,
            'admin_online_count' => UserOnline::getCount(),
            'app_elapsed_time' => Yii::getLogger()->getElapsedTime(),
        ];
    }
}
