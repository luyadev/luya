<?php

namespace luya\admin\apis;

use luya\admin\ngrest\base\Api;

/**
 * Language API, to manage, create, update and delte all system languages.
 *
 * @author Basil Suter <basil@nadar.io>
 */
class LangController extends Api
{
    public $modelClass = 'luya\admin\models\Lang';
}
