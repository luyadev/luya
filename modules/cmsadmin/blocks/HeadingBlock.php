<?php

namespace cmsadmin\blocks;

class HeadingBlock extends \cmsadmin\base\Block
{
    public $renderPath = '@cmsadmin/views/blocks';

    public function name()
    {
        return 'Überschrift';
    }

    public function config()
    {
        return [
            'vars' => [
                ['var' => 'heading', 'label' => 'Uebeschrift', 'type' => 'zaa-text'],
                ['var' => 'headingType', 'label' => 'Type', 'type' => 'zaa-select', 'options' => [
                        ['value' => 'h1', 'label' => 'Ueberschrift 1 (h1)'],
                        ['value' => 'h2', 'label' => 'Ueberschrift 2 (h2)'],
                        ['value' => 'h3', 'label' => 'Ueberschrift 3 (h3)'],
                        ['value' => 'h4', 'label' => 'Ueberschrift 4 (h4)'],
                        ['value' => 'h5', 'label' => 'Ueberschrift 5 (h5)'],
                        ['value' => 'h6', 'label' => 'Ueberschrift 6 (h6)'],
                    ],
                ],
            ],
            'cfgs' => [
                ['var' => 'css_class', 'label' => 'CSS Klasse', 'type' => 'zaa-text'],
            ],
            'placeholders' => [
                ['var' => 'subito', 'label' => 'Unter']
            ]
        ];
    }

    public function twigFrontend()
    {
        return '<{{ vars.headingType }} class="{{ cfgs.css_class }}">{{ vars.heading }}</{{ vars.headingType }}>';
    }

    public function twigAdmin()
    {
        return '<{{ vars.headingType }}>{{ vars.heading }}</{{ vars.headingType }}>';
    }
}
