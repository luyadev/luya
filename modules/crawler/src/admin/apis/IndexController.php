<?php

namespace luya\crawler\admin\apis;

/**
 * Search Index API.
 * 
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class IndexController extends \luya\admin\ngrest\base\Api
{
    public $modelClass = '\luya\crawler\models\Index';
}
