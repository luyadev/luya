<?php

namespace luya\admin\apis;

use luya\admin\ngrest\base\Api;

/**
 * Tags API, provides ability to add, manage or collect all system tags.
 *
 * @author Basil Suter <basil@nadar.io>
 */
class TagController extends Api
{
    public $modelClass = 'luya\admin\models\Tag';
}
