<?php

namespace admin\ngrest\interfaces;

/**
 * NgRest Render Interface
 * 
 * @todo rename to RenderInterface
 * @author Basil Suter <basil@nadar.io>
 */
interface Render
{
    public function setConfig(\admin\ngrest\Config $config);

    public function render();
}
