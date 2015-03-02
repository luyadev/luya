<?php
namespace account\models;

class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    public static function tableName()
    {
        return 'account_user';
    }
    
    // identityInterface
    
    /* IdentityInterface below */
    
    /**
     * Finds an identity by the given ID.
     *
     * @param  string|integer         $id the ID to be looked for
     * @return IdentityInterface|null the identity object that matches the given ID.
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }
    
    /**
     * Finds an identity by the given token.
     *
     * @param  string                 $token the token to be looked for
     * @return IdentityInterface|null the identity object that matches the given token.
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['auth_token' => $token]);
    }
    
    /**
     * @return int|string current user ID
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * @return string current user auth key
     */
    public function getAuthKey()
    {
        return $this->auth_key; // @todo use this key for what?
    }
    
    /**
     * @param  string  $authKey
     * @return boolean if auth key is valid for current user
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }
}