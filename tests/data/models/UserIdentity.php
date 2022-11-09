<?php

namespace luyatests\data\models;

use yii\base\Model;
use yii\web\IdentityInterface;

class UserIdentity extends Model implements IdentityInterface
{
    public $id = 1;

    public static function findIdentity($id)
    {
        return (new self());
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return false;
    }

    public function getId()
    {
        return 1;
    }

    public function getAuthKey()
    {
        return false;
    }

    public function validateAuthKey($authKey)
    {
        return false;
    }
}
