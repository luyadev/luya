<?php

namespace app\blocks;

/**
 * Block created with Luya Block Creator Version 1.0.0-beta3-dev at 21.12.2015 11:30
 */
class ImageNoFilterBlock extends \cmsadmin\base\Block
{
    public function name()
    {
        return 'ImageNoFilterBlock';
    }

    public function icon()
    {
        return 'extension'; // choose icon from: http://materializecss.com/icons.html
    }

    public function config()
    {
        return [
           'vars' => [
               ['var' => 'image', 'label' => 'Bild', 'type' => 'zaa-image-upload', 'options' => ['no_filter' => true]],
           ],
           'cfgs' => [
               ['var' => 'testimage', 'label' => 'testimage', 'type' => 'zaa-image-upload'],
           ],
        ];
    }

    /**
     * Return an array containg all extra vars. Those variables you can access in the Twig Templates via {{extras.*}}.
     */
    public function extraVars()
    {
        return [
            'image' => $this->zaaImageUpload($this->getVarValue('image')),
            'testimage' => $this->zaaImageUpload($this->getCfgValue('testimage')),
        ];
    }

    /**
     * Available twig variables:
     * @param {{vars.image}}
     * @param {{cfgs.testimage}}
     */
    public function twigFrontend()
    {
        return '<p>My Frontend Twig of this Block</p>';
    }

    /**
     * Available twig variables:
     * @param {{vars.image}}
     * @param {{cfgs.testimage}}
     */
    public function twigAdmin()
    {
        return '<p>My Admin Twig of this Block</p>';
    }
}
