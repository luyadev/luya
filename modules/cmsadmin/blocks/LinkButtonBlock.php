<?php

namespace cmsadmin\blocks;

use cmsadmin\Module;

/**
 * Simple button element with a link function
 */
class LinkButtonBlock extends \cmsadmin\base\Block
{
    public $cacheEnabled = true;

    public function name()
    {
        return Module::t('block_link_button_name');
    }

    public function icon()
    {
        return 'link'; // choose icon from: http://materializecss.com/icons.html
    }

    public function config()
    {
        return [
           'vars' => [
               ['var' => 'btnLabel', 'label' => Module::t('block_link_button_btnlabel_label'), 'type' => 'zaa-text'],
               ['var' => 'btnHref', 'label' => Module::t('block_link_button_btnhref_label'), 'type' => 'zaa-text'],
           ],
           'cfgs' => [
                ['var' => 'targetBlank', 'label' => Module::t('block_link_button_targetblank_label'), 'type' => 'zaa-checkbox'],
                ['var' => 'simpleLink', 'label' => Module::t('block_link_button_simpleLink_label'), 'type' => 'zaa-checkbox'],
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
        return '<a 
                    {% if cfgs.simpleLink == 0  %}class="button" {% endif %}
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
        return '<p>' . Module::t('block_link_button_name') . '</p>';
    }
}
