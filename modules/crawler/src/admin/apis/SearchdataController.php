<?php

namespace luya\crawler\admin\apis;

/**
 * Search API.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class SearchdataController extends \luya\admin\ngrest\base\Api
{
    /**
     * @var string $modelClass The path to the model which is the provider for the rules and fields.
     */
    public $modelClass = '\luya\crawler\models\Searchdata';
}
