<?php

namespace cmsadmin\blocks;

class TitleBlock extends \cmsadmin\base\Block
{
    public $module = 'cmsadmin';

    public function name()
    {
        return 'Überschrift';
    }

    public function icon()
    {
        return "mdi-editor-format-size";
    }

    public function config()
    {
        return [
            'vars' => [
                ['var' => 'content', 'label' => 'Titel', 'type' => 'zaa-text'],
                ['var' => 'headingType', 'label' => 'Grösse', 'type' => 'zaa-select', 'options' =>
                    [
                        ['value' => 'h1', 'label' => 'Gross'],
                        ['value' => 'h2', 'label' => 'Mittel'],
                        ['value' => 'h3', 'label' => 'Klein'],
                    ],
                ],
            ],
        ];
    }

    public function twigFrontend()
    {
        return '{% if vars.headingType is not empty %}<{{ vars.headingType }}>{% else %}<h3>{% endif %}{% if vars.content is not empty %}{{ vars.content }}{% endif %}{% if vars.headingType is not empty %}</h3>{{ vars.headingType }}>{% else %}</h3>{% endif %}';
    }

    public function twigAdmin()
    {
        return '{% if vars.content is not empty %}<p class="block__tag block__tag--{{vars.headingType}}">{{ vars.content }}</p>{% else %}<p><strong>Es wurde noch keine Überschrift eingegeben.</strong></p>{% endif %}';
    }
}
