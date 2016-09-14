<?php

namespace luya\cms\frontend\blocks;

use luya\cms\frontend\Module;
use luya\cms\frontend\blockgroups\TextGroup;
use luya\cms\base\TwigBlock;

/**
 * Heading-Title Block.
 * 
 * @author Basil Suter <basil@nadar.io>
 */
class TitleBlock extends TwigBlock
{
    public $module = 'cms';
    
    public $cacheEnabled = true;

    public function name()
    {
        return Module::t('block_title_name');
    }

    public function icon()
    {
        return 'format_size';
    }

    public function config()
    {
        return [
            'vars' => [
                ['var' => 'content', 'label' => Module::t('block_title_content_label'), 'type' => 'zaa-text'],
                ['var' => 'headingType', 'label' => Module::t('block_title_headingtype_label'), 'type' => 'zaa-select', 'initvalue' => 'h1', 'options' => [
                        ['value' => 'h1', 'label' => Module::t('block_title_headingtype_heading') . ' 1'],
                        ['value' => 'h2', 'label' => Module::t('block_title_headingtype_heading') . ' 2'],
                        ['value' => 'h3', 'label' => Module::t('block_title_headingtype_heading') . ' 3'],
                        ['value' => 'h4', 'label' => Module::t('block_title_headingtype_heading') . ' 4'],
                        ['value' => 'h5', 'label' => Module::t('block_title_headingtype_heading') . ' 5'],
                    ],
                ],
            ],
            'cfgs' => [
                ['var' => 'cssClass', 'label' => Module::t('block_cfg_additonal_css_class'), 'type' => 'zaa-text'],
            ]
        ];
    }

    public function extraVars()
    {
        return [
            'headingType' => $this->getVarValue('headingType', 'h2'),
        ];
    }

    public function twigFrontend()
    {
        return '{% if vars.content is not empty %}<{{ extras.headingType }}{% if cfgs.cssClass is not empty %} class="{{cfgs.cssClass}}"{% endif %}>{{ vars.content }}</{{ extras.headingType }}>{% endif %}';
    }

    public function twigAdmin()
    {
        return '{% if vars.content is not empty %}<{{extras.headingType}}>{{ vars.content }}</{{extras.headingType}}>{% else %}<span class="block__empty-text">' . Module::t('block_title_no_content') . '</span>{% endif %}';
    }
    
    public function getBlockGroup()
    {
        return TextGroup::className();
    }
}
