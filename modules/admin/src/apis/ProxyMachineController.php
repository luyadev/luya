<?php

namespace luya\admin\apis;

use luya\admin\ngrest\base\Api;

/**
 * Proxy Machine Controller.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
class ProxyMachineController extends Api
{
    /**
     * @var string The path to the model which is the provider for the rules and fields.
     */
    public $modelClass = 'luya\admin\models\ProxyMachine';
}
