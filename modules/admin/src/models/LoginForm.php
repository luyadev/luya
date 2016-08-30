<?php

namespace luya\admin\models;

use Yii;
use yii\helpers\Url;
use luya\admin\Module;

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
            'email' => Module::t('model_loginform_email_label'),
            'password' => Module::t('model_loginform_password_label'),
        ];
    }

    public function validatePassword($attribute)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, Module::t('model_loginform_wrong_user_or_password'));
            }
        }
    }

    public function sendSecureLogin()
    {
        $token = $this->getUser()->getAndStoreToken();

        Yii::$app->mail->compose(Module::t('login_securetoken_mail_subject'), Module::t('login_securetoken_mail', ['url' => Url::base(true), 'token' => $token]))->address($this->getUser()->email)->send();

        return true;
    }

    public function validateSecureToken($token, $userId)
    {
        $user = User::findOne($userId);
        
        if (!$user) {
            return false;
        }
        
        if ($user->secure_token == sha1($token)) {
            return $user;
        }

        return false;
    }

    public function login()
    {
        if ($this->validate()) {
            $user = $this->getUser();
            $user->detachBehavior('LogBehavior');
            $user->scenario = 'login';
            $user->force_reload = 0;
            $user->auth_token = Yii::$app->security->hashData(Yii::$app->security->generateRandomString(), $user->password_salt);
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
            $this->_user = User::findByEmail($this->email);
        }

        return $this->_user;
    }
}
