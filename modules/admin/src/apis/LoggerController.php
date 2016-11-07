<?php

namespace luya\admin\apis;

use luya\admin\ngrest\base\Api;

/**
 * Logger Api to list the logger model data.
 * 
 * @author Basil Suter <basil@nadar.io>
 */
class LoggerController extends Api
{
	/**
	 * @var string Path to the logger model.
	 */
    public $modelClass = 'luya\admin\models\Logger';
}
