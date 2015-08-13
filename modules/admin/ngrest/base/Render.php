<?php

namespace admin\ngrest\base;

use admin\ngrest\Config;

abstract class Render
{
    public $config = [];

    public function setConfig(Config $config)
    {
        $this->config = $config;
    }
}
