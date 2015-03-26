<?php
namespace cmsadmin\blocks;

class Heading1Block extends \cmsadmin\base\Block
{
    public $renderPath = '@cmsadmin/views/blocks';

    public function jsonFromArray()
    {
        return [
            'vars' => [
                ['var' => 'heading', 'label' => 'Uebeschrift 1', 'type' => 'zaa-input-text'],
            ],
            'cfgs' => [
                ['var' => 'css_class', 'label' => 'CSS Klasse', 'type' => 'zaa-input-text'],
            ],
        ];
    }

    public function getTwigFrontend()
    {
        return '<h1 class="{{ cfgs.css_class }}">{{ vars.heading }}</h1>';
    }

    public function getTwigAdmin()
    {
        return '<h1>{{ vars.heading }} {{ cfgs.css_class }}</h1>';
    }

    public function getName()
    {
        return 'Überschrift 1';
    }
}
