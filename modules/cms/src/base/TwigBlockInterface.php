<?php

namespace luya\cms\base;

/**
 * Twig CMS Block interface
 *
 * @deprecated 1.0.0-RC2 Marked as deprecated and will be removed on 1.0.0 release.
 * @since 1.0.0-beta8
 * @author Basil Suter <basil@nadar.io>
 */
interface TwigBlockInterface
{
    public function twigFrontend();
    
    public function twigAdmin();
    
    public function render();
}
