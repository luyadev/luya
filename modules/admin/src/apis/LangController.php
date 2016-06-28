<?php

namespace admin\apis;

/**
 * Language API, to manage, create, update and delte all system languages.
 * 
 * @author Basil Suter <basil@nadar.io>
 */
class LangController extends \admin\ngrest\base\Api
{
    public $modelClass = 'admin\models\Lang';
}
