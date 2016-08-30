<?php

namespace luya\admin\models;

class UserOnline extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'admin_user_online';
    }

    public function rules()
    {
        return [
            [['user_id'], 'required'],
        ];
    }

    public static function refreshUser($userId, $route)
    {
        $time = time();
        $model = self::find()->where(['user_id' => $userId])->one();
        // exists $this->user_id in table?
        if (!$model) {
            // insert
            $model = new self();
            $model->last_timestamp = $time;
            $model->user_id = $userId;
            $model->invoken_route = $route;
            $model->insert();
        } else {
            $model->last_timestamp = $time;
            $model->invoken_route = $route;
            $model->update();
        }
    }

    public static function removeUser($userId)
    {
        $model = self::find()->where(['user_id' => $userId])->one();
        if ($model) {
            $model->delete();
        }
    }

    /**
     * @param int $maxIdleTime Default value in seconds is a half hour (30 * 60) = 1800
     */
    public static function clearList($maxIdleTime = 1800)
    {
        $time = time();
        $items = self::find()->where(['<=', 'last_timestamp', $time - $maxIdleTime])->all();
        foreach ($items as $model) {
            $model->delete();
        }
    }

    public static function getList()
    {
        $time = time();
        $return = [];
        foreach (self::find()->asArray()->all() as $item) {
            $user = User::findOne($item['user_id']);
            if ($user) {
                $inactiveSince = $time - $item['last_timestamp'];
                $return[] = [
                    'firstname' => $user->firstname,
                    'lastname' => $user->lastname,
                    'email' => $user->email,
                    'last_timestamp' => $item['last_timestamp'],
                    'is_active' => ($inactiveSince >= 120) ? false : true,
                    'inactive_since' => round(($inactiveSince / 60)).' min',
                ];
            }
        }

        return $return;
    }

    public static function getCount()
    {
        static::clearList();

        return count(self::find()->asArray()->all());
    }
}
