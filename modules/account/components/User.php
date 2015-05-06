<?php

namespace account\components;

class User extends \yii\web\User
{
    public $identityClass = '\account\models\User';

    public $loginUrl = ['account/login'];

    public $identityCookie = ['name' => '_accountIdentity', 'httpOnly' => true];

    public $enableAutoLogin = false;
}
