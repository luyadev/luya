<?php

namespace luya\admin\models;

use yii\db\ActiveRecord;
use luya\admin\Module;
use yii\helpers\Json;

/**
 * This is the model class for table "admin_user_online".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $last_timestamp
 * @property string $invoken_route
 * @property string $lock_pk
 * @property string $lock_table
 * @property string $lock_translation
 * @property string $lock_translation_args
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
            [['lock_table', 'lock_translation', 'lock_translation_args'], 'string'],
            [['invoken_route'], 'string', 'max' => 120],
            [['lock_pk'], 'safe'],
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
            'lock_pk' => 'Lock Primary Key',
            'lock_table' => 'Lock Database Table',
            'lock_translation' => 'Lock Translation Message',
            'lock_translation_args' => 'Lock Translation Message Arguments',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
    
    // static methods

    public static function lock($userId, $table, $pk, $translation, array $translationArgs = [])
    {
        $model = self::findOne(['user_id' => $userId]);
        
        if ($model) {
            $model->updateAttributes([
                'last_timestamp' => time(),
                'lock_table' => $table,
                'lock_pk' => $pk,
                'lock_translation' => $translation,
                'lock_translation_args' => Json::encode($translationArgs),
            ]);
        }
    }
    
    public static function unlock($userId)
    {
        $model = self::findOne(['user_id' => $userId]);
    
        if ($model) {
            $model->updateAttributes([
                'last_timestamp' => time(),
                'lock_table' => '',
                'lock_pk' => '',
                'lock_translation' => '',
                'lock_translation_args' => '',
            ]);
        }
    }
    
    /**
     * Refresh the state of the current user, or add if not exists.
     *
     * @param integer $userId
     * @param string $route
     */
    public static function refreshUser($userId, $route)
    {
        $model = self::findOne(['user_id' => $userId]);
        if ($model) {
            return (bool) $model->updateAttributes(['last_timestamp' => time(), 'invoken_route' => $route]);
        }
        
        $model = new self(['last_timestamp' => time(), 'user_id' => $userId, 'invoken_route' => $route]);
        return $model->save();
    }

    /**
     * Remove the given user id if exists.
     * @param unknown $userId
     */
    public static function removeUser($userId)
    {
        $model = self::findOne(['user_id' => $userId]);
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
    
    /**
     * Get the user online list.
     *
     * @return array
     */
    public static function getList()
    {
        $time = time();
        $return = [];
        
        foreach (self::find()->with('user')->all() as $item) {
            /* @var $item \luya\admin\models\UserOnline */
            $inactiveSince = ($time - $item->last_timestamp);
            $return[] = [
                'firstname' => $item->user->firstname,
                'lastname' => $item->user->lastname,
                'email' => $item->user->email,
                'last_timestamp' => $item->last_timestamp,
                'is_active' => ($inactiveSince >= (3*60)) ? false : true,
                'inactive_since' => round(($inactiveSince / 60)).' min',
                'lock_description' => Module::t($item->lock_translation, empty($item->lock_translation_args) ? [] : Json::decode($item->lock_translation_args)),
            ];
        }

        return $return;
    }

    /**
     * Get the number uf online users.
     *
     * @return integer
     */
    public static function getCount()
    {
        static::clearList();

        return self::find()->count();
    }
}
