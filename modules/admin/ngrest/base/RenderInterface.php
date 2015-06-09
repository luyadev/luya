<?php

namespace admin\ngrest\base;

interface RenderInterface
{
    public function setConfig(\admin\ngrest\Config $config);

    public function render();
}
