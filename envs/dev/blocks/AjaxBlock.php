<?php

namespace app\blocks;

/**
 * Block created with Luya Block Creator Version 1.0.0-beta1-dev at 20.10.2015 16:13
 */
class AjaxBlock extends \cmsadmin\base\Block
{
    public function name()
    {
        return 'AjaxBlock';
    }

    public function icon()
    {
        return ''; // choose icon from: http://web.archive.org/web/20150315064340/http://materializecss.com/icons.html
    }

    public function config()
    {
        return [
        ];
    }

    public function callbackHallAjax()
    {
        var_dump('hoi!');
    }
    
    /**
     * Return an array containg all extra vars. Those variables you can access in the Twig Templates via {{extras.*}}.
     */
    public function extraVars()
    {
        return [
            'ajaxUrl' => $this->createAjaxLink('HalloAjax', ['foo' => 'bar']),
        ];
    }

    /**
     * Available twig variables:
     */
    public function twigFrontend()
    {
        return '{{ extras.ajaxUrl }}';
    }

    /**
     * Available twig variables:
     */
    public function twigAdmin()
    {
        return '<p>My Admin Twig of this Block</p>';
    }
}
