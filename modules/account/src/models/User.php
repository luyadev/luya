<?php

namespace luya\account\models;

use Yii;
use luya\admin\ngrest\base\NgRestModel;

class User extends NgRestModel implements \yii\web\IdentityInterface
{
    public $password_confirm;

    public $plainPassword;

    public function init()
    {
        parent::init();
        $this->on(self::EVENT_BEFORE_INSERT, [$this, 'encodePassword']);
    }
    
    public static function tableName()
    {
        return 'account_user';
    }

    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email]);
    }

    public function rules()
    {
        return [
            //[['email', 'password'], 'required', 'on' => 'login'],
            [['email', 'password', 'password_confirm'], 'required', 'on' => 'register'],
            [['email'], 'email', 'on' => 'register'],
            [['email'], 'validateUserExists', 'on' => 'register'],
            [['password'], 'validatePassword', 'on' => 'register'],
        ];
    }

    public function scenarios()
    {
        return [
            'register' => ['firstname', 'lastname', 'email', 'password', 'password_confirm', 'gender', 'street', 'zip', 'city', 'country', 'company', 'subscription_newsletter', 'subscription_medianews'],
            //'login' => ['email', 'password'],
            'restupdate' => ['firstname', 'lastname', 'email', 'street', 'zip', 'city', 'country', 'company', 'subscription_newsletter', 'subscription_medianews', 'is_mail_verified', 'is_active'],
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

    /* NgRest */
    
    public static function ngRestApiEndpoint()
    {
        return 'api-account-user';
    }
    
    public function ngRestConfig($config)
    {
        $config->list->field("firstname", "Vorname")->text();
        $config->list->field("lastname", "Lastname")->text();
        $config->list->field("email", "E-Mail")->text();
        $config->list->field("subscription_newsletter", "Newsletter")->toggleStatus();
        $config->list->field("subscription_medianews", "Neuigkeiten")->toggleStatus();
        $config->list->field("is_mail_verified", "E-Mail verifiziert")->toggleStatus();
        $config->list->field("is_active", "Aktiviert")->toggleStatus();
        
        $config->update->copyFrom('list');
        $config->update->field('street', 'Strasse')->text();
        $config->update->field('zip', 'PLZ')->text();
        $config->update->field('city', 'Ortschaft')->text();
        $config->update->field('country', 'Land')->text();
        $config->update->field('company', 'Firma')->text();
        return $config;
    }
    
    /* IdentityInterface */

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
     * @param null $type
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
        return $this->auth_key;
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
