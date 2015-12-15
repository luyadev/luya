<?php

namespace account\components;

class User extends \yii\web\User
{
    public $identityClass = '\accountadmin\models\User';

    public $loginUrl = ['/account/login/default'];

    public $identityCookie = ['name' => '_accountIdentity', 'httpOnly' => true];

    public $enableAutoLogin = false;
}
