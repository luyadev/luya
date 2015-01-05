<?php
namespace luya\ngrest;

abstract class RenderAbstract
{
    protected $config = [];

    public function setConfig(Config $config)
    {
        $this->config = $config;
    }
}
