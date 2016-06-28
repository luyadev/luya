<?php

namespace admin\apis;

/**
 * User API, provides ability to manager and list all administration users.
 * 
 * @author Basil Suter <basil@nadar.io>
 */
class UserController extends \admin\ngrest\base\Api
{
    public $modelClass = 'admin\models\User';
}
