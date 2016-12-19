<?php

namespace luya\cms\frontend\blocks;

use luya\cms\frontend\Module;
use luya\cms\base\TwigBlock;
use luya\cms\frontend\blockgroups\MediaGroup;

/**
 * Audio Block for Soundcloude Service
 *
 * @author Basil Suter <basil@nadar.io>
 */
final class AudioBlock extends TwigBlock
{
    /**
     * @inheritDoc
     */
    public $cacheEnabled = true;
    
    /**
     * @inheritDoc
     */
    public function name()
    {
        return Module::t('block_audio_name');
    }

    /**
     * @inheritDoc
     */
    public function blockGroup()
    {
        return MediaGroup::class;
    }
    
    /**
     * @inheritDoc
     */
    public function icon()
    {
        return 'volume_up';
    }

    /**
     * @inheritDoc
     */
    public function config()
    {
        return [
           'vars' => [
                ['var' => 'soundUrl', 'label' => 'Embeded Code', 'type' => 'zaa-text'],
           ],
        ];
    }

    /**
     * @inheritDoc
     */
    public function getFieldHelp()
    {
        return [
            'soundUrl' => Module::t('block_audio_help_soundurl'),
        ];
    }

    /**
     * @inheritDoc
     */
    public function twigFrontend()
    {
        return '<div>{% if vars.soundUrl is not empty %}{{ vars.soundUrl }}{% else %}Keine Audioquelle angegeben{% endif %}</div>';
    }

    /**
     * @inheritDoc
     */
    public function twigAdmin()
    {
        return '<p>Audio Block: {% if vars.soundUrl is empty %}Keine Audioquelle angegeben{% else %}Audioquelle ist gesetzt{% endif %}</p>';
    }
}
