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
                ['var' => 'heading', 'label' => 'Titel', 'type' => 'zaa-text'],
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
        return '<{{ vars.headingType }}>{% if vars.heading is empty %}Überschrift{% else %}{{ vars.heading }}{% endif %}</{{ vars.headingType }}>';
    }

    public function twigAdmin()
    {
        return '<p class="block__tag block__tag--{{vars.headingType}}">{% if vars.heading is empty %}Überschrift{% else %}{{ vars.heading }}{% endif %}</p>';
    }
}
