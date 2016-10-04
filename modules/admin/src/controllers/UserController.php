<?php

namespace luya\admin\controllers;

use luya\admin\ngrest\base\Controller;

/**
 * NgRest User Controller.
 *
 * @author Basil Suter <basil@nadar.io>
 */
class UserController extends Controller
{
    public $modelClass = 'luya\admin\models\User';
}
