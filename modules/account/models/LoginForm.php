<?php
namespace account\models;

class LoginForm extends \yii\base\Model
{
    private $_user = false;

    public $email;
    public $password;

    public function rules()
    {
        return [
            [['email', 'password'], 'required'],
            ['password', 'validatePassword']
        ];
    }

    public function validatePassword($attribute)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->verifyPassword($this->password)) {
                $this->addError($attribute, "Incorrect username or password");
            }
        }
    }

    public function login()
    {
        if ($this->validate()) {
            $user = $this->getUser();

            return $user;
        } else {
            return false;
        }
    }

    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = \account\models\User::findByEmail($this->email);
        }

        return $this->_user;
    }
}
