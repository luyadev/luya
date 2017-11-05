<?php

namespace luya\admin\apis;

use luya\admin\ngrest\base\Api;

/**
 * Logger Api to list the logger model data.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class LoggerController extends Api
{
    /**
     * @var string Path to the logger model.
     */
    public $modelClass = 'luya\admin\models\Logger';
}
