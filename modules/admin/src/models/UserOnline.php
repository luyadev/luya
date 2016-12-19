<?php

namespace luya\admin\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "admin_user_online".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $last_timestamp
 * @property string $invoken_route
 */
final class UserOnline extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'admin_user_online';
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'last_timestamp', 'invoken_route'], 'required'],
            [['user_id', 'last_timestamp'], 'integer'],
            [['invoken_route'], 'string', 'max' => 120],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'last_timestamp' => 'Last Timestamp',
            'invoken_route' => 'Invoken Route',
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
     * @param integer $maxIdleTime Default value in seconds is a half hour (30 * 60) = 1800
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
