<?php

namespace app\blocks;

/**
 * Block created with Luya Block Creator Version 1.0.0-beta3-dev at 21.12.2015 10:57
 */
class ImageListTestBlock extends \cmsadmin\base\Block
{
    public function name()
    {
        return 'ImageListTestBlock';
    }

    public function icon()
    {
        return 'extension'; // choose icon from: http://materializecss.com/icons.html
    }

    public function config()
    {
        return [
           'vars' => [
               ['var' => 'images', 'label' => 'Images', 'type' => 'zaa-image-array-upload', 'options' => ['no_filter' => false]],
           ],
        ];
    }

    /**
     * Return an array containg all extra vars. Those variables you can access in the Twig Templates via {{extras.*}}.
     */
    public function extraVars()
    {
        return [
            $this->zaaImageArrayUpload($this->getVarValue('images')),
        ];
    }

    /**
     * Available twig variables:
     * @param {{vars.images}}
     */
    public function twigFrontend()
    {
        return '<p>My Frontend Twig of this Block</p>';
    }

    /**
     * Available twig variables:
     * @param {{vars.images}}
     */
    public function twigAdmin()
    {
        return '<p>My Admin Twig of this Block</p>';
    }
}
