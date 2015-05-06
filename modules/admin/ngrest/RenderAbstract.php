<?php

namespace admin\ngrest;

abstract class RenderAbstract
{
    protected $config = [];

    public function setConfig(Config $config)
    {
        $this->config = $config;
    }
}
