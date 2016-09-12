<?php

namespace luya\admin\apis;

use luya\admin\ngrest\base\Api;

/**
 * Filters API, provides all available system filters.
 *
 * @author Basil Suter <basil@nadar.io>
 */
class FilterController extends Api
{
    public $modelClass = 'luya\admin\models\StorageFilter';
}
