<?php

namespace admin\ngrest\interfaces;

use admin\ngrest\Config;

interface Render
{
    public function setConfig(Config $config);

    public function render();
}
