<?php

namespace luya\admin\apis;

use luya\admin\ngrest\base\Api;

/**
 * Proxy Machine Controller.
 *
 * File has been created with `crud/create` command on LUYA version 1.0.0-dev.
 */
class ProxyMachineController extends Api
{
    /**
     * @var string The path to the model which is the provider for the rules and fields.
     */
    public $modelClass = 'luya\admin\models\ProxyMachine';
}
