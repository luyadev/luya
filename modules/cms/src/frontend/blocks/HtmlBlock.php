<?php

namespace luya\cms\frontend\blocks;

use luya\cms\frontend\Module;
use luya\cms\frontend\blockgroups\DevelopmentGroup;
use luya\cms\base\TwigBlock;

/**
 * HTML Block
 * 
 * @author Basil Suter <basil@nadar.io>
 */
class HtmlBlock extends TwigBlock
{
    public $module = 'cms';

    public $cacheEnabled = true;
    
    public function name()
    {
        return 'HTML';
    }
    
    public function icon()
    {
        return 'code';
    }

    public function config()
    {
        return [
            'vars' => [
                ['var' => 'html', 'label' => Module::t('block_html_html_label'), 'type' => 'zaa-textarea'],
            ],
        ];
    }

    public function twigFrontend()
    {
        return '{{ vars.html | raw }}';
    }

    public function twigAdmin()
    {
        return '{% if vars.html is empty %}<span class="block__empty-text">' . Module::t('block_html_no_content') . '</span>{% else %}{{ vars.html | raw }}{% endif %}';
    }
    
    public function getBlockGroup()
    {
        return DevelopmentGroup::className();
    }
}
