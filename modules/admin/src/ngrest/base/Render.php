<?php

namespace luya\admin\ngrest\base;

use luya\admin\ngrest\ConfigInterface;

/**
 * NgRest base rendere which is used in all ngrest render classes.
 *
 * @author Basil Suter <basil@nadar.io>
 */
abstract class Render
{
    public $config = null;

    public function setConfig(ConfigInterface $config)
    {
        $this->config = $config;
    }
}
