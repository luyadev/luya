<?php

namespace luya\cms\frontend\blocks;

use luya\cms\frontend\Module;
use luya\cms\frontend\blockgroups\TextGroup;

class TitleBlock extends \luya\cms\base\Block
{
    public $module = 'cmsadmin';
    
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
        return '{% if vars.content is not empty %}<{{ extras.headingType }}>{{ vars.content }}</{{ extras.headingType }}>{% endif %}';
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
