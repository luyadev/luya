<?php

namespace luya\admin\ngrest\render;

use luya\admin\ngrest\ConfigInterface;

/**
 * NgRest Render Interface
 *
 * @todo rename to RenderInterface
 * @author Basil Suter <basil@nadar.io>
 */
interface RenderInterface
{
    public function setConfig(ConfigInterface $config);

    public function render();
}
