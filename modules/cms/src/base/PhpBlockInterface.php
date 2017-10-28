<?php

namespace luya\cms\base;

/**
 * PHP Cms Block interface
 *
 * @author Basil Suter <basil@nadar.io>
 * @since 1.0.0
 */
interface PhpBlockInterface
{
    public function frontend();
    
    public function admin();
}
