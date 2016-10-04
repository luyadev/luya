<?php

namespace luya\admin\apis;

use luya\admin\ngrest\base\Api;

/**
 * Effects API, provides all available system effects.
 *
 * @author Basil Suter <basil@nadar.io>
 */
class EffectController extends Api
{
    public $modelClass = 'luya\admin\models\StorageEffect';
}
