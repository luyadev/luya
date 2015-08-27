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
                ['var' => 'headingType', 'label' => 'Grösse', 'type' => 'zaa-select', 'initvalue' => 'h1', 'options' => [
                        ['value' => 'h1', 'label' => 'Überschrift 1'],
                        ['value' => 'h2', 'label' => 'Überschrift 2'],
                        ['value' => 'h3', 'label' => 'Überschrift 3'],
                        ['value' => 'h4', 'label' => 'Überschrift 4'],
                        ['value' => 'h5', 'label' => 'Überschrift 5'],
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
        return '{% if vars.content is not empty %}<{{extras.headingType}}>{{ vars.content }}</{{extras.headingType}}>{% else %}<span class="block__empty-text">Es wurde noch keine Überschrift eingegeben.</span>{% endif %}';
    }
}
