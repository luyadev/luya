<?php

namespace luya\admin\apis;

/**
 * Proxy Build Controller.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class ProxyBuildController extends \luya\admin\ngrest\base\Api
{
    /**
     * @var string The path to the model which is the provider for the rules and fields.
     */
    public $modelClass = 'luya\admin\models\ProxyBuild';
}
