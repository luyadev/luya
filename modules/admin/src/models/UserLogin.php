<?php

namespace luya\admin\models;

use Yii;

class UserLogin extends \yii\db\ActiveRecord
{
    public function init()
    {
        parent::init();
        $this->on(self::EVENT_BEFORE_INSERT, [$this, 'eventBeforeInsert']);
    }

    public static function tableName()
    {
        return 'admin_user_login';
    }

    public function rules()
    {
        return [
            [['user_id', 'auth_token'], 'required'],
        ];
    }

    public function eventBeforeInsert()
    {
        $this->timestamp_create = time();
        $this->ip = Yii::$app->request->userIP;
    }
}
