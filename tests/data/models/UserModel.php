<?php

namespace luyatests\data\models;

class UserModel extends \admin\ngrest\base\Model
{
    public static function tableName()
    {
        return 'admin_user';
    }

    //public $i18n = ['firstname', 'lastname'];

    public function ngRestConfig($config)
    {
        return $config;
    }

    public function ngRestApiEndpoint()
    {
        return 'api-tests-model';
    }
}
