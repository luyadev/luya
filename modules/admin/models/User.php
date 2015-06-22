<?php

namespace admin\models;

use yii;
use yii\web\IdentityInterface;

/**
 * $salt = \Yii::$app->getSecurity()->generateRandomString();
 * $password = \Yii::$app->getSecurity()->generatePasswordHash("yourpass" . $salt);.
 *
 * @author nadar
 */
class User extends \admin\ngrest\base\Model implements IdentityInterface
{
    public function ngRestApiEndpoint()
    {
        return 'api-admin-user';
    }

    public function ngRestConfig($config)
    {
        $config->aw->register(new \admin\aws\ChangePassword(), 'Passwort ändern');

        //$config->activeWindow->register(new \admin\aws\Delete(), 'Löschen');

        $config->create->field('title', 'Anrede')->selectArray(\admin\models\User::getTitles());
        $config->create->field('firstname', 'Vorname')->text()->required();
        $config->create->field('lastname', 'Nachname')->text()->required();
        $config->create->field('email', 'E-Mail-Adresse')->text()->required();
        $config->create->field('password', 'Passwort')->password()->required();

        $config->list->field('id', 'ID')->text();
        $config->list->field('firstname', 'Vorname')->text();
        $config->list->field('lastname', 'Nachname')->text();
        $config->update->copyFrom('create', ['password']);

        return $config;
    }

    public static function tableName()
    {
        return 'admin_user';
    }

    public function init()
    {
        parent::init();
        $this->on(self::EVENT_BEFORE_INSERT, [$this, 'beforeCreate']);
        $this->on(self::EVENT_BEFORE_VALIDATE, [$this, 'eventBeforeValidate']);
    }
    
    
    public function genericSearchFields()
    {
        return ['firstname', 'lastname', 'email'];
    }

    public function rules()
    {
        return [
            [['title', 'firstname', 'lastname', 'email', 'password'], 'required', 'on' => 'restcreate'],
            [['title', 'firstname', 'lastname', 'email'], 'required', 'on' => 'restupdate'],
            [['email', 'password'], 'required', 'on' => 'login'],
        ];
    }

    public function scenarios()
    {
        return [
            'restcreate' => ['title', 'firstname', 'lastname', 'email', 'password'],
            'restupdate' => ['title', 'firstname', 'lastname', 'email'],
            'changepassword' => ['password', 'password_salt'],
            'login' => ['email', 'password'],
        ];
    }

    public function beforeCreate()
    {
        $this->auth_token = '';
        $this->is_deleted = 0;
    }

    public function eventBeforeValidate()
    {
        if ($this->scenario == 'restcreate') {
            $this->encodePassword();
        }
    }

    /**
     * override default scope find().
     */
    public static function find()
    {
        return parent::find()->where(['is_deleted' => 0]);
    }

    public function debugPass($pass)
    {
        $salt = \Yii::$app->getSecurity()->generateRandomString();
        $password = \Yii::$app->getSecurity()->generatePasswordHash($pass.$salt);

        echo "salt: $salt\n\n<br />";
        echo "pass: $password";
    }

    public function changePassword($newpass, $newpasswd)
    {
        if (strlen($newpass) < 8) {
            return $this->addError('newpass', 'Das neue Passwort muss mindistens 8 Zeichen lang sein');
        }
        if ($newpass !== $newpasswd) {
            return $this->addError('newpasswd', 'Das neue Passwort muss mit der wiederholung überein stimmen.');
        }

        $this->password = $newpass;

        if ($this->encodePassword()) {
            if ($this->save()) {
                return true;
            } else {
                $this->addError('newpass', 'Error while storing new password, database error.');
            }
        }

        return $this->addError('newpass', 'error while encoding password!');
    }

    /*
    public function changePassword($oldpass, $newpass, $newpasswd)
    {
        if (strlen($newpass) < 8) {
            return $this->addError('password', 'Das neue Passwort muss mindistens 8 Zeichen lang sein');
        }
        if ($newpass !== $newpasswd) {
            return $this->addError('password', 'Das neue Passwort muss mit der wiederholung überein stimmen.');
        }

        if (!$this->validatePassword($oldpass)) {
            return $this->addError('oldpass', 'Das alte passwort ist nicht korrekt!' . $oldpass . ' | ' . $this->password);
        }

        $this->password = $newpass;

        if($this->verifyPassword()) {
            return true;
        }

        return false;
    }

    */
    public function encodePassword()
    {
        if (empty($this->password) || strlen($this->password) < 8) {
            $this->addError('password', 'the password must be 8 chars');

            return false;
        }
        // create random string for password salting
        $this->password_salt = yii::$app->getSecurity()->generateRandomString();
        // store the password
        $this->password = yii::$app->getSecurity()->generatePasswordHash($this->password.$this->password_salt);

        return true;
    }

    public static function getTitles()
    {
        return [1 => 'Herr', 2 => 'Frau'];
    }

    public function fields()
    {
        $fields = parent::fields();
        unset($fields['password'], $fields['password_salt'], $fields['auth_token'], $fields['is_deleted']);

        return $fields;
    }

    public function getGroups()
    {
        return $this->hasMany(\admin\models\Group::className(), ['id' => 'group_id'])
        ->viaTable('admin_user_group', ['user_id' => 'id']);
    }

    public function extraFields()
    {
        return ['groups'];
    }

    /* ------------------------------------ yii2 auth methods below ------------------------------------ */

    public static function findByEmail($email)
    {
        return self::find()->where(['email' => $email])->one();
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password.$this->password_salt, $this->password);
    }

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

    public function getAuthToken()
    {
        return $this->auth_token;
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
