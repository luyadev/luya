<?php

namespace luya\cms\frontend\blocks;

use luya\cms\frontend\Module;
use luya\cms\frontend\blockgroups\MediaGroup;
use luya\cms\base\PhpBlock;

/**
 * Audio Block for Soundcloude Service
 *
 * @author Basil Suter <basil@nadar.io>
 */
final class AudioBlock extends PhpBlock
{
    /**
     * @inheritdoc
     */
    public $module = 'cms';
    
    /**
     * @inheritdoc
     */
    public $cacheEnabled = true;
    
    /**
     * @inheritdoc
     */
    public function name()
    {
        return Module::t('block_audio_name');
    }

    /**
     * @inheritdoc
     */
    public function blockGroup()
    {
        return MediaGroup::class;
    }
    
    /**
     * @inheritdoc
     */
    public function icon()
    {
        return 'volume_up';
    }

    /**
     * @inheritdoc
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
     * @inheritdoc
     */
    public function getFieldHelp()
    {
        return [
            'soundUrl' => Module::t('block_audio_help_soundurl'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function admin()
    {
        return '<p>Audio Block: {% if vars.soundUrl is empty %}'.Module::t('block_audio_admin_nourl').'{% else %}'.Module::t('block_audio_admin_hasurl').'{% endif %}</p>';
    }
}
