<?php

namespace admin\ngrest\base;

abstract class Render
{
    protected $config = [];

    public function setConfig(\admin\ngrest\Config $config)
    {
        $this->config = $config;
    }
}
