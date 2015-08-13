<?php

namespace admin\ngrest\base;

use admin\ngrest\Config;

abstract class Render
{
    protected $config = [];

    public function setConfig(Config $config)
    {
        $this->config = $config;
    }
}
