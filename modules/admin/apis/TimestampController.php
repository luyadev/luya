<?php

namespace admin\apis;

use admin\models\UserOnline;

/**
 * @author nadar
 */
class TimestampController extends \admin\base\RestController
{
    public function actionIndex()
    {
        UserOnline::clearList();

        return UserOnline::getList();
    }
}
