<?php

namespace admin\models;

use \admin\models\User;

class UserOnline extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'admin_user_online';
    }
    
    public function rules()
    {
        return [
            [['user_id'], 'required']
        ];
    }
    
    public static function refreshUser($userId, $route)
    {
        $time = time();
        $model = UserOnline::find()->where(['user_id' => $userId])->one();
        // exists $this->user_id in table?
        if (!$model) {
            // insert
            $model = new UserOnline();
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
        $model = UserOnline::find()->where(['user_id' => $userId])->one();
        if ($model) {
            $model->delete();
        }
    }
    
    public static function clearList()
    {
        $time = time();
        $items = UserOnline::find()->where('last_timestamp <= ' . ($time-(30*60)))->all();
        foreach($items as $model) {
            $model->delete();
        }
    }
    
    public static function getList()
    {
        $time = time();
        $return = [];
        foreach(self::find()->asArray()->all() as $item) {
            $user = User::findOne($item['user_id']);
            $inactiveSince = $time-$item['last_timestamp'];
            $return[] = [
                'firstname' => $user->firstname,
                'lastname' => $user->lastname,
                'email' => $user->email,
                'last_timestamp' => $item['last_timestamp'],
                'is_active' => ($inactiveSince>=120) ? false : true,
                'inactive_since' => round(($inactiveSince/60)) . ' min',
            ];
        }
        
        return $return;
    }
    
    public static function getCount()
    {
        static::clearList();
        return count(self::find()->asArray()->all());
    }
}