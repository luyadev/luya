<?php

namespace luya\admin\apis;

use luya\admin\ngrest\base\Api;

/**
 * API to manage, create, udpate and delete all System Groups.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class GroupController extends Api
{
    /**
     * @var string The path to the group model.
     */
    public $modelClass = 'luya\admin\models\Group';
}
