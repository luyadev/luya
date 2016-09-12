<?php

namespace luya\cms\base;

/**
 * PHP Cms Block interface
 *
 * @since 1.0.0-beta8
 * @author Basil Suter <basil@nadar.io>
 */
interface PhpBlockInterface
{
    public function frontend();
    
    public function admin();
}
