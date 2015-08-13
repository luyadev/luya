<?php

namespace admin\ngrest\interfaces;

interface Render
{
    public function setConfig(\admin\ngrest\Config $config);

    public function render();
}
