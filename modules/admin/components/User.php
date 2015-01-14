<?php
namespace admin\components;

class User extends \yii\web\User
{
    public $identityClass = '\admin\models\User';

    public $loginUrl = ["admin/login"];

    public $identityCookie = ['name' => '_adminIdentity', 'httpOnly' => true];

    public $enableAutoLogin = false;
}
