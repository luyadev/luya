<?php

namespace luya\admin\ngrest\render;

use luya\admin\ngrest\ConfigInterface;

/**
 * NgRest Render Interface.
 *
 * All NgRest renderers must implement this interface.
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
interface RenderInterface
{
    public function setConfig(ConfigInterface $config);

    public function render();
}
