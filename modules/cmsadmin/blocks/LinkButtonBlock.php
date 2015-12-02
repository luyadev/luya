<?php

namespace cmsadmin\blocks;

/**
 * Simple button element with a link function
 */
class LinkButtonBlock extends \cmsadmin\base\Block
{
    public $cacheEnabled = true;

    public function name()
    {
        return 'Link Button';
    }

    public function icon()
    {
        return 'link'; // choose icon from: http://materializecss.com/icons.html
    }

    public function config()
    {
        return [
           'vars' => [
               ['var' => 'btnLabel', 'label' => 'Button Label', 'type' => 'zaa-text'],
               ['var' => 'btnHref', 'label' => 'Link Adresse', 'type' => 'zaa-text'],
           ],
           'cfgs' => [
                ['var' => 'targetBlank', 'label' => 'Link in einem neuen Fenster öffnen', 'type' => 'zaa-checkbox'],
           ],
        ];
    }

    /**
     * Return an array containg all extra vars. Those variables you can access in the Twig Templates via {{extras.*}}.
     */
    public function extraVars()
    {
        return [
            // add your custom extra vars here
        ];
    }

    /**
     * Available twig variables:
     * @param {{vars.btnLabel}}
     * @param {{vars.btnHref}}
     * @param {{cfgs.targetBlank}}
     */
    public function twigFrontend()
    {
        return '<a class="button" 
                    {% if cfgs.targetBlank == 1  %}target="_blank"{% endif %} 
                    href="{% if vars.btnHref is not empty %}{{ vars.btnHref }}{% else %}#{% endif %}">
                    {% if vars.btnLabel is not empty %} {{ vars.btnLabel }} {% endif %}
                </a>';
    }

    /**
     * Available twig variables:
     * @param {{vars.btnLabel}}
     * @param {{vars.btnHref}}
     * @param {{cfgs.targetBlank}}
     */
    public function twigAdmin()
    {
        return '<p>Link Button</p>';
    }
}
