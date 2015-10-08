<?php

namespace account\models;

use Yii;

class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    public $password_confirm = null;

    public $plainPassword = null;

    public static function tableName()
    {
        return 'account_user';
    }

    public static function findByEmail($email)
    {
        return self::find()->where(['email' => $email])->one();
    }

    public function rules()
    {
        return [
            [['email', 'password'], 'required', 'on' => 'login'],
            [['firstname', 'lastname', 'email', 'password'], 'required', 'on' => 'register'],
            [['email'], 'email', 'on' => 'register'],
            [['email'], 'validateUserExists', 'on' => 'register'],
            [['password'], 'validatePassword', 'on' => 'register'],
        ];
    }

    public function scenarios()
    {
        return [
            'register' => ['firstname', 'lastname', 'email', 'password', 'password_confirm'],
            'login' => ['email', 'password'],
        ];
    }

    public function validateUserExists($attribute, $params)
    {
        $exists = self::findByEmail($this->email);
        if (!empty($exists)) {
            $this->addError($attribute, 'Dieser Benutzer existiert schon');
        }
    }

    public function validatePassword($attribute, $params)
    {
        if (strlen($this->password) < 6) {
            $this->addError($attribute, 'Das Passwort muss min. 6 Zeichen haben');
        }
        if ($this->password !== $this->password_confirm) {
            $this->addError($attribute, 'Das Passwort muss mit der Passwortwiederholung überein stimmen.');
        }
    }

    public function verifyPassword($password)
    {
        return Yii::$app->security->validatePassword($password.$this->password_salt, $this->password);
    }

    public function encodePassword()
    {
        $this->plainPassword = $this->password;

        // create random string for password salting
        $this->password_salt = Yii::$app->getSecurity()->generateRandomString();
        // store the password
        $this->password = Yii::$app->getSecurity()->generatePasswordHash($this->password.$this->password_salt);
        $this->password_confirm = $this->password;
    }

    // identityInterface

    /* IdentityInterface below */

    /**
     * Finds an identity by the given ID.
     *
     * @param string|int $id the ID to be looked for
     *
     * @return IdentityInterface|null the identity object that matches the given ID.
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * Finds an identity by the given token.
     *
     * @param string $token the token to be looked for
     *
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
     * @param string $authKey
     *
     * @return bool if auth key is valid for current user
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }
}
