<?php

namespace admin\apis;

/**
 * Tags API, provides ability to add, manage or collect all system tags.
 * 
 * @author Basil Suter <basil@nadar.io>
 */
class TagController extends \admin\ngrest\base\Api
{
    public $modelClass = '\admin\models\Tag';
}
