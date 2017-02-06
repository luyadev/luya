<?php

namespace luya\admin\apis;

use Yii;
use luya\admin\models\UserOnline;
use luya\admin\base\RestController;

/**
 * Timestamp API, refreshes the UserOnline system of the administration area.
 *
 * @author Basil Suter <basil@nadar.io>
 */
class TimestampController extends RestController
{
    /**
     * The timestamp action provider informations about currenct only users and if the ui needs to be refreshed.
     *
     * @return array
     */
    public function actionIndex()
    {
        // clear user online list
        UserOnline::clearList();
        
        if (!UserOnline::findOne(['user_id' => Yii::$app->adminuser->id])) {
            Yii::$app->response->statusCode = 401;
            return Yii::$app->response->send();
        }
        // return users, verify force reload.
        return [
            'useronline' => UserOnline::getList(),
            'forceReload' => Yii::$app->adminuser->identity->force_reload,
            'locked' => UserOnline::find()->select(['lock_pk', 'lock_table', 'last_timestamp', 'u.firstname', 'u.lastname', 'u.id'])->where(['!=', 'u.id', Yii::$app->adminuser->id])->joinWith('user as u')->createCommand()->queryAll(),
        ];
    }
}
