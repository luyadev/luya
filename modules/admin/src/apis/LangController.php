<?php

namespace luya\admin\apis;

use luya\admin\ngrest\base\Api;

/**
 * Language API, to manage, create, update and delte all system languages.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class LangController extends Api
{
    /**
     * @var string The path to the language model.
     */
    public $modelClass = 'luya\admin\models\Lang';
}
