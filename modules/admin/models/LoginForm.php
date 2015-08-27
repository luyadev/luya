<?php

namespace admin\models;

use admin\models\UserLogin;
use admin\models\UserOnline;

class LoginForm extends \yii\base\Model
{
    private $_user = false;

    public $email;
    public $password;

    public function rules()
    {
        return [
            [['email', 'password'], 'required'],
            ['password', 'validatePassword'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'email' => 'E-Mail',
            'password' => 'Passwort',
        ];
    }

    public function validatePassword($attribute)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Falscher Benutzer oder Passwort.');
            }
        }
    }

    public function login()
    {
        if ($this->validate()) {
            $user = $this->getUser();
            $user->scenario = 'login';
            $user->auth_token = \yii::$app->security->hashData(\yii::$app->security->generateRandomString(), $user->password_salt);
            $user->save();

            $login = new UserLogin();
            $login->setAttributes([
                'auth_token' => $user->auth_token,
                'user_id' => $user->id,
            ]);
            $login->insert();
            UserOnline::refreshUser($user->id, 'login');

            return $user;
        } else {
            return false;
        }
    }

    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = \admin\models\User::findByEmail($this->email);
        }

        return $this->_user;
    }
}
