<?php

namespace admin\apis;

class UserController extends \admin\ngrest\base\Api
{
    public function actions()
    {
        $actions = parent::actions();

        unset($actions['delete']);

        return $actions;
    }

    public $modelClass = 'admin\models\User';
}
