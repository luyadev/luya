<?php

namespace admin\apis;

/**
 * Filters API, provides all available system filters.
 * 
 * @author Basil Suter <basil@nadar.io>
 */
class FilterController extends \admin\ngrest\base\Api
{
    public $modelClass = 'admin\models\StorageFilter';
}
