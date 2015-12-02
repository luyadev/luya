<?php

namespace cmsadmin\blocks;

/**
 * Audio block for SoundCloud-Sources
 */
class AudioBlock extends \cmsadmin\base\Block
{
    public $cacheEnabled = true;
    
    public function name()
    {
        return 'Audio';
    }

    public function icon()
    {
        return 'volume_up'; // choose icon from: http://materializecss.com/icons.html
    }

    public function config()
    {
        return [
           'vars' => [
                ['var' => 'soundUrl', 'label' => 'Embeded Code', 'type' => 'zaa-text'],
           ],
           'cfgs' => [],
        ];
    }

    public function getFieldHelp()
    {
        return [
            'soundUrl' => 'Bisher wird nur SoundCloud Embeded Code unterstützt.',            
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
     * @param {{vars.soundUrl}}
     */
    public function twigFrontend()
    {
        return '<div>
                    {% if vars.soundUrl is not empty %}{{ vars.soundUrl }}{% else %}Keine Audioquelle angegeben{% endif %}
                </div>';
    }

    /**
     * Available twig variables:
     * @param {{vars.soundUrl}}
     */
    public function twigAdmin()
    {
        return '<p>Audio Block: {% if vars.soundUrl is empty %}Keine Audioquelle angegeben{% else %}Audioquelle ist gesetzt{% endif %}</p>';
    }
}