<?php

namespace luya\admin\ngrest\base;

trigger_error('Deprecated class '.__CLASS__.', use luya\admin\ngrest\base\NgRestModel instead', E_USER_DEPRECATED);

/**
 * TEMP SHIM for Model class
 *
 * @author Basil Suter <basil@nadar.io>
 */
abstract class Model extends NgRestModel
{
}
