<?php

namespace admin\ngrest\base;

abstract class Render
{
    public $config = null;

    public function setConfig(\admin\ngrest\Config $config)
    {
        $this->config = $config;
    }
}
