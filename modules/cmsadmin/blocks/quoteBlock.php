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
        return "mdi-editor-format-quote";
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
        return '{% if vars.content is not empty %}<p class="block__tag block__tag--quote">{{ vars.content }}</p>{% else %}Zitat{% endif %}';
    }
}
