<?php

namespace luya\admin\apis;

use luya\admin\ngrest\base\Api;

/**
 * Effects API, provides all available system effects.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class EffectController extends Api
{
    /**
     * @var string The path to the StorageEffect model.
     */
    public $modelClass = 'luya\admin\models\StorageEffect';
}
