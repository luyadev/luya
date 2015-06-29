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
        return 'mdi-editor-format-size';
    }

    public function config()
    {
        return [
            'vars' => [
                ['var' => 'content', 'label' => 'Titel', 'type' => 'zaa-text'],
                ['var' => 'headingType', 'label' => 'Grösse', 'type' => 'zaa-select', 'initvalue' => 'h1', 'options' =>
                    [
                        ['value' => 'h1', 'label' => 'Gross'],
                        ['value' => 'h2', 'label' => 'Mittel'],
                        ['value' => 'h3', 'label' => 'Klein'],
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
        return '{% if vars.content is not empty %}<p class="block__tag block__tag--{{extras.headingType}}">{{ vars.content }}</p>{% else %}<span class="block__empty-text">Es wurde noch keine Überschrift eingegeben.</span>{% endif %}';
    }
}
