<?php

namespace admin\models;

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
    
    public static function refreshUser($userId)
    {
        $time = time();
        $model = UserOnline::find()->where(['user_id' => $userId])->one();
        // exists $this->user_id in table?
        if (!$model) {
            // insert
            $model = new UserOnline();
            $model->last_timestamp = $time;
            $model->user_id = $userId;
            $model->insert();
        } else {
            $model->last_timestamp = $time;
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
}