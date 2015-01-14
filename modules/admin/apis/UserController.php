<?php
namespace admin\apis;

class UserController extends \admin\base\RestActiveController
{
    public function actions()
    {
        $actions = parent::actions();

        unset($actions['delete']);

        return $actions;
    }

    public $modelClass = 'admin\models\User';
}
