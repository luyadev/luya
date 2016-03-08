<?php

namespace admin\apis;

use Yii;
use admin\models\UserOnline;

/**
 * @author nadar
 */
class TimestampController extends \admin\base\RestController
{
    public function actionIndex()
    {
        // clear user online list
        UserOnline::clearList();
        // return users, verify force reload.
        return [
            'useronline' => UserOnline::getList(),
            'forceReload' => Yii::$app->adminuser->identity->force_reload,
        ];
    }
}
