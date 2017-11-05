<?php

namespace luya\admin\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "admin_user_login".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $timestamp_create
 * @property string $auth_token
 * @property string $ip
 * @property integer $is_destroyed
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
final class UserLogin extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        
        $this->on(self::EVENT_BEFORE_VALIDATE, function ($event) {
            if ($event->sender->isNewRecord) {
                $this->timestamp_create = time();
                $this->ip = Yii::$app->request->userIP;
            }
        });
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'admin_user_login';
    }
    
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'timestamp_create', 'auth_token', 'ip'], 'required'],
            [['user_id', 'timestamp_create'], 'integer'],
            [['is_destroyed'], 'boolean'],
            [['auth_token'], 'string', 'max' => 120],
            [['ip'], 'string', 'max' => 15],
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
            'timestamp_create' => 'Timestamp Create',
            'auth_token' => 'Auth Token',
            'ip' => 'Ip',
            'is_destroyed' => 'Is Destroyed',
        ];
    }
}
