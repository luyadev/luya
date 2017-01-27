<?php

namespace luya\admin\models;

use Yii;
use yii\helpers\Url;
use luya\admin\Module;
use yii\base\Model;

/**
 * Admin Login Form Model.
 *
 * @property \luya\admin\models\User $user The user model.
 * @author Basil Suter <basil@nadar.io>
 */
final class LoginForm extends Model
{
    private $_user = false;

    public $email;
    
    public $password;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'password'], 'required'],
            [['email'], 'email'],
            ['password', 'validatePassword'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'email' => Module::t('model_loginform_email_label'),
            'password' => Module::t('model_loginform_password_label'),
        ];
    }

    /**
     * Inline validator.
     *
     * @param string $attribute Attribute value
     */
    public function validatePassword($attribute)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, Module::t('model_loginform_wrong_user_or_password'));
            }
        }
    }

    /**
     * Send the secure token by mail.
     *
     * @return boolean
     */
    public function sendSecureLogin()
    {
        $token = $this->getUser()->getAndStoreToken();

        Yii::$app->mail->compose(Module::t('login_securetoken_mail_subject'), Module::t('login_securetoken_mail', [
            'url' => Url::base(true),
            'token' => $token,
        ]))->address($this->user->email)->send();

        return true;
    }

    /**
     * Validate the secure token.
     *
     * @param string $token
     * @param integer $userId
     * @return boolean|\luya\admin\models\User
     */
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

    /**
     * Login the current user if valid.
     *
     * @return boolean|\luya\admin\models\User|boolean
     */
    public function login()
    {
        if ($this->validate()) {
            $user = $this->getUser();
            $user->detachBehavior('LogBehavior');
            $user->scenario = 'login';
            $user->force_reload = 0;
            $user->auth_token = Yii::$app->security->hashData(Yii::$app->security->generateRandomString(), $user->password_salt);
            $user->save();

            $login = new UserLogin([
                'auth_token' => $user->auth_token,
                'user_id' => $user->id,
            ]);
            $login->save();
            UserOnline::refreshUser($user->id, 'login');
            return $user;
        } else {
            return false;
        }
    }

    /**
     * @return boolean|\luya\admin\models\User
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByEmail($this->email);
        }

        return $this->_user;
    }
}
