<?php

namespace luyatests\data\models;

class User extends \yii\web\User
{
    public $identityClass = 'not\exsting';
}
