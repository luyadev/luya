<?php

namespace luya\web;

use yii\web\IdentityInterface;

/**
 * Group User IdentityInterface.
 *
 * When using the {{luya\web\GroupUser}} component to authorize users, each identity class must implement this Interface.
 *
 * > The GroupUserIdentityInterface extends the {{yii\web\IdentityInterface}} Interface.
 *
 * ```php
 * class User extends ActiveRecord implements GroupUserIdentityInterface
 * {
 *     // luya\web\GroupUserIdentityInterface
 *
 *     public function authGroups()
 *     {
 *         return [
 *             'group-a',
 *         ];
 *     }
 *
 *     // yii\web\IdentityInterface
 *
 *     public static function findIdentity($id)
 *     {
 *         return static::findOne($id);
 *     }
 *
 *     public static function findIdentityByAccessToken($token, $type = null)
 *     {
 *         return static::findOne(['access_token' => $token]);
 *     }
 *
 *     public function getId()
 *     {
 *         return $this->id;
 *     }
 *
 *     public function getAuthKey()
 *     {
 *         return $this->authKey;
 *     }
 *
 *     public function validateAuthKey($authKey)
 *     {
 *         return $this->authKey === $authKey;
 *     }
 * }
 * ```
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
interface GroupUserIdentityInterface extends IdentityInterface
{
    /**
     * Returns an array with group aliases allowed for the current user.
     *
     * ```php
     * public function authGroups()
     * {
     *     return [
     *         'group-a', 'group-c',
     *     ];
     * }
     * ```
     *
     * @return array An array contains the allowed groups for this user.
     */
    public function authGroups();
}
