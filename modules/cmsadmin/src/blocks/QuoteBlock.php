<?php

namespace cmsadmin\blocks;

use cmsadmin\Module;

class QuoteBlock extends \cmsadmin\base\Block
{
    public $module = 'cmsadmin';

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
}
