<?php

namespace admin\apis;

use admin\Module;
use admin\models\UserOnline;

/**
 * @author nadar
 */
class TimestampController extends \admin\base\RestController
{
    public function actionIndex()
    {
        $user = Module::getAdminUserData();
        UserOnline::clearList();
        return UserOnline::getList();
    }
}
