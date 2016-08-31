<?php

namespace luya\cms\frontend\blocks;

use luya\cms\frontend\Module;

/**
 * Audio block for SoundCloud-Sources
 */
class AudioBlock extends \luya\cms\base\Block
{
    public $cacheEnabled = true;
    
    public function name()
    {
        return Module::t('block_audio_name');
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
        ];
    }

    public function getFieldHelp()
    {
        return [
            'soundUrl' => Module::t('block_audio_help_soundurl'),
        ];
    }

    /**
     * Available twig variables:
     * @param {{vars.soundUrl}}
     */
    public function twigFrontend()
    {
        return '<div>{% if vars.soundUrl is not empty %}{{ vars.soundUrl }}{% else %}Keine Audioquelle angegeben{% endif %}</div>';
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
