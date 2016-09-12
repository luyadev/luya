<?php

namespace luya\admin\apis;

use Yii;
use luya\admin\models\UserOnline;
use luya\admin\base\RestController;

/**
 * Timestamp API, refreshes the UserOnline system of the administration area.
 *
 * @author nadar
 */
class TimestampController extends RestController
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
