<?php

namespace luya\admin\apis;

use luya\admin\ngrest\base\Api;

/**
 * API to manage, create, udpate and delete all System Groups.
 *
 * @author Basil Suter <basil@nadar.io>
 */
class GroupController extends Api
{
    /**
     * @var string The path to the group model.
     */
    public $modelClass = 'luya\admin\models\Group';
}
