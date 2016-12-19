<?php

namespace luya\admin\ngrest\base;

trigger_error('Deprecated class '.__CLASS__.', use luya\admin\ngrest\base\NgRestModel instead', E_USER_DEPRECATED);

/**
 * TEMP SHIM for Model class
 *
 * @author Basil Suter <basil@nadar.io>
 * @deprecated Will be removed in 1.0.0, use {{luya\admin\ngrest\base\NgRestModel}} instead.
 */
abstract class Model extends NgRestModel
{
}
