<?php

namespace admin\ngrest\base;

/**
 * NgRest base rendere which is used in all ngrest render classes.
 * 
 * @author Basil Suter <basil@nadar.io>
 */
abstract class Render
{
    public $config = null;

    public function setConfig(\admin\ngrest\Config $config)
    {
        $this->config = $config;
    }
}
