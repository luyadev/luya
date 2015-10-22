<?php

namespace cmsadmin\blocks;

class QuoteBlock extends \cmsadmin\base\Block
{
    public $module = 'cmsadmin';

    public function name()
    {
        return 'Zitat';
    }

    public function icon()
    {
        return 'format_quote';
    }

    public function config()
    {
        return [
            'vars' => [
                ['var' => 'content', 'label' => 'Text', 'type' => 'zaa-text'],
            ],
        ];
    }

    public function twigFrontend()
    {
        return '{% if vars.content is not empty %}<blockquote>{{ vars.content }}</blockquote>{% endif %}';
    }

    public function twigAdmin()
    {
        return '{% if vars.content is not empty %}<blockquote>{{ vars.content }}</blockquote>{% else %}<span class="block__empty-text">Es wurde noch kein Zitat eingegeben.</span>{% endif %}';
    }
}
