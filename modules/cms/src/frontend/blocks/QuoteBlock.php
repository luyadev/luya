<?php

namespace luya\cms\frontend\blocks;

use luya\cms\frontend\Module;
use luya\cms\frontend\blockgroups\TextGroup;
use luya\cms\base\TwigBlock;

/**
 * Blockquote Block.
 * 
 * @author Basil Suter <basil@nadar.io>
 */
class QuoteBlock extends TwigBlock
{
    public $module = 'cms';

    public $cacheEnabled = true;
    
    public function name()
    {
        return Module::t('block_quote_name');
    }

    public function icon()
    {
        return 'format_quote';
    }

    public function config()
    {
        return [
            'vars' => [
                ['var' => 'content', 'label' => Module::t('block_quote_content_label'), 'type' => 'zaa-text'],
            ],
        ];
    }

    public function twigFrontend()
    {
        return '{% if vars.content is not empty %}<blockquote>{{ vars.content }}</blockquote>{% endif %}';
    }

    public function twigAdmin()
    {
        return '{% if vars.content is not empty %}<blockquote>{{ vars.content }}</blockquote>{% else %}<span class="block__empty-text">' . Module::t('block_quote_no_content') . '</span>{% endif %}';
    }
    
    public function getBlockGroup()
    {
        return TextGroup::className();
    }
}
