<?php

namespace luya\admin\apis;

use Yii;
use luya\Boot;
use luya\Exception;
use luya\admin\models\UserOnline;
use luya\rest\Controller;

/**
 * Remove API, allows to collect system data with a valid $token.
 *
 * The remote api can only access with the oken but is not secured by a loggged in user.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class RemoteController extends Controller
{
    /**
     * Disabled the auth methods.
     *
     * @return boolean When false the authentication is disabled.
     */
    public function userAuthClass()
    {
        return false;
    }

    /**
     * Retrieve administration informations if the token is valid.
     *
     * @param string $token The sha1 encrypted access token.
     * @return array If invalid token.
     * @throws Exception
     */
    public function actionIndex($token)
    {
        if (empty(Yii::$app->remoteToken) || sha1(Yii::$app->remoteToken) !== $token) {
            throw new Exception('The provided remote token is wrong.');
        }

        return [
            'yii_version' => Yii::getVersion(),
            'luya_version' => Boot::VERSION,
            'app_title' => Yii::$app->siteTitle,
            'app_debug' => (int) YII_DEBUG,
            'app_env' => YII_ENV,
            'app_transfer_exceptions' => (int) Yii::$app->errorHandler->transferException,
            'admin_online_count' => UserOnline::getCount(),
            'app_elapsed_time' => Yii::getLogger()->getElapsedTime(),
        ];
    }
}
