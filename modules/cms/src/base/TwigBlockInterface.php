<?php

namespace luya\cms\base;

/**
 * Twig CMS Block interface
 *
 * @since 1.0.0-beta8
 * @author Basil Suter <basil@nadar.io>
 */
interface TwigBlockInterface
{
    public function twigFrontend();
    
    public function twigAdmin();
    
    public function render();
}
