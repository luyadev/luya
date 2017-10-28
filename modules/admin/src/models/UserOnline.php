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
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
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

    /**
     * Lock the user for an action.
     *
     * @param unknown $userId
     * @param unknown $table
     * @param unknown $pk
     * @param unknown $translation
     * @param array $translationArgs
     */
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
    
    /**
     * Unlock the user from an action.
     *
     * @param unknown $userId
     */
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
     * @return bool
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
     * Remove all rows for a given User Id.
     *
     * @param int $userId
     */
    public static function removeUser($userId)
    {
        self::deleteAll(['user_id' => $userId]);
    }

    /**
     * Clear all users which are not logged in anymore.
     *
     * On production its 30 minutes on test system 60 minutes.
     */
    public static function clearList()
    {
        $max = YII_ENV_PROD ? 1800 : 3600;
        self::deleteAll(['<=', 'last_timestamp', time() - $max]);
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
