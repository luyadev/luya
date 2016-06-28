<?php

namespace admin\apis;

/**
 * Effects API, provides all available system effects.
 * 
 * @author Basil Suter <basil@nadar.io>
 */
class EffectController extends \admin\ngrest\base\Api
{
    public $modelClass = 'admin\models\StorageEffect';
}
