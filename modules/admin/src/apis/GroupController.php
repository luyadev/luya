<?php

namespace admin\apis;

/**
 * API to manage, create, udpate and delete all System Groups.
 * 
 * @author Basil Suter <basil@nadar.io>
 */
class GroupController extends \admin\ngrest\base\Api
{
    public $modelClass = 'admin\models\Group';
}
