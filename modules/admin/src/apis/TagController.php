<?php

namespace luya\admin\apis;

use luya\admin\ngrest\base\Api;

/**
 * Tags API, provides ability to add, manage or collect all system tags.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class TagController extends Api
{
    /**
     * @var string The path to the tag model.
     */
    public $modelClass = 'luya\admin\models\Tag';
}
